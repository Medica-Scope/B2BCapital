<?php
    /**
     * @Filename: default.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\Nh;

?>

<header id="masthead" class="site-header">
    <nav id="site-navigation" class="main-navigation d-flex justify-content-around align-items-center">

        <div class="site-branding">
            <a href="<?= home_url() ?>"><img src="<?= Nh::get_site_logo('second_logo'); ?>" alt="Nh Site Logo" /></a>
        </div>

        <?php
            wp_nav_menu([
                'theme_location' => 'default-menu',
                'menu_id'        => 'main-menu',
            ]);

//            wp_nav_menu(
//                array(
//                    'theme_location'  => 'default-menu',
//                    'container_class' => 'collapse navbar-collapse',
//                    'container_id'    => 'navbarNavDropdown',
//                    'menu_class'      => 'navbar-nav ml-auto',
//                    'fallback_cb'     => '',
//                    'menu_id'         => 'main-menu',
//                    'depth'           => 2,
//                    'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
//                )
//            );
        ?>

        <?php
            if (is_user_logged_in()) {
                wp_nav_menu([
                    'theme_location' => 'profile-menu-login',
                    'menu_id'        => 'account-menu-login',
                ]);
            } else {
                wp_nav_menu([
                    'theme_location' => 'profile-menu-logout',
                    'menu_id'        => 'account-menu-logout',
                ]);
            }
        ?>
    </nav><!-- #site-navigation -->
</header><!-- #masthead -->