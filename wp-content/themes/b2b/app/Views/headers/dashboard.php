`<?php
    /**
     * @Filename: dashboard.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;
    use B2B\B2b;

?>

<header id="masthead" class="site-header">
    <nav id="site-navigation" class="main-navigation d-flex justify-content-around align-items-center">
        <div class="site-branding">
            <a href="<?= home_url() ?>"><img src="<?= B2b::get_site_logo(); ?>" alt="B2b Site Logo"/></a>
        </div>

        <?php
            if (B2b_User::get_user_role() == B2b_User::INVESTOR) {
                wp_nav_menu([
                    'theme_location' => 'dashboard-investor-menu',
                    'menu_id'        => 'investor-menu',
                ]);
            } elseif (B2b_User::get_user_role() == B2b_User::OWNER) {
                wp_nav_menu([
                    'theme_location' => 'dashboard-owner-menu',
                    'menu_id'        => 'owner-menu',
                ]);
            } else {
                wp_nav_menu([
                    'theme_location' => 'dashboard-owner-menu',
                    'menu_id'        => 'owner-menu',
                ]);
            }
        ?>

        <div>
            search
        </div>


        <div>
            <?php get_template_part('app/Views/template-parts/notifications/notification'); ?>
        </div>


        <div>
            Welcome, <?= B2b_User::get_current_user()->display_name ?> !
            Standard dummy Since the 1500s,
        </div>
    </nav><!-- #site-navigation -->
</header><!-- #masthead -->
`