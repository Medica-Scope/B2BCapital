<?php
/**
 * @Filename: template-my-ignored-opportunities.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Ignored Opportunities Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\CLASSES\Nh_User;
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
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'my_ignored' ] ); ?>
		</nav>

		<section class="page-content opportunity-content">
			<div class="row row-cols-1 row-cols-md-2 g-4 card-group">
				<?php
				foreach ( $opportunities as $opportunity ) {
					$ignore_chk = in_array( $opportunity->ID, empty( $user_obj->profile->meta_data['ignored_opportunities'] ) ? [] : $user_obj->profile->meta_data['ignored_opportunities'] );
					$args       = [ 
						'opportunity_link'         => $opportunity->link,
						'opportunity_title'        => $opportunity->title,
						'opportunity_thumbnail'    => $opportunity->thumbnail,
						'opportunity_created_date' => $opportunity->created_date,
						'is_item_controllers'      => TRUE,
						'opportunity_id'           => $opportunity->ID,
						'is_fav'                   => FALSE,
					];
					?>
					<div class="col">
						<?php get_template_part( 'app/Views/template-parts/cards/opportunity-card-vertical', NULL, $args ); ?>
					</div>
					<?php
				}

				?>
			</div>
		</section>
	</div>
</main><!-- #main -->

<?php get_footer();
