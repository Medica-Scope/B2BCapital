<?php
/**
 * @Filename: template-page-forgot-password.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Forgot Password Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-forgot-password', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/forgot-password' );
?>


<main class="container-fluid h-100">

	<div class="row h-100">

		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?= home_url(); ?>" class="app-brand mb-6"><img src="<?= Nh::get_site_logo(); ?>"
					alt="Nh Site Logo" class="img-fluid" /></a>
			<div class="section-header">
				<div class="d-flex flex-row justify-content-between align-items-center">
					<h1 class="section-title">
						<?php __( 'Forgot password', 'ninja' ); ?>
					</h1>
				</div>
			</div>
			<?php
			echo Nh_Forms::get_instance()
				->create_form( [
					'user_email_phone' => [
						'class'       => 'has-header form-field',
						'type'        => 'text',
						'label'       => __( 'Phone Number or Email', 'ninja' ),
						'name'        => 'user_email_phone',
						'required'    => TRUE,
						'placeholder' => __( 'Ex. email@gmail.com', 'ninja' ),
						'order'       => 0,
					],
					'forgot_nonce'     => [
						'class' => '',
						'type'  => 'nonce',
						'name'  => 'forgot_nonce',
						'value' => Nh::_DOMAIN_NAME . "_forgot_form",
						'order' => 15,
					],
					'submit'           => [
						'class'               => 'button_state form-action bbc-btn btn-primary large apply',
						'type'                => 'submit',
						'value'               => __( 'Send', 'ninja' ),
						'before'              => '',
						'after'               => '',
						'recaptcha_form_name' => 'frontend_forgot_password',
						'order'               => 20,
					]
				], [
					'class' => Nh::_DOMAIN_NAME . '-forgot-form',
					'id'    => Nh::_DOMAIN_NAME . '_forgot_form',
				] );
			/** TODO!: create function to return copyrights */
			?>

			<div class="section-footer">
				<p><?= __('Copyright © 2023 B2B All rights reserved.', 'ninja'); ?></p>
			</div>
		</section>

		<?php get_template_part( 'app/Views/template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->

<?php get_footer();
