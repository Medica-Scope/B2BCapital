<?php

	/**
	 * @Filename: template-my-opportunities.php
	 * @Description:
	 * @User: NINJA MASTER - Mustafa Shaaban
	 * @Date: 21/2/2023
	 *
	 * Template Name: My Opportunities Page
	 * Template Post Type: page
	 *
	 * @package NinjaHub
	 * @since 1.0
	 */


	use NH\APP\CLASSES\Nh_User;
	use NH\APP\HELPERS\Nh_Hooks;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
	use NH\APP\MODELS\FRONT\Nh_Public;
	use NH\Nh;

	get_header();

	Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
	Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-opportunities', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-opportunities' );

	global $user_ID;
	$opportunity_obj  = new Nh_Opportunity();
	$acquisitions_obj = new Nh_Opportunity_Acquisition();
	$opportunities    = $opportunity_obj->get_profile_opportunities();
	$acquisitions     = $acquisitions_obj->get_profile_acquisitions();

?>
<main class="my-opportunities">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', null, [ 'active_link' => 'opportunities' ] ); ?>
		</nav>

		<section class="my-opportunities container">
			<?php

			if ( Nh_User::get_user_role() === Nh_User::INVESTOR ) {
				?>
			<div class="row row-cols-1 row-cols-md-3 g-4">
				<?php
				foreach ( $acquisitions as $acquisition ) {
					?>
				<div class="opportunity-card">

					<h3>
						<?php echo $acquisition->opportunity->title; ?>
					</h3>

					<span class="date">
						<?php echo date( 'F jS, Y', strtotime( $acquisition->opportunity->created_date ) ); ?>
					</span>

					<p class="short-description">
						<?php echo $acquisition->opportunity->meta_data['short_description']; ?>
					</p>

					<span class="status">
						<?php echo $acquisition->meta_data['acquisition_stage']; ?>
					</span>

				</div>
					<?php
				}
				?>
			</div> <!-- </row-cols-1 -->
				<?php
			} else {
				?>

			<div class="row row-cols-1 row-cols-md-2 g-4">
				<?php
				foreach ( $opportunities as $opportunity ) {
					?>
				<div class="col">
					<?php
					get_template_part(
						'app/Views/template-parts/cards/my-opportunities-card',
						null,
						[
							'opportunity_title'        => $opportunity->title,
							'opportunity_modified'     => $opportunity->modified,
							'opportunity_created_date' => $opportunity->created_date,
							'opportunity_short_description' => $opportunity->meta_data['short_description'],
							'opportunity_stage'        => $opportunity->meta_data['opportunity_stage'],
						]
					);
					?>
				</div>
					<?php
				}
				?>
			</div> <!-- </row-cols-1 -->
				<?php
			}
			?>
		</section>
	</div>
</main><!-- #main -->

<?php
get_footer();
