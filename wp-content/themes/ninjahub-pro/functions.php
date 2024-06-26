<?php
/**
 * nh functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NinjaHub
 */

namespace NH;

use NH\APP\CLASSES\Nh_Init;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\ADMIN\Nh_Admin;
use NH\APP\MODELS\FRONT\Nh_Public;

if ( ! defined( 'NH_lANG' ) ) {
	define( 'NH_lANG', defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : 'en' );
}

if ( ! defined( 'THEME_PATH' ) ) {
	define( 'THEME_PATH', get_stylesheet_directory() );
}

if ( ! defined( 'THEME_URI' ) ) {
	define( 'THEME_URI', get_stylesheet_directory_uri() );
}

if ( ! defined( 'NH_CONFIGURATION' ) ) {
	define( 'NH_CONFIGURATION', get_option( 'nh_configurations' ) ?: [] );
}

locate_template( "app/Classes/class-nh_init.php", TRUE );
locate_template( "app/Models/public/class-nh_public.php", TRUE );
locate_template( "app/Models/admin/class-nh_admin.php", TRUE );
locate_template( "inc/tgm-plugin-activation.php", TRUE );
locate_template( "inc/template-tags.php", TRUE );

/**
 * Description...
 *
 * @class Nh
 * @version 1.0
 * @since 1.0.0
 * @package NinjaHub
 * @author Mustafa Shaaban
 */
class Nh {
	const _ENVIRONMENT = 'development';
	const _DOMAIN_NAME = 'ninja';
//	const _VERSION = '0.3.3';
    public static string $_VERSION;


	public function __construct() {
		self::$_VERSION = self::_ENVIRONMENT === 'development' ? rand(0, 10,) . '.' . rand(0, 10,) . '.' . rand(0, 10,) : '1.2.0';

        Nh_Init::get_instance()
			->run( 'core' );
		$hooks = new Nh_Hooks();
		$this->init_models( $hooks );
		$this->actions( $hooks );
		$this->filters( $hooks );
		$hooks->run();
	}

	/**
	 * Description...
	 *
	 * @param $hooks
	 *
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Mustafa Shaaban
	 * @return void
	 */
	private function init_models( $hooks ): void {
		if ( class_exists( 'NH\APP\MODELS\FRONT\Nh_Public' ) && ( ! is_admin() ) || wp_doing_ajax() ) {
			$public = new Nh_Public( $hooks );
		}

		if ( class_exists( 'NH\APP\MODELS\ADMIN\Nh_Admin' ) && is_admin() ) {
			$admin = new Nh_Admin( $hooks );
		}
	}

	/**
	 * Description...
	 * @return void
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Mustafa Shaaban
	 */
	private function actions( $hooks ): void {
		$hooks->add_action( 'after_setup_theme', $this, 'nh_setup' );
		$hooks->add_action( 'widgets_init', $this, 'nh_widgets_init' );
		$hooks->add_action( 'customize_register', $this, 'theme_customizer' );
		$hooks->add_action( 'init', $this, 'nh_logout_rewrite_rule' );
	}


	private function filters( $hooks ): void {
		$hooks->add_filter( 'body_class', $this, 'body_classes', 10, 2 );
		$hooks->add_filter( 'query_vars', $this, 'nh_logout_query_vars' );
		$hooks->add_filter( 'template_include', $this, 'nh_logout_template' );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function nh_setup(): void {
		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 */
		$GLOBALS['content_width'] = apply_filters( 'nh_content_width', 640 );

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on nh, use a find and replace
		 * to change 'ninja' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ninja', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( [
			'default-menu'            => esc_html__( 'Default', 'ninja' ),
			'dashboard-guest-menu'    => esc_html__( 'Dashboard Guest', 'ninja' ),
			'dashboard-admin-menu'    => esc_html__( 'Dashboard Admin', 'ninja' ),
			'dashboard-owner-menu'    => esc_html__( 'Dashboard Owner', 'ninja' ),
			'dashboard-investor-menu' => esc_html__( 'Dashboard Investor', 'ninja' ),
			'footer-menu'             => esc_html__( 'Footer', 'ninja' ),
			'bottom-footer-menu'      => esc_html__( 'Bottom Footer', 'ninja' ),
			'profile-menu-login'      => esc_html__( 'Profile Login', 'ninja' ),
			'profile-menu-logout'     => esc_html__( 'Profile Logout', 'ninja' ),
		] );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'nh_custom_background_args', [
			'default-color' => 'ffffff',
			'default-image' => '',
		] ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', [
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => TRUE,
			'flex-height' => TRUE,
		] );
	}

	/**
	 * Register widget area.
	 */
	public function nh_widgets_init(): void {
		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'ninja' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ninja' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );

		register_sidebar( [
			'name'          => esc_html__( 'Footer', 'ninja' ),
			'id'            => 'nh-footer',
			'description'   => esc_html__( 'Add widgets here.', 'ninja' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );
	}


	/**
	 * Description...
	 *
	 * @param $wp_customize
	 *
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Mustafa Shaaban
	 * @return void
	 */
	public function theme_customizer( $wp_customize ): void {
		// Register a new setting for the second logo
		$wp_customize->add_setting( 'second_logo', [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		] );

		// Add a control to upload the second logo
		$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'second_logo', [
			'label'    => __( 'Second Logo', 'ninja' ),
			'section'  => 'title_tagline',
			// This places the control in the Site Identity section
			'settings' => 'second_logo',
		] ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( array $classes ): array {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}

	/**
	 * Description...
	 * @version 1.0
	 * @since 1.0.0
	 * @package NinjaHub
	 * @author Mustafa Shaaban
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	static function get_site_logo( string $id = 'custom_logo' ): string {
		$logo_id = get_theme_mod( $id );
		if ( is_numeric( $logo_id ) ) {
			$logo_info = wp_get_attachment_image_src( $logo_id, 'full' );
			$logo_url  = $logo_info[0];
		} else {
			$logo_url = $logo_id;
		}
		return $logo_url;
	}

	public function nh_logout_rewrite_rule(): void {
		add_rewrite_rule( '^nh_account/nh_logout/?', 'index.php?pagename=nh_logout', 'top' );
	}

	public function nh_logout_query_vars( $vars ) {
		$vars[] = 'nh_logout';
		return $vars;
	}

	public function nh_logout_template( $template ): string {
		$pagename = get_query_var( 'pagename' );

		switch ( $pagename ) {
			case "nh_logout":
				if ( is_user_logged_in() ) {
					wp_logout();
					wp_safe_redirect( home_url() );
				} else {
					wp_safe_redirect( apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account' ) ) ) );
				}
				exit();
			default;
		}

		return $template;
	}

}

new Nh();

locate_template( "inc/custom-functions.php", TRUE );