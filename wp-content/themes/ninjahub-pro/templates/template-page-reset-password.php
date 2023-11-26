<?php
/**
 * @Filename: template-page-reset-password.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Reset Password Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-reset-password', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/reset-password' );
?>
<main class="container-fluid h-100 my-account reset-password">
	<div class="row h-100">
		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?= home_url(); ?>" class="app-brand mb-6"><img src="<?= Nh::get_site_logo(); ?>" alt="Nh Site Logo"
					class="img-fluid" /></a>
			<div class="section-header">
				<div class="d-flex flex-row justify-content-between align-items-center">
					<h1 class="section-title">
						<?= __( 'Reset your password', 'ninja' ) ?>
					</h1>
				</div>
			</div>
			<?php
			if ( isset( $_GET['key'] ) ) {
				$key = sanitize_text_field( $_GET['key'] );

				$validate = Nh_User::check_reset_code( $key );

				if ( ! is_wp_error( $validate ) ) {
					echo Nh_Forms::get_instance()
						->create_form( [ 'custom-html-1' => [
							'type'    => 'html',
							'content' => '<div class="row">',
							'order'   => 0,
						],
							'user_password'         => [
								'class'       => '',
								'type'        => 'password',
								'label'       => __( 'Password', 'ninja' ),
								'name'        => 'user_password',
								'required'    => TRUE,
								'placeholder' => __( 'Your Password', 'ninja' ),
								'hint'        => __( "Password should contain at least 1 special character", 'ninja' ),
								'after'       => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon resetCustom" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
								'order'       => 10,
							],
							'user_password_confirm' => [
								'class'       => '',
								'type'        => 'password',
								'label'       => __( 'Confirm Password', 'ninja' ),
								'name'        => 'user_password_confirm',
								'required'    => TRUE,
								'placeholder' => __( 'Confirm Your Password', 'ninja' ),
								'hint'        => __( "Password should contain at least 1 special character", 'ninja' ),
								'before'      => '',
								'after'       => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon reset" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password_confirm"></i>',
								'order'       => 15,
							],
							'user_key'              => [
								'class'    => '',
								'type'     => 'hidden',
								'name'     => 'user_key',
								'required' => TRUE,
								'value'    => $key,
								'order'    => 20,
							],
							'forgot_nonce'          => [
								'class' => '',
								'type'  => 'nonce',
								'name'  => 'change_password_nonce',
								'value' => Nh::_DOMAIN_NAME . "_change_password_form",
								'order' => 20
							],
							'submit'                => [
								'class'               => 'btn-lg text-uppercase',
								'type'                => 'submit',
								'value'               => __( 'Reset Password', 'ninja' ),
								'before'              => '',
								'after'               => '',
								'recaptcha_form_name' => 'frontend_reset_password',
								'order'               => 25
							]
						], [
							'class' => Nh::_DOMAIN_NAME . '-change-password-form',
							'id'    => Nh::_DOMAIN_NAME . '_change_password_form'
						] );

				} else {
					?>
			<p>
				<?= $validate->get_error_message() ?>,
				please follow the link <a href="<?= get_permalink( get_page_by_path( 'my-account/forgot-password' ) ) ?>">Reset
					Password</a>
				to get the new code
			</p>

			<?php
				}

			} else {
				// Set the HTTP status code to 404
				status_header( 404 );

				// Load the 404 template
				get_template_part( '404' );
			}
			?>
			<div class="section-footer">
				<p class="text-start mb-5">
					<?= sprintf( __( "Don't have an account? <a href='%s' class='btn-link text-danger'>New Account!</a>", 'ninja' ), apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ) ) ?>

				</p>
				<p>
					<?= __( 'Copyright © 2023 B2B All rights reserved.', 'ninja' ); ?>
				</p>
			</div>
		</section>

		<?php get_template_part( 'app/Views/template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->

<?php get_footer();
