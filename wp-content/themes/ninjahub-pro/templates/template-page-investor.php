<?php
/**
 * @Filename: template-page-investor.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Investor Page
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
		<?= _x('<h2 class="types-title">B2B Is To Regulate<br>The Relationship Between</h2>', 'ninja')?>
		<!-- Investor Type Content -->
		<div class="active-user-type">
			<div class="user-type-video investor">
				<div class="video-scene">
					<video autoplay loop class="w-100">
						<source src="<?= Nh_Hooks::PATHS['public']['video']; ?>/investor.mp4" type="video/mp4">
					</video>
				</div>
			</div>
			<div class="active-user-type-content">
				<h2 class="user-type-title"><?= __('Investor', 'ninja') ?></h2>
				<p class="user-type-description">
					<?= __('B2B represents a real opportunity for me to pump my investments into a number of projects owned by government authorities and startups.', 'ninja') ?>
				</p>
				<p class="user-type-description">
					<?= __('Where the platform provides me with an marketplace through which I can roam and move within the opportunities offered completely freely.', 'ninja') ?>
				</p>
				<p class="user-type-description">
					<?= __('with valuable advisory and technical services provided by the platform through the financial and stock market consultants who are present in it for a fair and true evaluation of the promoted investment opportunities.', 'ninja') ?>
				</p>
				<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ) . '/?type=investor'; ?>"
					class="user-type-action bbc-btn outline success"><?= __('Join as Investor', 'ninja') ?></a>
			</div>
			<div class="other-user-type owner">
				<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'home/opportunity-provider' ) ) ); ?>"
					class="other-user">
					<span class="other-type-image">
						<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/user-type/owner-video.webp" alt="B2B Owner"
							class="img-fluid">
					</span>
					<span class="other-user-title">
						<?= __('Opportunity Provider', 'ninja') ?>
						<i class="icon chevrons-right"></i>
						<i class="icon bbc-right"></i>
					</span>
				</a>
			</div>
		</div>
	</div>
</section>
<?php get_footer();
