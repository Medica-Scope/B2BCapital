<?php
	/**
	 * @Filename: landing.php
	 * @Description:
	 * @User: NINJA MASTER - Mustafa Shaaban
	 * @Date: 4/26/2023
	 */

	use NH\APP\HELPERS\Nh_Hooks;
	use NH\APP\CLASSES\Nh_User;
	use NH\APP\HELPERS\Nh_Forms;
	use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
	use NH\Nh;
?>
<div class="landing-page main">
	<div class="back-texture">
		<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/texture.webp" alt="Texture"
			class="img-fluid">
	</div>
	<!-- App Sidebar -->
	<aside class="sidebar">
		<!-- App Brand -->
		<a href="./landing-page_en.html" class="app-brand">
			<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp"
				alt="B2B Capital Logo" class="img-fluid">
		</a>
		<!-- App Language Switcher -->
		<a class="language-link" href="./landing-page_ar.html">العربية</a>
		<!-- App Navigation -->
		<ul class="navbar-nav app-navigation">
			<li class="nav-item">
				<a class="nav-link" href="./contact-us_en.html">Contact Us</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="./about_en.html">About</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="./services_en.html">Services</a>
			</li>
		</ul>
	</aside>
	<!-- Main Section -->
	<main>
		<!-- Landing Page Layout -->
		<div class="layout">
			<!-- App Header -->
			<header id="masthead" class="site-header app-header">
				<ul class="social-links">
					<li class="social-item">
						<a href="https://linkedin.com/" target="_blank" class="social-link"><i
								class="social-icon bbc-linkedin"></i></a>
					</li>
					<li class="social-item">
						<a href="https://www.facebook.com" target="_blank" class="social-link"><i
								class="social-icon bbc-facebook"></i></a>
					</li>
					<li class="social-item">
						<a href="https://www.instagram.com" target="_blank" class="social-link"><i
								class="social-icon bbc-instagram"></i></a>
					</li>
					<li class="social-item">
						<a href="https://twitter.com" target="_blank" class="social-link"><i
								class="social-icon bbc-twitter"></i></a>
					</li>
				</ul>
				<div class="user-area">
					<a href="./investor-type_en.html" class="user-action bbc-btn outline success">Join as Investor</a>
					<a href="./owner-type_en.html" class="user-action bbc-btn outline action">Join as Owner</a>
					<span class="user-action user-menu">
						<span class="icon bbc-menu"><span class="path1"></span><span class="path2"></span><span
								class="path3"></span><span class="path4"></span><span class="path5"></span><span
								class="path6"></span><span class="path7"></span><span class="path8"></span><span
								class="path9"></span></span>
					</span>
				</div>

			</header><!-- #masthead -->
