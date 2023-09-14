<?php
    /**
     * b2b functions and definitions
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @package b2b
     */

    namespace B2B;

    use B2B\APP\CLASSES\B2b_Init;
    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\APP\MODELS\ADMIN\B2b_Admin;
    use B2B\APP\MODELS\FRONT\B2b_Public;

    if (!defined('B2B_lANG')) {
        define('B2B_lANG', defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
    }

    if (!defined('THEME_PATH')) {
        define('THEME_PATH', get_stylesheet_directory());
    }

    if (!defined('THEME_URI')) {
        define('THEME_URI', get_stylesheet_directory_uri());
    }

    if (!defined('B2B_CONFIGURATION')) {
        define('B2B_CONFIGURATION', get_option('b2b_configurations') ?: []);
    }

    require_once THEME_PATH . "/app/Classes/class-b2b_init.php";
    require_once THEME_PATH . "/app/Models/public/class-b2b_public.php";
    require_once THEME_PATH . "/app/Models/admin/class-b2b_admin.php";
    require_once THEME_PATH . "/inc/template-tags.php";

    /**
     * Description...
     *
     * @class B2b
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b
    {
        const _ENVIRONMENT = 'development';
        const _DOMAIN_NAME = 'b2b';
        const _VERSION     = '0.1.0';


        public function __construct()
        {
            B2b_Init::get_instance()
                    ->run('core');
            $hooks = new B2b_Hooks();
            $this->init_models($hooks);
            $this->actions($hooks);
            $this->filters($hooks);
            $hooks->run();
        }

        /**
         * Description...
         *
         * @param $hooks
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        private function init_models($hooks): void
        {
            if (class_exists('B2B\APP\MODELS\FRONT\B2b_Public') && (!is_admin()) || wp_doing_ajax()) {
                $public = new B2b_Public($hooks);
            }

            if (class_exists('B2B\APP\MODELS\ADMIN\B2b_Admin') && is_admin()) {
                $admin = new B2b_Admin($hooks);
            }
        }

        /**
         * Description...
         * @return void
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        private function actions($hooks): void
        {
            $hooks->add_action('after_setup_theme', $this, 'b2b_setup');
            $hooks->add_action('widgets_init', $this, 'b2b_widgets_init');
            $hooks->add_action('customize_register', $this, 'theme_customizer');
        }


        private function filters($hooks): void
        {
            $hooks->add_filter('body_class', $this, 'body_classes', 10, 2);

        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function b2b_setup(): void
        {
            /**
             * Set the content width in pixels, based on the theme's design and stylesheet.
             */
            $GLOBALS['content_width'] = apply_filters('b2b_content_width', 640);

            /*
                * Make theme available for translation.
                * Translations can be filed in the /languages/ directory.
                * If you're building a theme based on b2b, use a find and replace
                * to change 'b2b' to the name of your theme in all the template files.
                */
            load_theme_textdomain('b2b', get_template_directory() . '/languages');

            // Add default posts and comments RSS feed links to head.
            add_theme_support('automatic-feed-links');

            /*
            * Let WordPress manage the document title.
            * By adding theme support, we declare that this theme does not use a
            * hard-coded <title> tag in the document head, and expect WordPress to
            * provide it for us.
            */
            add_theme_support('title-tag');

            /*
                * Enable support for Post Thumbnails on posts and pages.
                *
                * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
                */
            add_theme_support('post-thumbnails');

            // This theme uses wp_nav_menu() in one location.
            register_nav_menus([
                'default-menu'            => esc_html__('Default', 'b2b'),
                'dashboard-owner-menu'    => esc_html__('Dashboard Owner', 'b2b'),
                'dashboard-investor-menu' => esc_html__('Dashboard Investor', 'b2b'),
                'footer-menu'             => esc_html__('Footer', 'b2b'),
                'bottom-footer-menu'      => esc_html__('Bottom Footer', 'b2b'),
                'profile-menu-login'      => esc_html__('Account Login', 'b2b'),
                'profile-menu-logout'     => esc_html__('Account Logout', 'b2b'),
            ]);

            /*
                * Switch default core markup for search form, comment form, and comments
                * to output valid HTML5.
                */
            add_theme_support('html5', [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]);

            // Set up the WordPress core custom background feature.
            add_theme_support('custom-background', apply_filters('b2b_custom_background_args', [
                'default-color' => 'ffffff',
                'default-image' => '',
            ]));

            // Add theme support for selective refresh for widgets.
            add_theme_support('customize-selective-refresh-widgets');

            /**
             * Add support for core custom logo.
             *
             * @link https://codex.wordpress.org/Theme_Logo
             */
            add_theme_support('custom-logo', [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => TRUE,
                'flex-height' => TRUE,
            ]);
        }

        /**
         * Register widget area.
         *
         * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
         */
        public function b2b_widgets_init(): void
        {
            register_sidebar([
                'name'          => esc_html__('Sidebar', 'b2b'),
                'id'            => 'sidebar-1',
                'description'   => esc_html__('Add widgets here.', 'b2b'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ]);
        }


        /**
         * Description...
         *
         * @param $wp_customize
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function theme_customizer($wp_customize): void
        {
            // Register a new setting for the second logo
            $wp_customize->add_setting('second_logo', [
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ]);

            // Add a control to upload the second logo
            $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'second_logo', [
                'label'    => __('Second Logo', 'b2b'),
                'section'  => 'title_tagline',
                // This places the control in the Site Identity section
                'settings' => 'second_logo',
            ]));
        }

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         *
         * @return array
         */
        public function body_classes(array $classes): array
        {
            // Adds a class of hfeed to non-singular pages.
            if (!is_singular()) {
                $classes[] = 'hfeed';
            }

            // Adds a class of no-sidebar when there is no sidebar present.
            if (!is_active_sidebar('sidebar-1')) {
                $classes[] = 'no-sidebar';
            }

            return $classes;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         *
         * @param string $id
         *
         * @return string
         */
        static function get_site_logo(string $id = 'custom_logo'): string
        {
            $logo_id = get_theme_mod($id);
            if (is_numeric($logo_id)) {
                $logo_info = wp_get_attachment_image_src($logo_id, 'full');
                $logo_url  = $logo_info[0];
            } else {
                $logo_url = $logo_id;
            }
            return $logo_url;
        }

    }

    new B2b();

    require_once THEME_PATH . "/inc/custom-functions.php";