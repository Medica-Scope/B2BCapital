<?php
/**
 * @Filename: template-page-registration.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Registration Page
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

$user_type = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : '';

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-register-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/register' );
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
			'custom-html-1'      => [
				'type'    => 'html',
				'content' => '<div class="d-flex flex-row flex-wrap col-12">',
				'order'   => 0,
			],
			'first_name'         => [
				'class'       => 'form-field col-6 pr-3',
				'type'        => 'text',
				'label'       => __( 'First Name', 'ninja' ),
				'name'        => 'first_name',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your first name', 'ninja' ),
				'order'       => 5,
			],
			'last_name'          => [
				'class'       => 'form-field col-6 pl-3',
				'type'        => 'text',
				'label'       => __( 'Last Name', 'ninja' ),
				'name'        => 'last_name',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your last name', 'ninja' ),
				'order'       => 10,
			],
			'phone_number'       => [
				'class'       => 'form-field col-6 pr-3',
				'type'        => 'text',
				'label'       => __( 'Phone Number', 'ninja' ),
				'name'        => 'phone_number',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your phone number', 'ninja' ),
				'order'       => 15,
			],
			'user_email'         => [
				'class'       => 'form-field col-6 pl-3',
				'type'        => 'email',
				'label'       => __( 'Email', 'ninja' ),
				'name'        => 'user_email',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your email', 'ninja' ),
				'order'       => 20,
			],
			'user_password'      => [
				'class'       => 'form-field col-6 pr-3',
				'type'        => 'password',
				'label'       => __( 'Password', 'ninja' ),
				'name'        => 'user_password',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your password', 'ninja' ),
				'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_user_password"></i>',
				'order'       => 25,
			],
			'confirm_password'   => [
				'class'       => 'form-field col-6 pl-3',
				'type'        => 'password',
				'label'       => __( 'Confirm Password', 'ninja' ),
				'name'        => 'confirm_password',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your confirm password', 'ninja' ),
				'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_confirm_password"></i>',
				'order'       => 30,
			],
			'user_type'          => [
				'type'           => 'select',
				'label'          => __( 'User Type', 'ninja' ),
				'name'           => 'user_type',
				'required'       => TRUE,
				'placeholder'    => __( 'Enter your user type', 'ninja' ),
				'options'        => [
					'owner'    => __( 'I am Owner', 'ninja' ),
					'investor' => __( 'I am Investor', 'ninja' ),
				],
				'default_option' => '',
				'select_option'  => [ $user_type ],
				'class'          => 'form-field col-6 pr-3',
				'order'          => 35,
			],
			'verification_type'  => [
				'type'           => 'select',
				'label'          => __( 'Account Verification Type', 'ninja' ),
				'name'           => 'verification_type',
				'required'       => TRUE,
				'placeholder'    => __( 'Enter your verification type', 'ninja' ),
				'options'        => [
					Nh_User::VERIFICATION_TYPES['email'] => __( 'Email', 'ninja' ),
					Nh_User::VERIFICATION_TYPES['mobile'] => __( 'Phone Number', 'ninja' ),
					Nh_User::VERIFICATION_TYPES['whatsapp'] => __( 'Whatsapp', 'ninja' ),
				],
				'default_option' => '',
				'select_option'  => '',
				'class'          => 'form-field col-6 pl-3',
				'order'          => 40,
			],
			'custom-html-3'      => [
				'type'    => 'html',
				'content' => '</div>',
				'order'   => 45,
			],
			'registration_nonce' => [
				'class' => '',
				'type'  => 'nonce',
				'name'  => 'registration_nonce',
				'value' => Nh::_DOMAIN_NAME . "_registration_form",
				'order' => 50
			],
			'submit'             => [
				'class'               => 'form-action bbc-btn btn-primary large apply',
				'type'                => 'submit',
				'value'               => __( 'Create Account', 'ninja' ),
				'before'              => '',
				'after'               => '',
				'recaptcha_form_name' => 'frontend_registration',
				'order'               => 55
			],
		], [
			'class' => Nh::_DOMAIN_NAME . '-registration-form',
			'id'    => Nh::_DOMAIN_NAME . '_registration_form'
		] );
        /** TODO!: create function to return copyrights */
	?>
		</section>
		<section class="login-animation h-100 col-12 col-md-6">
			<div id="loginCarousel" class="carousel slide w-100 h-100">
				<div class="carousel-navigation">
					<button class="carousel-control-prev" type="button" data-bs-target="#loginCarousel" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>

					<div class="carousel-indicators">
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active"
							aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
					</div>

					<button class="carousel-control-next" type="button" data-bs-target="#loginCarousel" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>

				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="../../assets/gifs/money-investment.gif" class="d-block" alt="Money Investment GIF">
						<div class="carousel-caption d-none d-md-block">
							<h5>First slide label</h5>
							<p>Some representative placeholder content for the first slide.</p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="../../assets/gifs/money-investment.gif" class="d-block" alt="Money Investment GIF">
						<div class="carousel-caption d-none d-md-block">
							<h5>Second slide label</h5>
							<p>Some representative placeholder content for the second slide.</p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="../../assets/gifs/money-investment.gif" class="d-block" alt="Money Investment GIF">
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
