<?php
/**
 * @Filename: default.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

/**
 * Include Header Style File.
 */
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/components/header/header-dashboard' );
?>

<header id="masthead" class="site-header container-fluid container-xxl">
	<nav id="site-navigation" class="main-navigation">

		<div class="site-branding">
			<a href="<?php echo home_url(); ?>"><img src="<?php echo Nh::get_site_logo(); ?>" alt="Nh Site Logo" /></a>
		</div>

		<?php
		if ( is_user_logged_in() ) {
			$current_user_info        = wp_get_current_user();
			$current_user_roles       = (array) $current_user_info->roles;
			$is_current_user_owner    = array_key_exists( 'owner', $current_user_roles );
			$is_current_user_investor = array_key_exists( 'investor', $current_user_roles );
			$is_current_user_admin    = array_key_exists( 'admin', $current_user_roles );

			if ( $is_current_user_owner ) {
				/**
				 * Include owner type menu
				 */
				wp_nav_menu(
					[
						'theme_location'  => 'profile-menu-login',
						'container_class' => 'bbc-logged-in-menu-container',
						'container_id'    => 'bbc-logged-in-menu-container',
						'menu_class'      => 'navbar-nav',
						'menu_id'         => 'bbc-logged-in-navbar-nav',
						'fallback_cb'     => '',
						'depth'           => 2,
						'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
					]
				);
			} elseif ( $is_current_user_investor ) {
				/**
				 * Include investor type menu
				 */
				wp_nav_menu(
					[
						'theme_location'  => 'default-menu',
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
			?>
		<div class="bbc-logged-in-actions">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="bbc-search2"></i></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="bbc-bell2"></i></a>
				</li>
				<li class="nav-item bbc-user-profile-btn">
					<a class="nav-link" href="#">
						<span
							class="btn-profile-title"><?php echo __( 'Welcome,' ) . ' '; ?><b><?php echo $current_user_info->display_name; ?></b>!</span>
						<span class="btn-profile-desc"><?php echo __( 'Standard dummy text ever since the 1500s.' ); ?></span>
					</a>
				</li>
			</ul>
		</div>
			<?php
		} else {
			/**
			 * Include guest type menu
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'default-menu',
					'container_class' => 'bbc-default-menu-container',
					'container_id'    => 'bbc-default-menu-container',
					'menu_class'      => 'navbar-nav',
					'fallback_cb'     => '',
					'menu_id'         => 'bbc-default-navbar-nav',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
			/**
			 * Include actions menu.
			 */
			wp_nav_menu(
				[
					'theme_location'  => 'profile-menu-logout',
					'container_class' => 'bbc-actions-menu-container',
					'container_id'    => 'bbc-actions-menu-container',
					'menu_class'      => 'navbar-nav',
					'menu_id'         => 'bbc-actions-navbar-nav',
					'fallback_cb'     => '',
					'depth'           => 2,
					'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
				]
			);
		}
		?>
	</nav><!-- #site-navigation -->
</header><!-- #masthead -->
