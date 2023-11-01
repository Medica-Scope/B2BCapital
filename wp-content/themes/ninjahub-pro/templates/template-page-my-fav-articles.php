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
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );

global $user_ID;
$opportunity_obj = new Nh_Opportunity();
$opportunities   = $opportunity_obj->get_profile_fav_opportunities();
$user_obj        = Nh_User::get_current_user();
?>

<main class="my-fav-opportunities">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'my_favorite_article' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/articles-sub-nav', NULL, [ 'active_link' => 'my_favorite_article' ] ); ?>
		</nav>

		<section class="page-content opportunity-content">
			<?php

			foreach ( $opportunities as $opportunity ) {
				$ignore_chk = in_array( $opportunity->ID, empty( $user_obj->profile->meta_data['ignored_opportunities'] ) ? [] : $user_obj->profile->meta_data['ignored_opportunities'] );
				?>
			<div class="opportunity-card">

				<h3>
					<a href="<?= $opportunity->link ?>"></a>
					<?= $opportunity->title ?>
				</h3>

				<span class="date">
					<?= date( 'F jS, Y', strtotime( $opportunity->created_date ) ) ?>
				</span>

				<p class="short-description">
					<?= $opportunity->meta_data['short_description'] ?>
				</p>

				<span class="status">
					<?= $opportunity->meta_data['opportunity_stage'] ?>
				</span>

				<div class="ninja-fav-con">
					<?php
						if ( $fav_chk ) {
							$fav_class = 'bbc-star';
						} else {
							$fav_class = 'bbc-star-o';
						}
						echo Nh_Forms::get_instance()
							->create_form( [
									'opp_id'                    => [
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
						?>
				</div>

				<div class="ninja-ignore-con">
					<button class="ninja-add-to-ignore btn <?= ( $ignore_chk ) ? 'btn-outline-dark' : '' ?>" id="addToIgnore"
						data-uID="<?= $user_ID ?>" data-id="<?= $opportunity->ID ?>" data-type="<?= $opportunity->type ?>"
						type="button">X
					</button>
				</div>

			</div>
			<?php
			}

			?>
		</section>
	</div>
</main><!-- #main -->

<?php get_footer();
