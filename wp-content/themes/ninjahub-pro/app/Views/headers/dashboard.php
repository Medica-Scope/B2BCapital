<?php
/**
 * @Filename: dashboard.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

/**
 * Include Header Style File.
 */
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-header-dashboard', Nh_Hooks::PATHS['public']['css'] . '/components/header/header-dashboard' );
?>

<header id="masthead" class="site-header container-fluid container-xxl">
	<nav id="site-navigation" class="main-navigation">

		<div class="site-branding">
			<a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard'))) ?>"><img src="<?php echo Nh::get_site_logo(); ?>" alt="Nh Site Logo" /></a>
		</div>

		<?php
		if ( Nh_User::get_user_role() == Nh_User::OWNER ) {
			/**
			 * Include owner type menu
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'dashboard-owner-menu',
					'container_class' => 'bbc-logged-in-menu-container',
					'container_id'    => 'bbc-logged-in-menu-container',
					'menu_class'      => 'navbar-nav',
					'menu_id'         => 'bbc-logged-in-navbar-nav',
					'fallback_cb'     => '',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
		} elseif ( Nh_User::get_user_role() == Nh_User::INVESTOR ) {
			/**
			 * Include investor type menu
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'dashboard-investor-menu',
					'container_class' => 'bbc-default-menu-container',
					'container_id'    => 'bbc-default-menu-container',
					'menu_class'      => 'navbar-nav',
					'fallback_cb'     => '',
					'menu_id'         => 'bbc-default-navbar-nav',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
		} elseif ( Nh_User::get_user_role() == Nh_User::ADMIN ) {
			/**
			 * Include Admin type menu
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'dashboard-admin-menu',
					'container_class' => 'bbc-default-menu-container',
					'container_id'    => 'bbc-default-menu-container',
					'menu_class'      => 'navbar-nav',
					'fallback_cb'     => '',
					'menu_id'         => 'bbc-default-navbar-nav',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
		} else {
			/**
			 * Include guest menu
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'dashboard-guest-menu',
					'container_class' => 'bbc-default-menu-container',
					'container_id'    => 'bbc-default-menu-container',
					'menu_class'      => 'navbar-nav',
					'fallback_cb'     => '',
					'menu_id'         => 'bbc-default-navbar-nav',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
		}

		if (is_user_logged_in()) {
			?>
			<div class="bbc-logged-in-actions">
				<ul class="navbar-nav">
					<li class="nav-item">
						<?php
							echo Nh_Forms::get_instance()
										 ->create_form(
											 [
												 'search' => [
													 'class'       => 'ninja-s',
													 'type'        => 'text',
													 'name'        => 's',
													 'placeholder' => __( 'Search', 'ninja' ),
													 'before'      => '',
													 'after'       => '<i class="bbc-search2 ninja-header-search-icon"></i>',
													 'order'       => 0,
												 ],
											 ],
											 [
												 'action' => apply_filters( 'nhml_permalink', home_url() ),
												 'class'  => Nh::_DOMAIN_NAME . '-header-search-form',
												 'id'     => Nh::_DOMAIN_NAME . '_header_search_form',
											 ]
										 );
						?>
					</li>
					<li class="nav-item">
						<?php get_template_part( 'app/Views/template-parts/notifications/notification' ); ?>
					</li>
					<li class="nav-item bbc-user-profile-btn">
						<a class="nav-link" href="#">
						<span class="btn-profile-title">
							<?php echo sprintf( __( 'Welcome, <b>%s</b>!', 'ninja' ), Nh_User::get_current_user()->display_name ); ?>
						</span>
							<span class="btn-profile-desc">
							<?php echo __( 'Standard dummy text ever since the 1500s.', 'ninja' ); ?>
						</span>
						</a>
					</li>
				</ul>
			</div>
			<?php
		}
		?>

	</nav><!-- #site-navigation -->
</header><!-- #masthead -->
