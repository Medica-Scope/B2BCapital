<?php
/**
 * @Filename: template-page-home.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Home Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 */


use NH\APP\CLASSES\Nh_Post;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

global $post;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );


$sliders_group = get_field( 'sliders_group', $post->ID );
$partners      = get_field( 'partners', $post->ID );

?>
<!-- Page Content -->
<section class="page-content">
	<!-- Landing Page Content -->
	<div class="landing-page-content">
		<!-- Landing Page Carousel -->
		<div id="landingPageCarousel" class="carousel slide" data-bs-wrap="false">
			<div class="carousel-indicators d-none d-md-flex">
				<?php
				if ( ! empty( $sliders_group ) ) {
					foreach ( $sliders_group as $key => $value ) {
						?>
				<button type="button" data-bs-target="#landingPageCarousel" data-bs-slide-to="<?php echo $key; ?>"
					class="slide-indicator <?php echo $key === 0 ? 'active' : ''; ?>" aria-label="Slider indicator"></button>
				<?php
					}
				}
				?>
				<a href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'home/choose-type' ) ) ); ?>"
					class="skip-intro">
					<?= __( 'Skip', 'ninja' ) ?><i class="bbc-arrow-right2"></i>
				</a>
			</div>

			<div class="carousel-inner">
				<?php
				if ( ! empty( $sliders_group ) ) {
					foreach ( $sliders_group as $key => $slide ) {
						?>
				<div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>">
					<div class="slide">
						<div class="slide-content">
							<h1 class="b2b-title">
								<?php echo $slide['slider_titles']['tag_line']; ?>
							</h1>
							<h2 class="slide-title">
								<?php echo $slide['slider_titles']['main_title']; ?> <span class="highlighted">
									<?php echo $slide['slider_titles']['main_title_highlighted_']; ?>
								</span>
							</h2>
							<h3 class="slide-subtitle">
								<?php echo $slide['slider_titles']['second_title']; ?>
							</h3>
							<p class="description">
								<?php echo $slide['slider_titles']['content']; ?>
							</p>

							<div class="statistics">
								<?php
										/**
										 * Make sure it's array and contains data before looping.
										 */
										if ( is_array( $slide['slider_statistics'] ) && ! empty( $slide['slider_statistics'] ) ) {
											foreach ( $slide['slider_statistics'] as $statistic ) {
												?>
								<div class="statistic">
									<h4 class="statistic-count">
										<?php echo $statistic['statistic_number']; ?><span class="icon">
											<?php echo $statistic['statistic_operator']; ?>
										</span>
									</h4>
									<p class="statistic-name">
										<?php echo $statistic['statistic_title']; ?>
									</p>
								</div>
								<?php
											}
										}
										?>
							</div>
						</div>
						<div class="slide-banner">
							<div class="banner-wrapper large">
								<img src="<?php echo $slide['slider_image']['url']; ?>" alt="Slide 1" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				}
				?>
			</div>

			<div class="carousel-control-area">
				<div class="carousel-control-wrapper">
					<div class="texture">
						<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
							alt="B2B Capital Abstract Logo" class="img-fluid">
					</div>
					<span class="carousel-control next" data-bs-target="#landingPageCarousel" data-bs-slide="next">
						<span class="action-title">
							<?= __( 'Scroll', 'ninja' ); ?>
						</span>
						<span class="icon-wrapper">
							<dotlottie-player
								src="<?php echo Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/arrow-right-white.lottie/animations/12345.json"
								background="transparent" speed="1" style="width: 80px; height: 80px" direction="1" mode="normal" loop
								autoplay>
							</dotlottie-player>
						</span>
					</span>
					<span class="carousel-control prev d-none" data-bs-target="#landingPageCarousel" data-bs-slide="prev">
						<i class="bbc-arrow-left2"></i>
						<?= __( 'Back', 'ninja' ); ?>
					</span>
				</div>
			</div>
		</div>

		<!-- Landing Page Footer -->
		<div class="landing-page-footer">
			<p class="footer-title">
				<?= __( "Our Partners Include The World's", 'ninja' ); ?>
			</p>
			<div class="partners-logos">
				<?php
				if ( ! empty( $partners ) ) {
					foreach ( $partners as $partner ) {
						?>
				<span class="partner-logo">
					<img src="<?php echo $partner['partner_logo']['sizes']['thumbnail']; ?>"
						alt="<?php echo $partner['partner_name']; ?>" class="img-fluid">
				</span>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php
get_footer();
