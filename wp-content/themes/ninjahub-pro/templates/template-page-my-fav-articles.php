<?php
/**
 * @Filename: template-my-fav-articles.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Favorite Articles Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */
use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-blogs', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/blogs' );

global $user_ID, $wp_query;
$Blog_obj = new Nh_Blog();
// $blogs    = $Blog_obj->get_profile_favorite_articles();
$favorite_articles = [];
if ( ! empty( $user_ID ) ) {
	$profile_id  = get_user_meta( $user_ID, 'profile_id', TRUE );
	$profile_obj = new Nh_Profile();
	$profile     = $profile_obj->get_by_id( (int) $profile_id );
	if ( ! is_wp_error( $profile ) ) {
		$favorite_articles = is_array( $profile->meta_data['favorite_articles'] ) ? $profile->meta_data['favorite_articles'] : [];
	}
}
$user_obj = Nh_User::get_current_user();
?>

<main class="my-fav-articles">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'my_favorite_article' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/articles-sub-nav', NULL, [ 'active_link' => 'my_favorite_article' ] ); ?>
		</nav>

		<section class="page-content opportunity-content">
			<div class="container-fluid">
				<div class="blogs-list row row-cols-1 row-cols-md-3 g-4">
					<?php
					$blog_obj          = new Nh_Blog();
					$paged             = 1;
					$queried_post_type = $wp_query->query;
					if ( ! empty( $favorite_articles ) ) {
						if ( get_query_var( 'paged' ) ) {
							$paged = get_query_var( 'paged' );
						}

						$results = $blog_obj->get_all_custom( [ 'publish' ], 12, 'date', 'DESC', [], $user_ID, $paged, $favorite_articles );

						if ( ! empty( $results ) && isset( $results['posts'] ) ) {
							/* Start the Loop */
							foreach ( $results['posts'] as $single_post ) {
								$args                = [];
								$args['fav_form']    = '';
								$args['ignore_form'] = '';
								if ( ! empty( $user_ID ) ) {
									$args['fav_chk']  = true;
									$fav_class        = 'bbc-star';
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
								}
								$args['post'] = $single_post;

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'app/Views/blogs/blogs-item', NULL, $args );
							}

							?>
							<div class="pagination-con">
								<?php
								echo $results['pagination'];
								?>
							</div>
							<?php

						} else {
							get_template_part( 'app/Views/blogs/blogs', 'empty' );
						}
					} else {
						get_template_part( 'app/Views/blogs/blogs', 'empty' );
					}
					?>
				</div>
			</div>
		</section>
	</div>
</main><!-- #main -->

<?php get_footer();
