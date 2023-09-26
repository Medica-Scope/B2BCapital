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

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-contact-us', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/contact-us' );

?>


<!-- Page Content -->
<section class="page-content">
	<div class="contact-us-content">
		<!-- Contact Us Intro -->
		<div class="contact-us-intro">
			<h1 class="contact-us-title">Interested? Let' talk!</h1>
			<p class="intro-description">
				Just fill this simple form in and we will contact you promptly to discuss your project. Hate forms? Drop
				us a
				line at
				<a href="mailto:connect@b2b.com?subject=Mail from our Website&body=Hello B2B"
					class="email-us">connect@b2b.com</a>
			</p>
		</div>
		<!-- Contact Us Form -->
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
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
