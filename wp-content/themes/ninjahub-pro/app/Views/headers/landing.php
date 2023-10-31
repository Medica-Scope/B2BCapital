<?php
/**
 * @Filename: landing.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\CLASSES\Nh_Init;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
use NH\Nh;

$active_link = ! empty( $args['active_link'] ) ? $args['active_link'] : false;
/**
 * TODO: $args not working
 */
?>
<div class="landing-page main">
	<div class="back-texture d-none d-xl-flex">
		<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/texture.webp" alt="Texture"
			class="img-fluid">
	</div>
	<!-- App Sidebar -->
	<aside class="sidebar d-none d-lg-flex">
		<!-- App Brand -->
		<a href="<?= home_url() ?>" class="app-brand">
			<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp"
				alt="B2B Capital Logo" class="img-fluid">
		</a>
		<!-- App Language Switcher -->
		<div class="language-link">
			<?php
			do_action( 'wpml_language_switcher', [
				'display_names_in_native_lang'   => 0,
				'display_names_in_current_lang ' => 1,
				'display_link_for_current_lang'  => 0,
			] );
			?>
		</div>
		<!-- App Navigation -->
		<ul class="navbar-nav app-navigation">
			<li class="nav-item">
				<a class="nav-link <?php echo $active_link === 'contact_us' ? 'active' : ''; ?>"
					href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">
					<?php echo __( 'Contact Us', 'ninja' ); ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo $active_link === 'about_us' ? 'active' : ''; ?>"
					href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'about' ) ) ); ?>">
					<?php echo __( 'About', 'ninja' ); ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo $active_link === 'services' ? 'active' : ''; ?>"
					href="<?php echo get_post_type_archive_link( 'service' ); ?>">
					<?php echo __( 'Services', 'ninja' ); ?>
				</a>
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
						<a href="<?php echo Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_in']; ?>" target="_blank"
							class="social-link"><i class="social-icon bbc-linkedin"></i></a>
					</li>
					<li class="social-item">
						<a href="<?php echo Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_fb']; ?>" target="_blank"
							class="social-link"><i class="social-icon bbc-facebook"></i></a>
					</li>
					<li class="social-item">
						<a href="<?php echo Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_ig']; ?>" target="_blank"
							class="social-link"><i class="social-icon bbc-instagram"></i></a>
					</li>
					<li class="social-item">
						<a href="<?php echo Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_tw']; ?>" target="_blank"
							class="social-link"><i class="social-icon bbc-twitter"></i></a>
					</li>
				</ul>
				<div class="user-area">
					<?php
					if ( ! is_user_logged_in() ) {
						?>
					<a href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ); ?>?type=investor"
						class="user-action bbc-btn outline success">
						<?php echo __( 'Join as Investor', 'ninja' ); ?>
					</a>
					<a href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/registration' ) ) ); ?>?type=owner"
						class="user-action bbc-btn outline action">
						<?php echo __( 'Join as Owner', 'ninja' ); ?>
					</a>
					<?php
					}
					?>

					<?php
					if ( is_user_logged_in() ) {
						?>
					<a href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
						aria-controls="staticBackdrop">
						<span class="user-action user-menu">
							<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
								<g id="grid_layout_20" data-name="grid layout 20" transform="translate(-4 -4)">
									<path id="Path_44799" data-name="Path 44799" d="M13,13H23V23H13Z" transform="translate(6 6)"
										fill="#fff" />
									<path id="Path_44800" data-name="Path 44800" d="M4,13H15.667V23H4Z" transform="translate(0 6)"
										fill="#fff" />
									<path id="Path_44801" data-name="Path 44801" d="M13,4H23V15.667H13Z" transform="translate(6)"
										fill="#fff" />
									<path id="Path_44802" data-name="Path 44802" d="M21,13H32.667V23H21Z" transform="translate(11.333 6)"
										fill="#fff" />
									<path id="Path_44803" data-name="Path 44803" d="M21,32.667h8.333a3.333,3.333,0,0,0,3.333-3.333V21H21Z"
										transform="translate(11.333 11.333)" fill="#fff" />
									<path id="Path_44804" data-name="Path 44804"
										d="M4,7.333v8.333H15.667V4H7.333A3.333,3.333,0,0,0,4,7.333Z" fill="#fff" />
									<path id="Path_44805" data-name="Path 44805" d="M13,21H23V32.667H13Z" transform="translate(6 11.333)"
										fill="#fff" />
									<path id="Path_44806" data-name="Path 44806" d="M4,29.333a3.333,3.333,0,0,0,3.333,3.333h8.333V21H4Z"
										transform="translate(0 11.333)" fill="#fff" />
									<circle id="Ellipse_12443" data-name="Ellipse 12443" cx="3.665" cy="3.665" r="3.665"
										transform="translate(34.667 6)" fill="#fe6500" />
								</g>
							</svg>
						</span>
					</a>

					<div class="offcanvas offcanvas-start" data-bs-backdrop="false" tabindex="-1" id="staticBackdrop"
						aria-labelledby="staticBackdropLabel">
						<div class="offcanvas-header">
							<h5 class="offcanvas-title" id="staticBackdropLabel">
								<a href="<?= home_url() ?>" class="app-brand">
									<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp"
										alt="B2B Capital Logo" class="img-fluid">
								</a>
							</h5>
							<button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas"
								aria-label="Close">X</button>
						</div>
						<div class="offcanvas-body">
							<ul class="navbar-nav app-navigation">
								<li class="nav-item mb-2">
									<a class="nav-link text-white  <?php echo $active_link === 'dashboard' ? 'active' : ''; ?>"
										href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'dashboard' ) ) ) ?>">
										<?php echo __( 'Dashboard', 'ninja' ); ?>
									</a>
								</li>
								<li class="nav-item mb-2">
									<a class="nav-link text-white  <?php echo $active_link === 'contact_us' ? 'active' : ''; ?>"
										href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">
										<?php echo __( 'Contact Us', 'ninja' ); ?>
									</a>
								</li>
								<li class="nav-item mb-2">
									<a class="nav-link text-white  <?php echo $active_link === 'about_us' ? 'active' : ''; ?>"
										href="<?php echo apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'about' ) ) ); ?>">
										<?php echo __( 'About', 'ninja' ); ?>
									</a>
								</li>
								<li class="nav-item mb-2">
									<a class="nav-link text-white  <?php echo $active_link === 'services' ? 'active' : ''; ?>"
										href="<?php echo get_post_type_archive_link( 'service' ); ?>">
										<?php echo __( 'Services', 'ninja' ); ?>
									</a>
								</li>
								<li class="nav-item mb-2">
									<a class="nav-link text-white  <?php echo $active_link === 'faq' ? 'active' : ''; ?>"
										href="<?php echo get_post_type_archive_link( 'faq' ); ?>">
										<?php echo __( 'FAQs', 'ninja' ); ?>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<?php
					}
					?>


				</div>

			</header><!-- #masthead -->
