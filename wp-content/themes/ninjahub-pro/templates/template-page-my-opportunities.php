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
use NH\APP\HELPERS\Nh_Forms;
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
$acquisitions     = $acquisitions_obj->get_profile_acquisitions( TRUE );

?>
<main class="my-opportunities">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'opportunities' ] ); ?>
		</nav>
		<div class="filters mb-5">
			<button class="btn btn-outline-warning opportunity-adv-filter" type="button" data-bs-toggle="collapse"
				data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
				<i class="bbc-sliders"></i>
				<?= __( 'Advanced Filters', 'ninja' ) ?>
			</button>
			<div class="collapse" id="collapseFilter">
				<div class="filter-con">
					<div class="opportunities-filter">
						<?php
						$form_tags = [
							'class' => Nh::_DOMAIN_NAME . '-filter-opportunity-form',
							'id'    => Nh::_DOMAIN_NAME . '_filter_opportunity_form'
						];

						$opportunities_type_terms = $opportunity_obj->get_taxonomy_terms( 'opportunity-type' );
						$form_fields              = [];
						if ( ! empty( $opportunities_type_terms ) ) {
							$form_fields['opportunity_type'] = [
								'class'             => 'col-5 pe-2',
								'type'              => 'select',
								'label'             => __( 'Opportunity Type', 'ninja' ),
								'name'              => 'opportunity_type',
								'placeholder'       => __( 'Select opportunity type', 'ninja' ),
								'options'           => [],
								'default_option'    => '',
								'select_option'     => [],
								'extra_option_attr' => [],
								'before'            => '',
								'order'             => 10,
							];
							foreach ( $opportunities_type_terms as $key => $term ) {
								$status = get_term_meta( $term->term_id, 'status', TRUE );
								if ( intval( $status ) !== 1 ) {
									continue;
								}
								$form_fields['opportunity_type']['options'][ $term->term_id ]           = $term->name;
								$form_fields['opportunity_type']['extra_option_attr'][ $term->term_id ] = [
									'data-target' => get_term_meta( $term->term_id, 'unique_type_name', TRUE ),
								];
							}
						}
						$form_fields['opportunity_status']       = [
							'class'             => 'col-5 ps-2',
							'type'              => 'select',
							'label'             => __( 'Opportunity Status', 'ninja' ),
							'name'              => 'opportunity_status',
							'placeholder'       => __( 'Select opportunity status', 'ninja' ),
							'default_option'    => '',
							'options'           => [
								'new'              => __( 'New', 'ninja' ),
								'cancel'           => __( 'Cancel', 'ninja' ),
								'hold'             => __( 'Hold', 'ninja' ),
								'approved'         => __( 'Approved', 'ninja' ),
								'content-verified' => __( 'Content Verified', 'ninja' ),
								'content-rejected' => __( 'Content Rejected', 'ninja' ),
								'seo-verified'     => __( 'Seo Verified', 'ninja' ),
								'translated'       => __( 'Translated', 'ninja' ),
								'publish'          => __( 'Publish', 'ninja' ),
							],
							'select_option'     => [],
							'extra_option_attr' => [],
							'before'            => '',
							'order'             => 20,
						];
						$form_fields['filter_opportunity_nonce'] = [
							'class' => '',
							'type'  => 'nonce',
							'name'  => 'filter_opportunity_nonce',
							'value' => Nh::_DOMAIN_NAME . "_filter_opportunity_form",
							'order' => 30
						];
						$form_fields['submit']                   = [
							'class'               => 'btn-lg text-uppercase ',
							'type'                => 'submit',
							'id'                  => Nh::_DOMAIN_NAME . '_filter_opportunity_submit',
							'value'               => '<i class="bbc-save pe-1"></i> ' . __( 'Filter', 'ninja' ),
							'before'              => '',
							'after'               => '',
							'recaptcha_form_name' => 'frontend_filter_opportunity',
							'order'               => 40
						];
						if ( $form_fields ) {
							echo Nh_Forms::get_instance()
								->create_form( $form_fields, $form_tags );
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<section class="my-opportunities container-fluid">
			<?php
			if ( Nh_User::get_user_role() === Nh_User::INVESTOR ) {
				if ( ! empty( $acquisitions ) ) {
					?>
			<div class="row content-ajax row-cols-1 row-cols-md-3 g-4">
				<?php foreach ( $acquisitions as $acquisition ) { ?>
				<div class="opportunity-card">

					<h3>
						<a href="<?= $acquisition->opportunity->link ?>">
							<?= $acquisition->opportunity->title; ?>
						</a>
					</h3>

					<span class="date">
						<?= date( 'F jS, Y', strtotime( $acquisition->opportunity->created_date ) ); ?>
					</span>

					<p class="short-description">
						<?= $acquisition->opportunity->meta_data['short_description']; ?>
					</p>

					<span class="status">
						<?= $acquisition->meta_data['acquisitions_stage']; ?>
					</span>

				</div>
				<?php } ?>
			</div> <!-- </row-cols-1 -->
			<?php
				} else {
					get_template_part( 'app/Views/template-parts/cards/my-opportunities-empty', NULL, [] );
				}
			} else {
				if ( ! empty( $opportunities ) ) {
					?>
			<div class="row row-cols-1 content-ajax row-cols-md-2 row-cols-lg-3 g-4">
				<?php
						foreach ( $opportunities as $opportunity ) {
							?>
				<div class="col">
					<?php
								get_template_part( 'app/Views/template-parts/cards/my-opportunities-card', NULL, [
									'opportunity_title'             => $opportunity->title,
									'opportunity_link'              => $opportunity->link,
									'opportunity_modified'          => $opportunity->modified,
									'opportunity_created_date'      => $opportunity->created_date,
									'opportunity_short_description' => $opportunity->meta_data['short_description'],
									'opportunity_stage'             => $opportunity->meta_data['opportunity_stage'],
								] );
								?>
				</div>
				<?php
						}
						?>
			</div> <!-- </row-cols-1 -->
			<?php
				} else {
					get_template_part( 'app/Views/template-parts/cards/my-opportunities-empty', NULL, [] );
				}
			}
			?>
		</section>
	</div>
</main><!-- #main -->

<?php
get_footer();
