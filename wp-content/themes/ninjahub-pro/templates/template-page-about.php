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

	get_header();

	Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
	Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-about-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/about' );

?>

<script src="<?php echo Nh_Hooks::PATHS['public']['js']; ?>/landing-main.js" type="module"></script>
<!-- Page Content -->
<section class="page-content">
	<!-- About Content -->
	<div class="about-content">
		<!-- What We Do Section -->
		<div class="what-we-do">
			<div class="section-texture">
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
					alt="B2B Capital Abstract Logo" class="img-fluid">
			</div>
			<div class="description">
				<h1 class="b2b-title">About B2B</h1>
				<h2 class="page-section-title">What we do</h2>
				<p class="section-content">
					B2BCP is a platform where project owners can put them projects in a well-defined structure and have a
					professional team to handle and justify the project content and introduce the project as Opportunity in a
					perfect.
				</p>
				<p class="section-content">
					Clarified and meaningful content to the Investor so the project owner (Owner) can have the suitable investment
					package to the project and the investor will get the suitable Opportunity to invest in.
				</p>
				<p class="section-content">
					As a B2BCP helps the Project owners to get the best chance for them projects and helps the investors to get
					the best investment rate in a well-defined opportunity.
				</p>
				<h3 class="page-section-subtitle">Scope Of Definition</h3>
				<p class="section-content">
					The goal is to develop a web platform that makes exchange projects between project owners and investors so
					open, clear, easy and simple, the project owner can publish the projects with all documents, conditions, and
					terms to accept these projects from the investors with request to connect with them.
				</p>
				<p class="section-content">
					Also, the investors can explore all opportunities with its advantages and the disadvantage also can determine
					all situation of opportunity and it’s all well clarifying points to take a clear decision to go with
					investment with or leave it without any interruption from any part of platform as the connection managed by
					B2BCP only.
				</p>
			</div>
			<div class="banner">
				<div class="banner-wrapper">
					<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/what-we-do.webp" alt="What We Do"
						class="img-fluid">
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
			</div>
		</div>
		<!-- Awards Section -->
		<div class="about-section awards">
			<div class="section-texture">
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
					alt="B2B Capital Abstract Logo" class="img-fluid">
			</div>
			<div class="banner-wrapper">
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/awards.webp" alt="Awards" class="banner">
			</div>
			<div class="section-description">
				<h2 class="page-section-title">Awards</h2>
				<p class="section-content">
					B2BCP is a platform where project owners can put them projects in a well-defined structure and have a
					professional team to handle and justify the project content and introduce the project as Opportunity in a
					perfect.
				</p>
				<p class="section-content">
					Clarified and meaningful content to the Investor so the project owner (Owner) can have the suitable investment
					package to the project and the investor will get the suitable Opportunity to invest in.
				</p>
				<p class="section-content">
					B2BCP is a platform where project owners can put them projects in a well-defined structure and have a
					professional team to handle and justify the project content and introduce the project as Opportunity in a
					perfect.
				</p>
				<p class="section-content">
					Clarified and meaningful content to the Investor so the project owner (Owner) can have the suitable investment
					package to the project and the investor will get the suitable Opportunity to invest in.
				</p>
			</div>
			<div class="award">
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/btkobra.webp" alt="Btkobra Logo"
					class="img-fluid">
			</div>
		</div>
		<!-- Partners Section -->
		<div class="about-section partners">
			<div class="banner-wrapper">
				<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners.webp" alt="Partners" class="banner">
			</div>
			<div class="section-description">
				<h2 class="page-section-title">Partners</h2>
				<p class="section-content">
					We partner with those brave enough to do things differently.
				</p>
				<!-- Partners Logos -->
				<div class="partners-logos">
					<div class="logos-row">
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/wise-logo.webp" alt="Wise Logo"
								class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/google-ads-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/wise-logo.webp" alt="Wise Logo"
								class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/google-ads-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
					</div>
					<div class="logos-row second">
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/wise-logo.webp" alt="Wise Logo"
								class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/google-ads-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/wise-logo.webp" alt="Wise Logo"
								class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/google-ads-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/fiverr-logo.webp"
								alt="Fiverr Logo" class="logo">
						</span>
						<span class="logo-wrapper">
							<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/about/partners/tinder-logo.webp"
								alt="Tinder Logo" class="logo">
						</span>
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
