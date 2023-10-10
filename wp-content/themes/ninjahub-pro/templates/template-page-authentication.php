<?php
/**
 * @Filename: template-page-authentication.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Authentication Page
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

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-verification', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/verification' );

get_header();

$user = Nh_User::get_current_user();
?>
<main class="container-fluid h-100">

	<div class="row h-100">

		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?php echo home_url(); ?>" class="app-brand mb-6"><img src="<?php echo Nh::get_site_logo(); ?>"
					alt="Nh Site Logo" class="img-fluid" /></a>
			<div class="section-header">
				<div class="row justify-content-center">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/user.webp" style="max-width:100px" />
					<h1 class="section-title display-2 text-center mb-2">
						<?php echo __( 'Authenticate your account', 'ninja' ); ?>
					</h1>
					<p class="text-center">
						<?php echo __( 'Please enter the OTP – verification Code that has been received on your phone – WhatsApp - email', 'ninja' ); ?>
					</p>
				</div>
			</div>
			<?php

			echo Nh_Forms::get_instance()
				->create_form( [ 
					'custom-html-1'       => [ 
						'type'    => 'html',
						'content' => '<div class="row justify-content-center mb-3">',
						'order'   => 0,
					],
					'code1'               => [ 
						'class'       => 'col otp-digit',
						'type'        => 'tel',
						'name'        => 'code1',
						'required'    => TRUE,
						'placeholder' => __( '0', 'ninja' ),
						'extra_attr'  => [ 
							'maxlength' => '1',
							'autofocus' => 'on',
						],
						'order'       => 5,
					],
					'code2'               => [ 
						'class'       => 'col otp-digit',
						'type'        => 'tel',
						'name'        => 'code2',
						'required'    => TRUE,
						'placeholder' => __( '0', 'ninja' ),
						'extra_attr'  => [ 
							'maxlength' => '1',
						],
						'order'       => 10,
					],
					'code3'               => [ 
						'class'       => 'col otp-digit',
						'type'        => 'tel',
						'name'        => 'code3',
						'required'    => TRUE,
						'placeholder' => __( '0', 'ninja' ),
						'extra_attr'  => [ 
							'maxlength' => '1',
						],
						'order'       => 15,
					],
					'code4'               => [ 
						'class'       => 'col otp-digit',
						'type'        => 'tel',
						'name'        => 'code4',
						'required'    => TRUE,
						'placeholder' => __( '0', 'ninja' ),
						'extra_attr'  => [ 
							'maxlength' => '1',
						],
						'order'       => 20,
					],
					'custom-html-2'       => [ 
						'type'    => 'html',
						'content' => '</div>',
						'order'   => 25,
					],
					'authentication_form' => [ 
						'class' => '',
						'type'  => 'nonce',
						'name'  => 'authentication_nonce',
						'value' => Nh::_DOMAIN_NAME . "_authentication_form",
						'order' => 30
					],
					'custom-html-3'       => [ 
						'type'    => 'html',
						'content' => '<div class="d-flex justify-content-between align-items-center position-relative pb-4">',
						'order'   => 35,
					],
					'custom-html-4'       => [ 
						'type'    => 'html',
						'content' => '<div class=""><p class="ninja-resend-code-patent" data-expire="' . $user->user_meta['verification_expire_date'] . '">' . sprintf( __( "It may take a minute to receive your code. <br> Haven't received it ? <button class='btn btn-link text-primary ninja-resend-code ninja-hidden' type='button'>Resend a new code.</button> <span class='ninja-code-count-down'></span>" ), $user->user_meta['verification_expire_date'] ) . '</p></div>',
						'order'   => 40,
					],
					'submit'              => [ 
						'class'               => 'btn',
						'id'                  => 'authenticationSubmit',
						'type'                => 'submit',
						'value'               => __( 'Authenticate', 'ninja' ),
						'recaptcha_form_name' => 'frontend_authentication',
						'order'               => 45
					],
					'custom-html-5'       => [ 
						'type'    => 'html',
						'content' => '</div>',
						'order'   => 50,
					],
				], [ 
					'class' => Nh::_DOMAIN_NAME . '-authentication-form',
					'id'    => Nh::_DOMAIN_NAME . '_authentication_form'
				] );

			?>
			<div class="section-footer">
				<p>
					<?= __( 'Copyright © 2023 B2B All rights reserved.', 'ninja' ); ?>
				</p>
			</div>
		</section>

		<?php get_template_part( 'template-parts/login-slider-part' ); ?>
	</div>
</main><!-- #main -->


<?php get_footer();
