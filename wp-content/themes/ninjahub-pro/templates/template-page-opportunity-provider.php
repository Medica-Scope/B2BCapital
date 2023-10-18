<?php
/**
 * @Filename: template-page-opportunity-provider.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Opportunity Provider Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-user-type-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/user-type' );

get_header();
?>


<!-- Page Content -->
<section class="page-content">
	<!-- User Type Content -->
	<div class="user-type-content">
		<h2 class="types-title">B2B Is To Regulate<br>The Relationship Between</h2>
		<!-- Owner Type Content -->
		<div class="active-user-type">
			<div class="other-user-type investor">
				<a href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'home/investor' ) ) ); ?>"
					class="other-user">
					<span class="other-type-image">
						<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/user-type/investor-video.webp" alt="B2B Investor"
							class="img-fluid">
					</span>
					<span class="other-user-title">
						Investor
						<i class="icon bbc-right"></i>
						<i class="icon bbc-right"></i>
					</span>
				</a>
			</div>
			<div class="active-user-type-content">
				<h2 class="user-type-title">Opportunity Provider</h2>
				<p class="user-type-description">
					Many owners of investment opportunities fall into great suffering to obtain investments and cash
					liquidity in
					order to circulate the capital movement and achieve the required profits.
				</p>
				<p class="user-type-description">
					This obstacle often causes huge losses for me as the owner of investment opportunity looking for an
					investor
					for the company or acquisition.
				</p>
				<p class="user-type-description">
					B2B solved this problem through the marketplace that provide, through which I can get to know
					investors.
				</p>
				<p class="user-type-description">
					Find angelic and immediate investment, and act quickly, while providing some of my consultations to
					complete
					acquisitions within my company.
				</p>
				<a href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ) . '/?type=owner'; ?>"
					class="user-type-action bbc-btn outline action">Join as Owner</a>
			</div>
			<div class="user-type-video owner">
				<div class="video-scene">
					<video autoplay loop class="w-100">
						<source src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/videos/owner.mp4" type="video/mp4">
					</video>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
