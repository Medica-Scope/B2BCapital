<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       https://www.linkedin.com/in/mustafa-shaaban22/
     * @since      1.0.0
     *
     * @package    B2b_Configurations
     * @subpackage B2b_Configurations/admin
     */

     use B2B\B2b;

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    B2b_Configurations
     * @subpackage B2b_Configurations/admin
     * @author Mustafa Shaaban
     */
    class B2b_Configurations_Admin
    {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        private array                 $pages;
        private B2b_Config_Contact    $contact;
        private B2b_Config_Export     $export;

        /**
         * Initialize the class and set its properties.
         *
         * @param string $plugin_name The name of this plugin.
         * @param string $version The version of this plugin.
         *
         * @since    1.0.0
         */
        public function __construct($plugin_name, $version)
        {

            $this->plugin_name = $plugin_name;
            $this->version     = $version;
            $this->pages       = [
                'b2b-configuration' => __('Contact', 'b2b'),
                'b2b-export'        => __('Export Tool', 'b2b'),
            ];

            $this->load_dependencies();
            $this->add_actions();
            $this->add_filters();

        }

        private function load_dependencies()
        {
            require_once PLUGIN_PATH . 'admin/classes/b2b-config-contact.php';
            $this->contact = new B2b_Config_Contact($this->pages);

            require_once PLUGIN_PATH . 'admin/classes/b2b-config-export.php';
            $this->export = new B2b_Config_Export($this->pages);
        }

        protected function add_actions()
        {
            add_action('admin_menu', [
                $this,
                'setup_menu_option'
            ], 10);
        }

        protected function add_filters()
        {

        }

        public function setup_menu_option()
        {
            add_menu_page(__('B2B Configuration', 'b2b'), __('B2B Configuration', 'b2b'), 'manage_options', 'b2b-configuration', [
                $this->contact,
                'b2b_contact_info_page'
            ], PLUGIN_URL . 'admin/img/icon.png', 4);
            add_submenu_page('b2b-configuration', $this->pages['b2b-configuration'], __('Contact Info', 'b2b'), 'manage_options', 'b2b-configuration', [
                $this->contact,
                'b2b_contact_info_page'
            ]);
            add_submenu_page('b2b-configuration', $this->pages['b2b-export'], $this->pages['b2b-export'], 'manage_options', 'b2b-export', [
                $this->export,
                'b2b_export_page'
            ]);
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles()
        {

            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in B2b_Configurations_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The B2b_Configurations_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            if (isset($_GET['page']) && key_exists($_GET['page'], $this->pages)) {
                wp_enqueue_style($this->plugin_name . '-bs', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', [], $this->version, 'all');
                wp_enqueue_style($this->plugin_name . '-bs-fonts', plugin_dir_url(__FILE__) . 'css/bs-fonts/bootstrap-icons.css', [], $this->version, 'all');
            }

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/b2b-configurations-admin.css', [], $this->version, 'all');

        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts()
        {

            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in B2b_Configurations_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The B2b_Configurations_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            if (isset($_GET['page']) && key_exists($_GET['page'], $this->pages)) {
                wp_enqueue_media();
                wp_enqueue_script($this->plugin_name . '-tinymce', plugin_dir_url(__FILE__) . 'js/tinymce/tinymce.min.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-jqueryUI', plugin_dir_url(__FILE__) . 'js/jquery.blockUI.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-bs-script', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-function-script', plugin_dir_url(__FILE__) . 'js/b2b-configurations-functions.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/b2b-configurations-admin.js', [
                    'jquery',
                    $this->plugin_name . '-bs-script',
                    $this->plugin_name . '-function-script',
                    $this->plugin_name . '-tinymce',
                    $this->plugin_name . '-jqueryUI'
                ], $this->version, FALSE);

                wp_localize_script($this->plugin_name . '-script', 'b2bGlobals', [
                    'domain_key'  => B2b::_DOMAIN_NAME,
                    'icon'        => PLUGIN_URL . 'admin/img/icon.png',
                    'toast_title' => __('System Updates', 'b2b'),
                    'toast_time'  => __('Just Now', 'b2b'),
                    'loader_text' => __('Processing...', 'b2b'),
                    'submit_text' => __('Save', 'b2b'),
                    'ajaxUrl'     => admin_url('admin-ajax.php')
                ]);
            }

        }
    }

