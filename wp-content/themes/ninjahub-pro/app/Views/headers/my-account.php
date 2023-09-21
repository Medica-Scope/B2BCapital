<?php
	/**
	 * @Filename: my-account.php
	 * @Description:
	 * @User: NINJA MASTER - Mustafa Shaaban
	 * @Date: 4/26/2023
	 */

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
			<a href="<?php echo home_url(); ?>"><img src="<?php echo Nh::get_site_logo(); ?>" alt="Nh Site Logo" /></a>
		</div>

	</nav><!-- #site-navigation -->
</header><!-- #masthead -->
