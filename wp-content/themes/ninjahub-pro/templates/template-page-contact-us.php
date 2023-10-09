<?php
/**
 * @Filename: template-page-contact-us.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Contact US Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

global $post;

get_header( '', array( 'active_link' => 'contact_us' ) );

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-contact-us', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/contact-us' );

$contact     = \NH\APP\CLASSES\Nh_Post::get_post( $post );
$inner_title = get_field( 'inner_title', $contact->ID );
?>


<!-- Page Content -->
<section class="page-content">
	<div class="contact-us-content">
		<!-- Contact Us Intro -->
		<div class="contact-us-intro">
			<h1 class="contact-us-title">
				<?= $inner_title ?>
			</h1>
			<div class="intro-description">
				<?= $contact->content ?>
			</div>
		</div>
		<!-- Contact Us Form -->
		<?php
		echo do_shortcode( '[contact-form-7 id="eaa3bfb" html-title="Contact Us"]' );
		/*
				<form class="contact-us-form">
					<div class="form-header">
						<h3 class="form-title">Reach out to us</h3>
						<span class="form-help"><i class="icon bbc-question"></i>Help</span>
					</div>
					<div class="form-field">
						<input type="text" id="name" name="name" class="form-control">
						<label for="name" class="form-control-label">Name</label>
						<span class="error-message">Please write valid full name</span>
					</div>
					<div class="form-field">
						<input type="email" id="email" name="email" class="form-control">
						<label for="email" class="form-control-label">Email Id</label>
						<span class="error-message">Please write valid email address</span>
					</div>
					<div class="form-field">
						<input type="text" id="mobile" name="mobile" class="form-control">
						<label for="mobile" class="form-control-label">Mobile</label>
						<span class="error-message">Please write valid mobile number</span>
					</div>
					<div class="form-field">
						<input type="text" id="message" name="message" class="form-control">
						<label for="message" class="form-control-label">Message</label>
						<span class="error-message">Please write your message</span>
					</div>
					<button type="submit" class="form-action bbc-btn large apply">Send</button>
				</form>
				*/?>
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
