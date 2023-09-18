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


	use NH\APP\HELPERS\Nh_Hooks;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Partner;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Testimonial;
	use NH\Nh;

	get_header();

	Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
?>


<!-- Page Content -->
<section class="page-content">
	<!-- Landing Page Content -->
	<div class="landing-page-content">
		<!-- Landing Page Carousel -->
		<div id="landingPageCarousel" class="carousel slide" data-bs-wrap="false">
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#landingPageCarousel" data-bs-slide-to="0"
					class="slide-indicator active"></button>
				<button type="button" data-bs-target="#landingPageCarousel" data-bs-slide-to="1"
					class="slide-indicator"></button>
				<button type="button" data-bs-target="#landingPageCarousel" data-bs-slide-to="2"
					class="slide-indicator"></button>
				<button type="button" data-bs-target="#landingPageCarousel" data-bs-slide-to="3"
					class="slide-indicator"></button>
				<a href="./choose-type_en.html" class="skip-intro">Skip<i class="icon bbc-next"></i></a>
			</div>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="slide">
						<div class="slide-content">
							<h1 class="b2b-title">Trusted Investment Platform</h1>
							<h2 class="slide-title">
								All investment instruments in <span class="highlighted">one place!</span>
							</h2>
							<h3 class="slide-subtitle">Why choose us for best investment experience</h3>
							<p class="description">Long established fact that a reader will be distracted by the readable
								content</p>
							<div class="statistics">
								<div class="statistic">
									<h4 class="statistic-count">15M<span class="icon">+</span></h4>
									<p class="statistic-name">Total Users</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">200K<span class="icon">+</span></h4>
									<p class="statistic-name">Buyer</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">450K<span class="icon">+</span></h4>
									<p class="statistic-name">Seller</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">50K<span class="icon">+</span></h4>
									<p class="statistic-name">Happy Clients</p>
								</div>
							</div>
						</div>
						<div class="slide-banner">
							<div class="banner-wrapper large">
								<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/slide-1.webp" alt="Slide 1"
									class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<div class="carousel-item">
					<div class="slide">
						<div class="slide-content">
							<h1 class="b2b-title">Trusted Investment Platform</h1>
							<h2 class="slide-title">
								All Widgets Overview in <span class="highlighted">one place!</span>
							</h2>
							<h3 class="slide-subtitle">Why choose us for best investment experience</h3>
							<p class="description">Long established fact that a reader will be distracted by the readable
								content</p>
							<div class="statistics">
								<div class="statistic">
									<h4 class="statistic-count">15M <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Total Users</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">200K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Buyer</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">450K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Seller</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">50K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Happy Clients</p>
								</div>
							</div>
						</div>
						<div class="slide-banner">
							<div class="banner-wrapper medium">
								<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/slide-2.webp" alt="Slide 2"
									class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<div class="carousel-item">
					<div class="slide">
						<div class="slide-content">
							<h1 class="b2b-title">Trusted Investment Platform</h1>
							<h2 class="slide-title">
								All investment instruments in <span class="highlighted">one place!</span>
							</h2>
							<h3 class="slide-subtitle">Why choose us for best investment experience</h3>
							<p class="description">Long established fact that a reader will be distracted by the readable
								content</p>
							<div class="statistics">
								<div class="statistic">
									<h4 class="statistic-count">15M <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Total Users</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">200K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Buyer</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">450K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Seller</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">50K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Happy Clients</p>
								</div>
							</div>
						</div>
						<div class="slide-banner">
							<div class="banner-wrapper">
								<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/slide-3.webp" alt="Slide 3"
									class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<div class="carousel-item">
					<div class="slide">
						<div class="slide-content">
							<h1 class="b2b-title">Trusted Investment Platform</h1>
							<h2 class="slide-title">
								You can see Latest acquisitions in different industries in <span class="highlighted">one
									place!</span>
							</h2>
							<h3 class="slide-subtitle">Why choose us for best investment experience</h3>
							<p class="description">Long established fact that a reader will be distracted by the readable
								content</p>
							<div class="statistics">
								<div class="statistic">
									<h4 class="statistic-count">15M <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Total Users</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">200K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Buyer</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">450K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Seller</p>
								</div>
								<div class="statistic">
									<h4 class="statistic-count">50K <i class="icon bbc-plus"></i></h4>
									<p class="statistic-name">Happy Clients</p>
								</div>
							</div>
						</div>
						<div class="slide-banner">
							<div class="banner-wrapper">
								<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/slide-4.webp" alt="Slide 4"
									class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="carousel-control-area">
				<div class="carousel-control-wrapper">
					<div class="texture">
						<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
							alt="B2B Capital Abstract Logo" class="img-fluid">
					</div>
					<span class="carousel-control next" data-bs-target="#landingPageCarousel" data-bs-slide="next">
						<span class="action-title">Scroll</span>
						<span class="icon-wrapper"><i class="icon bbc-next"></i></span>
					</span>
					<span class="carousel-control prev d-none" data-bs-target="#landingPageCarousel" data-bs-slide="prev">
						<i class="icon bbc-previous"></i>Back
					</span>
				</div>
			</div>
		</div>
		<!-- Landing Page Footer -->
		<div class="landing-page-footer">
			<p class="footer-title">Our Partners Include The World's</p>
			<div class="partners-logos">
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Blackbox-Logo.webp"
						alt="Blackbox Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Asos-Logo.webp"
						alt="Asos Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Answear-Logo.webp"
						alt="Answear Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Cafago-Logo.webp"
						alt="Cafago Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Ajio-Logo.webp"
						alt="Ajio Logo">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Blackbox-Logo.webp"
						alt="Blackbox Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Asos-Logo.webp"
						alt="Asos Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Answear-Logo.webp"
						alt="Answear Logo" class="img-fluid">
				</span>
				<span class="partner-logo">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/partners/Cafago-Logo.webp"
						alt="Cafago Logo" class="img-fluid">
				</span>
			</div>
		</div>
	</div>
</section>
</div>
</main>
</div> <!-- </landing-page> -->

<?php
get_footer();
