<?php
/**
 * @Filename: template-page-choose-type.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Choose Type Page
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
		<div class="user-types">
			<div class="user-type investor">
				<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'home/investor' ) ) ); ?>"
					class="user-type-link">
					<div class="user-type-image">
						<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/user-type/choose-investor.webp"
							alt="Choose Investor" class="img-fluid">
					</div>
					<div class="user-type-title-wrapper">
						<span class="holder outer"></span>
						<h2 class="user-type-title">Investor</h2>
						<span class="holder inner"></span>
					</div>
					<span class="know-more">
						Know More
						<i class="icon bbc-chevrons-right"></i>
						<i class="icon bbc-right"></i>
					</span>
				</a>
			</div>
			<div class="user-type owner">
				<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'home/opportunity-provider' ) ) ); ?>"
					class="user-type-link">
					<div class="user-type-image">
						<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/user-type/choose-owner.webp" alt="Choose Owner"
							class="img-fluid">
					</div>
					<div class="user-type-title-wrapper">
						<span class="holder outer"></span>
						<h2 class="user-type-title">Opportunity Provider</h2>
						<span class="holder inner"></span>
					</div>
					<span class="know-more">
						Know More
						<i class="icon bbc-chevrons-right"></i>
						<i class="icon bbc-right"></i>
					</span>
				</a>
			</div>
		</div>
	</div>
</section>
<?php get_footer();
