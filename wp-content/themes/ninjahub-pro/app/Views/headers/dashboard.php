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
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-header-dashboard', Nh_Hooks::PATHS['public']['css'] . '/components/header/header-dashboard');
?>

<header id="masthead" class="site-header container-fluid container-xxl">
    <nav id="site-navigation" class="main-navigation">

        <div class="site-branding">
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard'))) ?>"><img
                    src="<?= Nh::get_site_logo(); ?>" alt="Nh Site Logo"/></a>
        </div>

        <?php
            function get_wp_nav_menu($theme_location = 'dashboard-guest-menu', $container_class = '')
            {
                return wp_nav_menu([
                    'theme_location'  => $theme_location,
                    'container_class' => 'bbc-default-menu-container ' . $container_class,
                    'container_id'    => 'bbc-default-menu-container',
                    'menu_class'      => 'navbar-nav',
                    'menu_id'         => 'bbc-default-navbar-nav',
                    'fallback_cb'     => '',
                    'depth'           => 2,
                    'walker'          => new \NH\APP\HELPERS\Nh_Bootstrap_Navwalker(),
                ]);
            }

            switch (Nh_User::get_user_role()) {
                case Nh_User::OWNER:
                    get_wp_nav_menu('dashboard-owner-menu', 'd-none d-lg-block');
                    break;
                case Nh_User::INVESTOR:
                    get_wp_nav_menu('dashboard-investor-menu', 'd-none d-lg-block');
                    break;
                case Nh_User::ADMIN:
                    get_wp_nav_menu('dashboard-admin-menu', 'd-none d-lg-block');
                    break;
                default:
                    get_wp_nav_menu('dashboard-guest-menu', 'd-none d-lg-block');
                    break;
            }

            if (is_user_logged_in()) {
                ?>
                <div class="bbc-logged-in-actions">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php
                                echo Nh_Forms::get_instance()
                                             ->create_form([
                                                 'search' => [
                                                     'class'       => 'm-0 p-0 ninja-s',
                                                     'type'        => 'text',
                                                     'name'        => 's',
                                                     'placeholder' => __('Search', 'ninja'),
                                                     'before'      => '',
                                                     'after'       => '<i class="bbc-search2 ninja-header-search-icon"></i>',
                                                     'order'       => 0,
                                                 ],
                                             ], [
                                                 'action' => apply_filters('nhml_permalink', home_url()),
                                                 'class'  => Nh::_DOMAIN_NAME . '-header-search-form',
                                                 'id'     => Nh::_DOMAIN_NAME . '_header_search_form',
                                             ]);
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php get_template_part('app/Views/template-parts/notifications/notification'); ?>
                        </li>
                        <li class="nav-item bbc-user-profile-btn dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                               data-bs-toggle="dropdown" data-bs-auto-close="true">
						<span class="btn-profile-title">
							<?= sprintf(_x('Welcome, <b>%s</b>!', 'ninja'), Nh_User::get_current_user()->display_name); ?>
						</span>
                                <span class="btn-profile-desc">
							<?= __('Standard dummy text ever since the 1500s.', 'ninja'); ?>
						</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>">
                                        <?= __('My Account', 'ninja') ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>">
                                        <?= __('Opportunities', 'ninja') ?>
                                    </a>
                                </li>

                                <?php if (Nh_User::get_user_role() === Nh_User::OWNER) { ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity'))) ?>">
                                            <?= __('Create Opportunities', 'ninja') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
									/*
									<li>
										<a class="dropdown-item"
											href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/my-widgets' ) ) ) ?>">
											<?= __( 'Widgets', 'ninja' ) ?>
										</a>
									</li>
                             		*/
                                ?>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-favorite-articles'))) ?>">
                                        <?= __('Articles', 'ninja') ?>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="/nh_account/nh_logout"><i
                                            class="bbc-log-out text-danger"></i></i>
                                        <?= __('Logout', 'ninja'); ?>
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php
            }
        ?>

    </nav><!-- #site-navigation -->


    <div class="offcanvas offcanvas-start" data-bs-backdrop="false" tabindex="-1" id="staticBackdrop"
         aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">
                <a href="<?= home_url() ?>" class="app-brand">
                    <img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp"
                         alt="B2B Capital Logo" class="img-fluid">
                </a>
            </h5>
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas" aria-label="Close">X</button>
        </div>
        <div class="offcanvas-body">
            <?php
                switch (Nh_User::get_user_role()) {
                    case Nh_User::OWNER:
                        get_wp_nav_menu('dashboard-owner-menu');
                        break;
                    case Nh_User::INVESTOR:
                        get_wp_nav_menu('dashboard-investor-menu');
                        break;
                    case Nh_User::ADMIN:
                        get_wp_nav_menu('dashboard-admin-menu');
                        break;
                    default:
                        get_wp_nav_menu('dashboard-guest-menu');
                        break;
                }
            ?>
        </div>
    </div>
</header><!-- #masthead -->