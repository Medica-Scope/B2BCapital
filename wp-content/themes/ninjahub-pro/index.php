<?php

/**
 * @Filename: index.php
 * @Description: Blog Page
 * @User: Ahmed Gamal
 * @Date: 26/9/2023
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-dashboard', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/home-dashboard' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-blogs', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/blogs' );

global $wp_query, $post, $user_ID;
?>

<main class="container container-xxl">

	<?php Nh_Public::breadcrumbs(); ?>

	<h1 class="page-title mb-4">
		<?= __( "Blogs", "ninja" ) ?>
	</h1>
	<div class="container-fluid">
		<div class="blogs-list row row-cols-1 row-cols-md-3 g-4">
			<?php

			$blog_obj          = new Nh_Blog();
			$paged             = 1;
			$fav_articles      = [];
			$queried_post_type = $wp_query->query;

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			}

			$results = $blog_obj->get_all_custom( [ 'publish' ], 12, 'date', 'DESC', [], $user_ID, $paged );

			if ( ! empty( $results ) && isset( $results['posts'] ) ) {
				/* Start the Loop */
				foreach ( $results['posts'] as $single_post ) {
					$args                = [];
					$args['fav_form']    = '';
					$args['ignore_form'] = '';
					if ( ! empty( $user_ID ) ) {
						$fav_chk            = $blog_obj->is_post_in_user_favorites( $single_post->ID );
						$ignore_chk         = $blog_obj->is_post_in_user_ignored( $single_post->ID );
						$args['fav_chk']    = $fav_chk;
						$args['ignore_chk'] = $ignore_chk;
						if ( $fav_chk ) {
							$fav_class = 'bbc-bookmark fav-star';
						} else {
							$fav_class = 'bbc-bookmark-o fav-star';
						}
						$args['fav_form'] = Nh_Forms::get_instance()
							->create_form( [ 
								'post_id'                   => [ 
									'type'   => 'hidden',
									'name'   => 'post_id',
									'before' => '',
									'after'  => '',
									'value'  => $single_post->ID,
									'order'  => 0
								],
								'add_to_fav_nonce'          => [ 
									'class' => '',
									'type'  => 'nonce',
									'name'  => 'add_to_fav_nonce_nonce',
									'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
									'order' => 5
								],
								'submit_add_to_fav_request' => [ 
									'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
									'id'                  => 'submit_add_to_fav_request',
									'type'                => 'submit',
									'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
									'recaptcha_form_name' => 'frontend_add_to_fav',
									'order'               => 10
								],
							], [ 
								'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
							] );
						if ( $ignore_chk ) {
							$ignore_class = 'controll-icon bbc-thumbs-up text-success ignore-star';
						} else {
							$ignore_class = 'controll-icon bbc-thumbs-down text-danger ignore-star';
						}
						$args['ignore_form'] = Nh_Forms::get_instance()
							->create_form( [ 
								'post_id'              => [ 
									'type'   => 'hidden',
									'name'   => 'post_id',
									'before' => '',
									'after'  => '',
									'value'  => $single_post->ID,
									'order'  => 0
								],
								'ignore_article_nonce' => [ 
									'class' => '',
									'type'  => 'nonce',
									'name'  => 'ignore_article_nonce',
									'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
									'order' => 5
								],
								'submit_ignore'        => [ 
									'class'               => 'btn btn-light bg-white ms-2',
									'id'                  => 'submit_submit_ignore',
									'type'                => 'submit',
									'value'               => '<i class="' . $ignore_class . ' ignore-star"></i>',
									'recaptcha_form_name' => 'frontend_ignore',
									'order'               => 10
								],
							], [ 
								'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
							] );
					}
					$args['post'] = $single_post;

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'app/Views/blogs/blogs-item', NULL, $args );
				}
				if(!empty($results['pagination'])){
				?>
					<div class="pagination-con">
						<?php
						echo $results['pagination'];
						?>
					</div>
					<?php
				}

			} else {
				get_template_part( 'app/Views/none' );
			}


			?>
		</div>
	</div>

</main><!-- #main -->

<?php
get_footer();
