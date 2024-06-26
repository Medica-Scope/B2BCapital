<?php
/**
 * @Filename: class-nh_blog.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 5/10/2023
 */


namespace NH\APP\MODELS\FRONT\MODULES;

use NH\APP\CLASSES\Nh_Module;
use NH\APP\CLASSES\Nh_Post;
use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Ajax_Response;
use NH\Nh;
use WP_Post;


/**
 * Description...
 *
 * @class Nh_Blog
 * @version 1.0
 * @since 1.0.0
 * @package NinjaHub
 * @author Mustafa Shaaban
 */
class Nh_Blog extends Nh_Module {
	public array $meta_data = [ 
		'cover',
		'opportunity'
	];
	public array $taxonomy = [ 
		'category',
		'post_tag'
	];

	public function __construct() {
		parent::__construct( 'post' );
	}

	/**
	 * Description...
	 *
	 * @param \WP_Post $post
	 * @param array    $meta_data
	 *
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Mustafa Shaaban
	 * @return \NH\APP\CLASSES\Nh_Post
	 */
	public function convert( WP_Post $post, array $meta_data = [] ): Nh_Post {
		return parent::convert( $post, $this->meta_data ); // TODO: Change the autogenerated stub
	}

	/**
	 * @inheritDoc
	 */
	protected function actions( $module_name ): void {
		// TODO: Implement actions() method.
		$this->hooks->add_action( 'wp_ajax_' . Nh::_DOMAIN_NAME . '_toggle_favorite_ajax', $this, 'toggle_post_favorite' );
		$this->hooks->add_action( 'wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_toggle_favorite_ajax', $this, 'toggle_post_favorite' );
		$this->hooks->add_action( 'wp_ajax_' . Nh::_DOMAIN_NAME . '_ignore_article_ajax', $this, 'ignore_article' );
		$this->hooks->add_action( 'wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_ignore_article_ajax', $this, 'ignore_article' );
	}

	/**
	 * @inheritDoc
	 */
	protected function filters( $module_name ): void {
		// TODO: Implement filters() method.
	}

	/**
	 * Description...toggle fav article and save it to user's favorite list
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Ahmed Gamal
	 */
	public function toggle_post_favorite(): void {

		global $user_ID;
		$form_data                     = $_POST['data'];
		$post_id                       = (int) sanitize_text_field( $form_data['post_id'] );
		$recaptcha_response            = sanitize_text_field( $form_data['g-recaptcha-response'] );
		$_POST["g-recaptcha-response"] = $recaptcha_response;
		$article = $this->get_by_id($post_id);


		if ( ! wp_verify_nonce( $form_data['add_to_fav_nonce_nonce'], Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form" ) ) {
			new Nh_Ajax_Response( FALSE, __( "Something went wrong!.", 'ninja' ) );
		}

		$check_result = apply_filters( 'gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_add_to_fav' );

		if ( $check_result !== TRUE ) {
			new Nh_Ajax_Response( FALSE, __( $check_result, 'ninja' ) ); /* the reCAPTCHA answer  */
		}
		$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj = new Nh_Profile();
		$profile     = $profile_obj->get_by_id( (int) $profile_id );
		$favorites   = [];
		if ( ! is_wp_error( $profile ) ) {
			$favorites = ( $profile->meta_data['favorite_articles'] ) ? $profile->meta_data['favorite_articles'] : [];
			if ( in_array( $post_id, $favorites ) ) {
				$key = array_search( $post_id, $favorites );
				if ( $key !== FALSE ) {
					unset( $favorites[ $key ] );
				}
				$profile->set_meta_data( 'favorite_articles', $favorites );
				$profile->update();
				$fav_count = get_post_meta( $post_id, 'fav_count', TRUE );
				update_post_meta( $post_id, 'fav_count', (int) $fav_count - 1 );
				new Nh_Ajax_Response( TRUE, sprintf(__('<strong>%s</strong> has been removed from favorites', 'ninja'), $article->title), [
					'fav_active'   => 1,
					'updated_text' => __( 'Favorite', 'ninja' ),
					'button_text' => __('Done', 'ninja')
				] );
			} else {
				$favorites[] = $post_id;
				$profile->set_meta_data( 'favorite_articles', $favorites );
				$profile->update();
				$fav_count = get_post_meta( $post_id, 'fav_count', TRUE );
				update_post_meta( $post_id, 'fav_count', (int) $fav_count + 1 );
				new Nh_Ajax_Response( TRUE, sprintf(__('<strong>%s</strong> has been added to favorites', 'ninja'), $article->title), [
					'fav_active'   => 0,
					'updated_text' => __( 'Added to favorites', 'ninja' ),
					'button_text' => __('Done', 'ninja')
				] );
			}
		} else {
			new Nh_Ajax_Response( FALSE, __( 'Error Response!', 'ninja' ), [ 
				'status'     => FALSE,
				'msg'        => 'You must have profile',
				'fav_active' => 1
			] );
		}
	}

	/**
	 * Description...Check if post exists in user's favorite list
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 *
	 * @param post_id
	 *
	 * @author Ahmed Gamal
	 * @return bool
	 */
	public function is_post_in_user_favorites( $post_id ): bool {
		global $user_ID;

		$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj = new Nh_Profile();
		$profile     = $profile_obj->get_by_id( (int) $profile_id );
		$favorites   = [];
		if ( ! is_wp_error( $profile ) ) {
			$favorites = is_array( $profile->meta_data['favorite_articles'] ) ? $profile->meta_data['favorite_articles'] : [];
			$favorites = array_combine( $favorites, $favorites );
		}
		return isset( $favorites[ $post_id ] );
	}

	public function get_profile_fav_articles(): array {
		global $user_ID;

		$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj = new Nh_Profile();
		$profile     = $profile_obj->get_by_id( (int) $profile_id );
		$Nh_articles = [];

		if ( ! is_wp_error( $profile ) ) {
			$fav_ids = is_array( $profile->meta_data['favorite_articles'] ) ? $profile->meta_data['favorite_articles'] : [];

			if ( ! empty( $fav_ids ) ) {
				$articles = new \WP_Query( [ 
					'post_type'   => $this->module,
					'post_status' => 'publish',
					'orderby'     => 'ID',
					'order'       => 'DESC',
					"post__in"    => $profile->meta_data['favorite_articles'],
				] );
				foreach ( $articles->get_posts() as $opportunity ) {
					$Nh_articles[] = $this->convert( $opportunity, $this->meta_data );
				}
			}
		}

		return $Nh_articles;
	}

	/**
	 * Description...ignore article and save it to user's ignored list
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Ahmed Gamal
	 * @return void
	 */
	public function ignore_article(): void {
		global $user_ID, $wp;
		$form_data                     = $_POST['data'];
		$post_id                       = (int) sanitize_text_field( $form_data['post_id'] );
		$recaptcha_response            = sanitize_text_field( $form_data['g-recaptcha-response'] );
		$_POST["g-recaptcha-response"] = $recaptcha_response;
		$article = $this->get_by_id($post_id);

		if ( ! wp_verify_nonce( $form_data['ignore_article_nonce'], Nh::_DOMAIN_NAME . "_ignore_article_nonce_form" ) ) {
			new Nh_Ajax_Response( FALSE, __( "Something went wrong!.", 'ninja' ) );
		}

		$check_result = apply_filters( 'gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_ignore' );

		if ( $check_result !== TRUE ) {
			new Nh_Ajax_Response( FALSE, __( $check_result, 'ninja' ) ); /* the reCAPTCHA answer  */
		}

		$profile_id       = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj      = new Nh_Profile();
		$profile          = $profile_obj->get_by_id( (int) $profile_id );
		$ignored_articles = [];
		if ( ! is_wp_error( $profile ) ) {
			$ignored_articles = ( $profile->meta_data['ignored_articles'] ) ? $profile->meta_data['ignored_articles'] : [];
			$ignored_articles = array_combine( $ignored_articles, $ignored_articles );
			if ( isset( $ignored_articles[ $post_id ] ) ) {
				unset( $ignored_articles[ $post_id ] );
				$ignored_articles = array_values( $ignored_articles );
				$profile->set_meta_data( 'ignored_articles', $ignored_articles );
				$profile->update();
				$ignore_count = get_post_meta( $post_id, 'ignore_count', TRUE );
				update_post_meta( $post_id, 'ignore_count', (int) $ignore_count + 1 );
				new Nh_Ajax_Response( TRUE, sprintf(__('<strong>%s</strong> has been un-ignored', 'ninja'), $article->title), [
					'ignore_active'   => 1,
					'updated_text' => __( 'Ignore', 'ninja' ),
					'button_text' => __('Done', 'ninja')
				] );
			} else {
				$ignored_articles[] = $post_id;
				$profile->set_meta_data( 'ignored_articles', $ignored_articles );
				$profile->update();
				$ignore_count = get_post_meta( $post_id, 'ignore_count', TRUE );
				update_post_meta( $post_id, 'ignore_count', (int) $ignore_count - 1 );

				new Nh_Ajax_Response( TRUE, sprintf(__('<strong>%s</strong> has been ignored', 'ninja'), $article->title), [
					'ignore_active'   => 0,
					'updated_text' => __( 'Ignored', 'ninja' ),
					'button_text' => __('Done', 'ninja')
				] );
			}
		} else {
			new Nh_Ajax_Response( TRUE, __( 'Error Response!', 'ninja' ), [ 
				'status'        => FALSE,
				'msg'           => 'You must have profile',
				'ignore_active' => 1
			] );
		}
	}

	/**
	 * Description...Check if post exists in user's favorite list
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 *
	 * @param post_id
	 *
	 * @author Ahmed Gamal
	 * @return bool
	 */
	public function is_post_in_user_ignored( $post_id ): bool {
		global $user_ID;

		$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj = new Nh_Profile();
		$profile     = $profile_obj->get_by_id( (int) $profile_id );
		$ignored     = [];
		if ( ! is_wp_error( $profile ) ) {
			$ignored = is_array( $profile->meta_data['ignored_articles'] ) ? $profile->meta_data['ignored_articles'] : [];
			$ignored = array_combine( $ignored, $ignored );
		}
		return isset( $ignored[ $post_id ] );
	}

	public function get_profile_ignored_articles(): array {
		global $user_ID;

		$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
		$profile_obj = new Nh_Profile();
		$profile     = $profile_obj->get_by_id( (int) $profile_id );
		$Nh_articles = [];

		if ( ! is_wp_error( $profile ) ) {
			$ignored_ids = is_array( $profile->meta_data['ignored_articles'] ) ? $profile->meta_data['ignored_articles'] : [];

			if ( ! empty( $ignored_ids ) ) {
				$articles = new \WP_Query( [ 
					'post_type'   => $this->module,
					'post_status' => 'publish',
					'orderby'     => 'ID',
					'order'       => 'DESC',
					"post__in"    => $profile->meta_data['ignored_articles'],
				] );
				foreach ( $articles->get_posts() as $opportunity ) {
					$Nh_articles[] = $this->convert( $opportunity, $this->meta_data );
				}
			}
		}

		return $Nh_articles;
	}

	/**
	 * Description...increase read count for single viewed post, also set cookie (expires in 30 days) for the viewed posts
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Ahmed Gamal
	 * @return bool
	 */
	public function increment_read_count( $post_id ) {

		if ( isset( $_COOKIE['viewed_posts'] ) && in_array( $post_id, json_decode( stripslashes( $_COOKIE['viewed_posts'] ) ), TRUE ) ) {
			return;
		}
		$current_count = get_post_meta( $post_id, 'read_count', TRUE );
		$new_count     = empty( $current_count ) ? 1 : $current_count + 1;
		update_post_meta( $post_id, 'read_count', $new_count );

		$viewed_posts   = isset( $_COOKIE['viewed_posts'] ) ? json_decode( stripslashes( $_COOKIE['viewed_posts'] ), TRUE ) : [];
		$viewed_posts[] = $post_id;
		setcookie( 'viewed_posts', json_encode( $viewed_posts ), time() + ( 30 * DAY_IN_SECONDS ), '/' );
	}

	/**
	 * Description... overriding get_all in nh_post class
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Ahmed Gamal
	 * @return bool
	 */
	public function get_all_custom( array $status = [ 'any' ], int $limit = 10, string $orderby = 'ID', string $order = 'DESC', array $not_in = [ '0' ], int $user_id = 0, int $page = 1, array $in = [] ): array {
		if ( $user_id ) {
			$profile_id  = get_user_meta( $user_id, 'profile_id', TRUE );
			$profile_obj = new Nh_Profile();
			$profile     = $profile_obj->get_by_id( (int) $profile_id );
			// $fav_articles = $profile->meta_data['favorite_articles'];
			if ( ! is_wp_error( $profile ) ) {
				$not_in = ( $profile->meta_data['ignored_articles'] ) ? $profile->meta_data['ignored_articles'] : []; // for ignored articles
			}
		}
		$args = [ 
			"post_type"      => $this->module,
			"post_status"    => $status,
			"posts_per_page" => $limit,
			'paged'          => $page,
			"orderby"        => $orderby,
			"post__not_in"   => $not_in,
			"order"          => $order,
		];
		if ( ! empty( $in ) ) {
			$args['post__in'] = $in;
		}
		$posts    = new \WP_Query( $args );
		$Nh_Posts = [];

		if ( $posts->get_posts() ) {
			foreach ( $posts->get_posts() as $post ) {
				$Nh_Posts['posts'][] = $this->convert( $post, $this->meta_data );
			}
		} else {
			$Nh_Posts['posts'] = [];
		}
		$Nh_Posts['pagination'] = $this->get_pagination( $args );
		return $Nh_Posts;
	}

	public function get_pagination( array $args ) {
		$all_posts                   = $args;
		$all_posts['posts_per_page'] = -1;
		$all_posts['fields']         = 'ids';
		$all_posts                   = new \WP_Query( $all_posts );
		$count                       = $all_posts->found_posts;
		$big                         = 999999999;
		$pagination                  = paginate_links( [ 
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => ceil( $count / $args['posts_per_page'] ),
			'prev_text' => __( '« Previous' ),
			'next_text' => __( 'Next »' ),
		] );

		return $pagination;
	}
}
