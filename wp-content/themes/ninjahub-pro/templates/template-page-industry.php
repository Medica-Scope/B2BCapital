<?php
/**
 * @Filename: template-page-industry.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Industry Page
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
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-industry', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/industry' );

get_header();
global $user_ID;
$user            = Nh_User::get_current_user();
$opportunity_obj = new Nh_Opportunity();
?>
<main class="container-fluid h-100">
	<div class="row h-100">
		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6 new-industries">
			<!-- App Brand -->
			<a href="<?= home_url(); ?>" class="app-brand mb-6"><img src="<?= Nh::get_site_logo(); ?>" alt="Nh Site Logo"
					class="img-fluid" /></a>
			<div class="section-header">
				<div class="form-steps form-step-1">

					<div class="row justify-content-between after-registration-step-1">
						<h1 class="section-title col-8 display-4 mb-2">
							<?= __( 'Choose which industry you are interested in:', 'ninja' ); ?>
						</h1>
						<div class="steps col-2">
							<div class="steps-circle">
								<div class="steps-circle-fill"></div>
								<div class="steps-number">1/2</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-steps form-step-2 nh-hidden">
					<div class="row justify-content-between after-registration-step-2">
						<h1 class="section-title col-8 display-4 mb-2">
							<?= __( 'For Best Results Please Answer For Questions:', 'ninja' ); ?>
						</h1>
						<div class="steps col-2">
							<div class="steps-circle">
								<div class="steps-circle-fill"></div>
								<div class="steps-number">2/2</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			$terms = $opportunity_obj->get_taxonomy_terms( 'industry' );

			$form_fields = [
				'custom-html-step-1-open'          => [
					'type'    => 'html',
					'content' => "<div class='form-steps form-step-1'>",
					'order'   => 0
				],
				'custom-html-2'                    => [
					'type'    => 'html',
					'content' => "<div class='d-flex justify-content-between align-items-center'><span class='available text-muted'>" . sprintf( __( '(%s Industry Available)', 'ninja' ), count( $terms ) ) . "</span><span class='industries-selected'>" . sprintf( __( '(%s Selected)', 'ninja' ), '<span class="selected-number">0</span>' ) . "</span></div>",
					'order'   => 5
				],
				'industries'                       => [
					'class'       => 'container',
					'input_class' => 'btn-check',
					'label_class' => 'btn btn-outline-light',
					'type'        => 'checkbox',
					'choices'     => [],
					'order'       => 10,
				],
				'continue'                         => [
					'class'      => 'step-wizard',
					'type'       => 'button',
					'value'      => __( 'Continue', 'ninja' ),
					'before'     => '',
					'after'      => '',
					'extra_attr' => [
						'data-target' => 'form-step-2'
					],
					'order'      => 15
				],
				'custom-html-step-1-close'         => [
					'type'    => 'html',
					'content' => "</div>",
					'order'   => 20
				],
				'custom-html-step-2-open'          => [
					'type'    => 'html',
					'content' => "<div class='form-steps form-step-2 nh-hidden'>",
					'order'   => 25
				],

				'target_investment'                   => [
					'class'   => 'container',
					'type'    => 'radio',
					'name'    => 'target_investment',
					'title'   => __( '- What is the targeted investment sector?', 'ninja' ),
					'choices' => [
						[
							'class'      => '',
							'label'      => __( 'Real Estate', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'real-estate',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Startups', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'startups',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Opening foreign markets venture', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'opening-foreign-markets-venture',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Agriculture and food processing', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'agriculture-and-food-processing',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Technology', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'technology',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Logistics', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'logistics',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Non-banking financial services', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'non-banking-financial-services',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Manufacturing', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'manufacturing',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Health Care Companies', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'health-care-companies',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Recycling', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'recycling',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Services Section', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'services-section',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
						[
							'class'      => '',
							'label'      => __( 'Other', 'ninja' ),
							'before'     => '',
							'after'      => '',
							'value'      => 'other',
							'extra_attr' => [],
							'checked'    => '',
							'order'      => 0
						],
					],
					'order'   => 30,
				],

				'size_of_investment'                => [
					'class'       => Nh_User::get_user_role() !== Nh_User::INVESTOR ? 'd-none' : '',
					'type'        => 'text',
					'label'       => __('- Size of investment', 'ninja'),
					'name'        => 'size_of_investment',
					'value'       => '',
					'required'    => TRUE,
					'placeholder' => __('Enter your answer', 'ninja'),
					'order'       => 35,
				],

				'investment_criteria'                => [
					'class'       => Nh_User::get_user_role() !== Nh_User::INVESTOR ? 'd-none' : '',
					'type'        => 'text',
					'label'       => __('- What is Your Investment criteria?', 'ninja'),
					'name'        => 'investment_criteria',
					'value'       => '',
					'required'    => TRUE,
					'placeholder' => __('Enter your answer', 'ninja'),
					'order'       => 35,
				],
				'external_or_long_term'                => [
					'class'       => Nh_User::get_user_role() !== Nh_User::INVESTOR ? 'd-none' : '',
					'type'        => 'text',
					'label'       => __('- External or long-term?', 'ninja'),
					'name'        => 'external_or_long_term',
					'value'       => '',
					'required'    => TRUE,
					'placeholder' => __('Enter your answer', 'ninja'),
					'order'       => 35,
				],
				'buying_shares'                => [
					'class'       => Nh_User::get_user_role() !== Nh_User::INVESTOR ? 'd-none' : '',
					'type'        => 'text',
					'label'       => __('- Investing in companies by entering in a capital increase or buying shares from shareholders?', 'ninja'),
					'name'        => 'buying_shares',
					'value'       => '',
					'required'    => TRUE,
					'placeholder' => __('Enter your answer', 'ninja'),
					'order'       => 35,
				],



				'industries_nonce'                 => [
					'class' => '',
					'type'  => 'nonce',
					'name'  => 'industries_nonce',
					'value' => Nh::_DOMAIN_NAME . "_industries_form",
					'order' => 40
				],
				'custom-html-action-buttons'       => [
					'type'    => 'html',
					'content' => "<div class='row action-buttons'>",
					'order'   => 45
				],
				'submit'                           => [
					'class'               => 'btn-success',
					'type'                => 'submit',
					'value'               => __( 'Finish and go to dashboard', 'ninja' ),
					'before'              => '',
					'after'               => '',
					'recaptcha_form_name' => 'frontend_industries',
					'order'               => 50
				],
				'back'                             => [
					'class'      => 'btn-light text-black step-wizard',
					'type'       => 'button',
					'value'      => __( 'Back', 'ninja' ),
					'before'     => '',
					'after'      => '',
					'extra_attr' => [
						'data-target' => 'form-step-1'
					],
					'order'      => 55
				],
				'custom-html-action-buttons-close' => [
					'type'    => 'html',
					'content' => "</div>",
					'order'   => 60
				],
				'custom-html-step-2-close'         => [
					'type'    => 'html',
					'content' => "</div>",
					'order'   => 65
				],
			];
			$form_tags   = [
				'class' => Nh::_DOMAIN_NAME . '-industries-form',
				'id'    => Nh::_DOMAIN_NAME . '_industries_form'
			];

			foreach ( $terms as $key => $term ) {
				$icon_id                                = get_term_meta( $term->term_id, 'icon', TRUE );
				$icon_link                              = (int) $icon_id > 0 ? wp_get_attachment_image_url( $icon_id ) : '';
				$hidden_class                           = $key > 4 ? 'hidden-tag' : '';
				$form_fields['industries']['choices'][] = [
					'class' => 'industries-tags col-auto ' . $hidden_class,
					'label' => ! empty( $icon_link ) ? '<img src="' . $icon_link . '" alt="Industry Icon"/> ' . $term->name : $term->name,
					'name'  => 'industries',
					'value' => $term->term_id,
					'order' => $key
				];
				if ( count( $terms ) > 4 && count( $terms ) - 1 === $key ) {
					$rest                            = count( $terms ) - 5;
					$form_fields['custom-html-last'] = [
						'type'    => 'html',
						'content' => "<a href='javascript:(0);' class='show-tags'>" . sprintf( __( '%s more..', 'ninja' ), $rest ) . "</a>",
						'order'   => 10
					];
				}
			}
			echo Nh_Forms::get_instance()
				->create_form( $form_fields, $form_tags );
			?>
			<div class="section-footer">
				<p>
					<?= __( 'Copyright © 2023 B2B All rights reserved.', 'ninja' ); ?>
				</p>
			</div>
		</section>

		<?php get_template_part( 'app/Views/template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->

<?php get_footer();
