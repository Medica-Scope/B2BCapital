<?php
/**
 * @Filename: template-page-about.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 */


use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

global $post;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-about-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/about' );

$children             = get_children( $post->ID );
$about                = \NH\APP\CLASSES\Nh_Post::get_post( $post );
$about_tag_line_title = get_field( 'tag_line_title', $about->ID );
$about_inner_title    = get_field( 'inner_title', $about->ID );
$about_statistics     = get_field( 'statistics', $about->ID );

?>
<!-- Page Content -->
<section class="page-content">
	<!-- About Content -->
	<div class="about-content row overflow-x-auto flex-nowrap">
		<!-- What We Do Section -->
		<div class="what-we-do col-12">
			<div class="section-texture">
				<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
					alt="B2B Capital Abstract Logo" class="img-fluid">
			</div>

			<div class="description">
				<h1 class="b2b-title">
					<?= $about_tag_line_title; ?>
				</h1>
				<h2 class="page-section-title">
					<?= $about_inner_title; ?>
				</h2>
				<?= $about->content; ?>
			</div>

			<div class="banner">
				<div class="banner-wrapper">
					<img src="<?= $about->thumbnail; ?>" alt="<?= $about->title; ?>" class="img-fluid">
					<div class="statistics">
						<?php
						if ( ! empty( $about_statistics ) ) {
							foreach ( $about_statistics as $statistic ) {
								?>
								<div class="statistic">
									<h4 class="statistic-count">
										<?= $statistic['statistic_number']; ?> <i class="icon bbc-plus"></i>
									</h4>
									<p class="statistic-name">
										<?= $statistic['statistic_title']; ?>
									</p>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<?php
		$awards             = get_page_by_path( 'about/awards' );
		$awards_obj         = \NH\APP\CLASSES\Nh_Post::get_post( $awards );
		$awards_inner_title = get_field( 'inner_title', $awards_obj->ID );
		$awards_logos       = get_field( 'awards_logos', $awards_obj->ID );
		?>
		<!-- Awards Section -->
		<div class="about-section awards col-12">
			<div class="section-texture">
				<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
					alt="B2B Capital Abstract Logo" class="img-fluid">
			</div>
			<div class="banner-wrapper">
				<img src="<?= $awards_obj->thumbnail; ?>" alt="Awards" class="banner">
			</div>
			<div class="section-description">
				<h2 class="page-section-title">
					<?= $awards_inner_title; ?>
				</h2>
				<?= $awards_obj->content; ?>
			</div>
			<div class="award">
				<?php
				foreach ( $awards_logos as $logo ) {
					?>
					<p>
						<?= $logo['award_name']; ?>
					</p>
					<img src="<?= $logo['award_logo']['sizes']['thumbnail']; ?>" alt="Btkobra Logo"
						class="img-fluid">
					<?php
				}
				?>

			</div>
		</div>

		<?php
		$partners             = get_page_by_path( 'about/partners' );
		$partners_obj         = \NH\APP\CLASSES\Nh_Post::get_post( $partners );
		$partners_inner_title = get_field( 'inner_title', $partners_obj->ID );
		$partners_logos       = get_field( 'partners_logos', $partners_obj->ID );
		?>
		<!-- Partners Section -->
		<div class="about-section partners col-12">
			<div class="banner-wrapper">
				<img src="<?= $partners_obj->thumbnail; ?>" alt="Partners" class="banner">
			</div>
			<div class="section-description">
				<h2 class="page-section-title">
					<?= $partners_inner_title; ?>
				</h2>
				<?= $partners_obj->content; ?>
				<!-- Partners Logos -->
				<div class="partners-logos">
					<?php
					$chunk = array_chunk( $partners_logos, ceil( count( $partners_logos ) / 2 ) );
					?>
					<div class="row row-cols-1 logos-row">
						<?php foreach ( $chunk[0] as $logo ) { ?>
							<span class="logo-wrapper col">
								<img src="<?= $logo['partner_logo']['sizes']['thumbnail']; ?>"
									alt="<?= $logo['partner_name']; ?>" class="logo">
							</span>
						<?php } ?>
					</div>

					<div class="row row-cols-1 logos-row second">
						<?php foreach ( $chunk[1] as $logo ) { ?>
							<span class="logo-wrapper col">
								<img src="<?= $logo['partner_logo']['sizes']['thumbnail']; ?>"
									alt="<?= $logo['partner_name']; ?>" class="logo">
							</span>
						<?php } ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php
get_footer();

get_template_part( 'app/Views/js-templates/horizontal-scroll', NULL, [ 'scrollable_container' => '.page-content .about-content' ] );
