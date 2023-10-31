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
$opportunities   = $opportunity_obj->get_profile_ignored_opportunities();
$user_obj        = Nh_User::get_current_user();
?>

<main class="my-fav-opportunities">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'my_ignored' ] ); ?>
		</nav>
	</div>

	<section class="page-content opportunity-content">
		<div class="opportunity-list ignore-list">
			<div class="row row-cols-1 row-cols-md-2 g-4 card-group">
				<?php
				if ( ! empty( $opportunities ) ) {
					foreach ( $opportunities as $opportunity ) {
						$ignored_check = $opportunity_obj->is_opportunity_in_user_ignored( $opportunity->ID );
						$ignore_class  = '';
						if ( $ignored_check ) {
							$ignore_class = 'bbc-star';
						} else {
							$ignore_class = 'bbc-star-o';
						}

						$args['ignore_form']  = Nh_Forms::get_instance()
							->create_form( [ 
								'opp_id'                   => [ 
									'type'   => 'hidden',
									'name'   => 'opp_id',
									'before' => '',
									'after'  => '',
									'value'  => $opportunity->ID,
									'order'  => 0
								],
								'ignore_opportunity_nonce' => [ 
									'class' => '',
									'type'  => 'nonce',
									'name'  => 'ignore_opportunity_nonce',
									'value' => Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form",
									'order' => 5
								],
								'submit_ignore'            => [ 
									'class'               => 'btn',
									'id'                  => 'submit_submit_ignore',
									'type'                => 'submit',
									'value'               => '<i class="' . $ignore_class . ' fav-star"></i>',
									'recaptcha_form_name' => 'frontend_ignore',
									'order'               => 10
								],
							], [ 
								'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
							] );
						$args['current_page'] = 'my-ignored-opportunities';

						$args['opportunity'] = $opportunity;
						?>
						<div class="col">
							<?php get_template_part( 'app/Views/opportunities/opportunity-item', NULL, $args ); // GAMAL?>
							<?php // get_template_part('app/Views/template-parts/cards/opportunity-card-vertical', NULL, $args); // KHALED ?>
						</div>
						<?php
					}
				} else {
					get_template_part( 'app/Views/opportunities/opportunities', 'empty' );
				}
				?>
			</div>
		</div>
	</section>
</main><!-- #main -->

<?php get_footer();
