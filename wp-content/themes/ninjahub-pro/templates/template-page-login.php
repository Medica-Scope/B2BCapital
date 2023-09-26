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

		<section class="login-section container-xl col-12 col-md-6 py-5 px-5 px-xl-6">
			<!-- App Brand -->

			<a href="<?php echo home_url(); ?>" class="app-brand mb-6"><img src="<?php echo Nh::get_site_logo(); ?>"
					alt="Nh Site Logo" class="img-fluid" /></a>
			<div class="section-header">
				<div class="d-flex flex-row justify-content-between align-items-center">
					<h1 class="section-title">Sign Up</h1>
					<p>I have account! <a href="#" class="btn-link text-accent">Login</a></p>
				</div>

				<div class="social-login">
					<?php /** echo do_shortcode( '[nextend_social_login]' ); */?>
					<a href="#" class="bbc-btn medium has-icon google"><i class="bbc-google-plus"></i> Google</a>
					<a href="#" class="bbc-btn medium has-icon linkedin"><i class="bbc-linkedin-square"></i>
						LinkedIn</a>
					<a href="#" class="bbc-btn medium has-icon facebook"><i class="bbc-facebook-square"></i>
						Facebook</a>
				</div>

				<div class="or-separator">
					<span class="separator-line left-line"></span>
					<span class="separator-text">OR</span>
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
						'class'       => 'form-field col-6 pr-3',
						'type'        => 'text',
						'label'       => __( 'Phone Number or Email', 'ninja' ),
						'name'        => 'user_login',
						'required'    => TRUE,
						'placeholder' => __( 'Enter you phone or email', 'ninja' ),
						'order'       => 5,
					],
					'user_password' => [ 
						'class'       => 'form-field col-6 pl-3',
						'type'        => 'password',
						'label'       => __( 'Password', 'ninja' ),
						'name'        => 'user_password',
						'required'    => TRUE,
						'placeholder' => __( 'Enter you password', 'ninja' ),
						'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
						'order'       => 10,
					],
					'rememberme'    => [ 
						'class'   => 'form-field col-6 align-items-start pr-3 m-0',
						'type'    => 'checkbox',
						'choices' => [ 
							[ 
								'class' => '',
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
						'content' => '<div class="form-field col-6 align-items-end pl-3 m-0" ><a href="' . get_permalink( get_page_by_path( 'my-account' ) ) . 'forgot-password" class="btn-link text-accent"> ' . __( 'Forgot your Password?', 'ninja' ) . ' </a></div></div>',
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
				],
					[ 
						'class' => Nh::_DOMAIN_NAME . '-login-form',
						'id'    => Nh::_DOMAIN_NAME . '_login_form',
					]
				);
			/** TODO!: create function to return copyrights */
			?>
			<div class="section-footer">
				<p>Copyright © 2023 B2B All rights reserved.</p>
			</div>
		</section>
		<section class="login-animation col-12 col-md-6">
			<div id="loginCarousel" class="carousel slide w-100 h-100">
				<div class="carousel-navigation">
					<button class="carousel-control-prev" type="button" data-bs-target="#loginCarousel"
						data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>

					<div class="carousel-indicators">
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active"
							aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1"
							aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2"
							aria-label="Slide 3"></button>
					</div>

					<button class="carousel-control-next" type="button" data-bs-target="#loginCarousel"
						data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>

				<div class="carousel-inner">
					<div class="carousel-item active">
						<dotlottie-player
							src="<?php echo Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
							background="transparent" speed="1" style="width: 80px; height: 80px" direction="1"
							mode="normal" loop autoplay>
						</dotlottie-player>
						<div class="carousel-caption d-none d-md-block">
							<h5>First slide label</h5>
							<p>Some representative placeholder content for the first slide.</p>
						</div>
					</div>
					<div class="carousel-item">
						<dotlottie-player
							src="<?php echo Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
							background="transparent" speed="1" style="width: 80px; height: 80px" direction="1"
							mode="normal" loop autoplay>
						</dotlottie-player>
						<div class="carousel-caption d-none d-md-block">
							<h5>Second slide label</h5>
							<p>Some representative placeholder content for the second slide.</p>
						</div>
					</div>
					<div class="carousel-item">
						<dotlottie-player
							src="<?php echo Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/money-investment.json"
							background="transparent" speed="1" style="width: 80px; height: 80px" direction="1"
							mode="normal" loop autoplay>
						</dotlottie-player>
						<div class="carousel-caption d-none d-md-block">
							<h5>Third slide label</h5>
							<p>Some representative placeholder content for the third slide.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</main><!-- #main -->

<?php get_footer();
