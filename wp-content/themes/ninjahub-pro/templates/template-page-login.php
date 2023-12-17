<?php
/**
 * @Filename: template-page-login.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Login Page
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

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-login-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/login' );
?>
<main class="container-fluid h-100">

	<div class="row h-100">

		<section class="login-section container-xl col-12 col-md-6 py-5 px-3 px-md-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?= home_url(); ?>" class="app-brand mb-6"><img src="<?= Nh::get_site_logo(); ?>" alt="Nh Site Logo"
					class="img-fluid" /></a>
			<div class="section-header">
				<div class="d-flex flex-row justify-content-between align-items-center">
					<h1 class="section-title">
						<?= __( 'Login', 'ninja' ) ?>
					</h1>
				</div>

				<div class="social-login">
					<?php
					if ( class_exists( 'NextendSocialLogin', false ) ) {
						echo NextendSocialLogin::renderButtonsWithContainer();
					}

					echo do_shortcode("[TheChamp-Login]");
					?>
					<!-- <a href="#" class="bbc-btn medium has-icon google"><i class="bbc-google-plus"></i> Google</a> -->
					<!-- <a href="#" class="bbc-btn medium has-icon linkedin"><i class="bbc-linkedin-square"></i>
						LinkedIn</a> -->
					<!-- <a href="#" class="bbc-btn medium has-icon facebook"><i class="bbc-facebook-square"></i>
						Facebook</a> -->
				</div>

				<div class="or-separator">
					<span class="separator-line left-line"></span>
					<span class="separator-text">
						<?= __( 'OR', 'ninja' ) ?>
					</span>
					<span class="separator-line right-line"></span>
				</div>
			</div>
			<?php
			echo Nh_Forms::get_instance()
				->create_form( [ 
					'custom-html-1' => [ 
						'type'    => 'html',
						'content' => '<div class="d-flex flex-row flex-wrap col-12">',
						'order'   => 0,
					],
					'user_login'    => [ 
						'class'       => 'form-field form-field-has-icon col-12 col-md-6 pe-md-3',
						'type'        => 'text',
						'label'       => __( 'Email or phone number', 'ninja' ),
						'name'        => 'user_login',
						'required'    => TRUE,
						'placeholder' => __( 'Enter your email or phone number', 'ninja' ),
						'before'      => '<i class="bbc-mail1"></i>',
						'order'       => 5,
					],
					'user_password' => [ 
						'class'       => 'form-field form-field-has-icon col-12 col-md-6 ps-md-3',
						'type'        => 'password',
						'label'       => __( 'Password', 'ninja' ),
						'name'        => 'user_password',
						'required'    => TRUE,
						'placeholder' => __( 'Enter your password', 'ninja' ),
						'before'      => '<i class="bbc-lock2"></i>',
						'after'       => '<i class="bbc-eye1 showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
						'order'       => 10,
					],
					'rememberme'    => [ 
						'class'   => 'form-field col-6 align-items-start ps-3 m-0',
						'type'    => 'checkbox',
						'choices' => [ 
							[ 
								'class' => ' ',
								'label' => 'Remember me',
								'name'  => 'rememberme',
								'value' => '1',
								'order' => 0,
							],
						],
						'order'   => 15,
					],
					'custom-html-3' => [ 
						'type'    => 'html',
						'content' => '<div class="form-field col-6 align-items-end pe-3 m-0" ><a href="' . apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/forgot-password' ) ) ) . '" class="btn-link text-accent"> ' . __( 'Forgot your Password?', 'ninja' ) . ' </a></div></div>',
						'order'   => 20,
					],
					'login_nonce'   => [ 
						'class' => '',
						'type'  => 'nonce',
						'name'  => 'login_nonce',
						'value' => Nh::_DOMAIN_NAME . "_login_form",
						'order' => 25,
					],
					'submit'        => [ 
						'class'               => 'form-action bbc-btn btn-primary large apply',
						'type'                => 'submit',
						'value'               => __( 'Login', 'ninja' ),
						'before'              => '',
						'after'               => '',
						'recaptcha_form_name' => 'frontend_login',
						'order'               => 25,
					],
				], [ 
					'class' => Nh::_DOMAIN_NAME . '-login-form',
					'id'    => Nh::_DOMAIN_NAME . '_login_form',
				] );
			/** TODO!: create function to return copyrights */
			?>

			<div class="section-footer">
				<p class="text-start mb-5">
					<?= sprintf( __( "Don't have an account? <a href='%s' class='btn-link text-accent'>New Account!</a>", 'ninja' ), apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ) ) ?>

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