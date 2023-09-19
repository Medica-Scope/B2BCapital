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

?>
<div class="landing-page main">
    <div class="back-texture">
        <img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/landing-page/texture.webp" alt="Texture"
             class="img-fluid">
    </div>
    <!-- App Sidebar -->
    <aside class="sidebar">
        <!-- App Brand -->
        <a href="/" class="app-brand">
            <img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp"
                 alt="B2B Capital Logo" class="img-fluid">
        </a>
        <!-- App Language Switcher -->
        <a class="language-link" href="#">العربية</a>
        <!-- App Navigation -->
        <ul class="navbar-nav app-navigation">
            <li class="nav-item">
                <a class="nav-link" href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('contact-us'))) ?>"><?= __('Contact Us', 'ninja') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('about'))) ?>"><?= __('About', 'ninja') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= get_post_type_archive_link('service') ?>"><?= __('Services', 'ninja') ?></a>
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
                        <a href="<?= Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_in'] ?>" target="_blank" class="social-link"><i
                                class="social-icon bbc-linkedin"></i></a>
                    </li>
                    <li class="social-item">
                        <a href="<?= Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_fb'] ?>" target="_blank" class="social-link"><i
                                class="social-icon bbc-facebook"></i></a>
                    </li>
                    <li class="social-item">
                        <a href="<?= Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_ig'] ?>" target="_blank" class="social-link"><i
                                class="social-icon bbc-instagram"></i></a>
                    </li>
                    <li class="social-item">
                        <a href="<?= Nh_Init::$_NH_CONFIGURATION['social']['ninja_social_tw'] ?>" target="_blank" class="social-link"><i
                                class="social-icon bbc-twitter"></i></a>
                    </li>
                </ul>
                <div class="user-area">
                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/registration'))) ?>?type=investor" class="user-action bbc-btn
					outline success"><?= __('Join as Investor', 'ninja') ?></a>
                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/registration'))) ?>?type=owner"
                       class="user-action bbc-btn outline action"><?= __('Join as Owner', 'ninja') ?></a>
                    <span class="user-action user-menu">
						<span class="icon bbc-menu"><span class="path1"></span><span class="path2"></span><span
                                class="path3"></span><span class="path4"></span><span class="path5"></span><span
                                class="path6"></span><span class="path7"></span><span class="path8"></span><span
                                class="path9"></span></span>
					</span>
                </div>

            </header><!-- #masthead -->
