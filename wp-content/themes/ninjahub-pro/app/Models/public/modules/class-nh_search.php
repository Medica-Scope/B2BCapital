<?php
/**
 * Filename: class-nh_search.php
 * Description:
 * User: NINJA MASTER - Mustafa Shaaban
 * Date: 1/26/2022
 */


namespace NH\APP\MODELS\FRONT\MODULES;

use NH\APP\CLASSES\Nh_Module;
use NH\APP\CLASSES\Nh_Post;
use NH\Nh;
use WP_Post;
use NH\APP\HELPERS\Nh_Ajax_Response;
use NH\APP\HELPERS\Nh_Hooks;

/**
 * Description...
 *
 * @class Nh_Search
 * @version 1.0
 * @since 1.0.0
 * @package nh
 * @author  - Mustafa Shaaban
 */
class Nh_Search {

	public function __construct() {
		$hooks = new Nh_Hooks();
		$this->actions( $hooks );
		$hooks->run();
	}

	/**
	 * @inheritDoc
	 */
	protected function actions( $hooks ): void {
		$hooks->add_action( 'wp_ajax_' . Nh::_DOMAIN_NAME . '_search_ajax', $this, 'search' );
		$hooks->add_action( 'wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_search_ajax', $this, 'search' );
		$hooks->add_action( 'wp_ajax_' . Nh::_DOMAIN_NAME . '_search_loadmore_ajax', $this, 'loadmore_ajax' );
		$hooks->add_action( 'wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_search_loadmore_ajax', $this, 'loadmore_ajax' );

	}

	public function search() {
		$phrase = sanitize_text_field( $_POST['s'] );
		$type = sanitize_text_field( $_POST['type'] );

		$post_query = new \WP_Query( [ 
			'post_type' => $type,
			'post_status' => 'publish',
			's' => $phrase,
			'posts_per_page' => 10,
		] );


		$results = [];

		if ( $post_query->have_posts() ) {
			while ( $post_query->have_posts() ) {
				$post_query->the_post();
				$results[] = [ 
					'type' => 'post',
					'title' => get_the_title(),
					'permalink' => get_permalink(),
					'slug' => get_post_field( 'post_name', get_the_ID() )
				];
			}
			wp_reset_postdata();
		}

		// $results = array_merge($term_results, $results );
		// uasort( $results, function ($a, $b) {
		// 	return strcmp( $a['type'], $b['type'] );
		// } );

		ob_start();
		get_template_part( './././app/Views/search-ajax', 'template', [ 
			'data' => [ 
				'posts' => $results,
				'count' => count( $results ),
				'key' => $phrase
			]
		] );
		$html = ob_get_clean();

		new Nh_Ajax_Response( TRUE, __( 'Request has been sent successfully!' ), [ 'html' => $html ] );
	}

	public function loadmore_ajax() {

		$data = $_POST['data'];
		$page = intval( $data['page'] );
		$phrase = sanitize_text_field( $data['s'] );

		$posts = new \WP_Query( [ 
			'post_type' => [ 
				'faq',
				'post',
				'service'
			],
			'post_status' => 'publish',
			"posts_per_page" => 10,
			's' => $phrase,
			"paged" => $page,
		] );

		$count = $posts->found_posts;
		$last = FALSE;

		if ( $page * 10 >= $count ) {
			$last = TRUE;
		}

		ob_start();
		foreach ( $posts->get_posts() as $key => $post ) {
			if ( 'count' === $key ) {
				continue;
			}

			$content = apply_filters( 'get_the_excerpt', $post->post_excerpt, $post );
			?>
			<li>
				<a class="result-row" href="<?= get_permalink( $post->ID ) ?>">
					<h4 class="result-head">
						<?= $post->post_title ?>
					</h4>
					<?= self::TrimString( $content, 250 ); ?>...
			</li>
			<?php
		}
		$html = ob_get_clean();

		new Nh_Ajax_Response( TRUE, __( 'Successful Response!', 'nh' ), [ 
			'html' => $html,
			'last' => $last
		] );
	}

	public static function TrimString( $String, $Length ) {
		if ( strlen( $String ) > $Length ) {
			$Temp[0] = substr( $String, 0, $Length );
			$Temp[1] = substr( $String, $Length );
			$SpacePos = strpos( $Temp[1], ' ' );
			if ( $SpacePos !== FALSE ) {
				return $Temp[0] . substr( $Temp[1], 0, $SpacePos );
			}
		}
		return $String;
	}
}