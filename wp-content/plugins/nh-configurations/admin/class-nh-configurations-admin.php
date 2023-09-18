<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       https://www.linkedin.com/in/mustafa-shaaban22/
     * @since      1.0.0
     *
     * @package    Nh_Configurations
     * @subpackage Nh_Configurations/admin
     */

     use NH\Nh;

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Nh_Configurations
     * @subpackage Nh_Configurations/admin
     * @author Mustafa Shaaban
     */
    class Nh_Configurations_Admin
    {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private string $plugin_name;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private string $version;

        private array                 $pages;
        private Nh_Config_Contact    $contact;
        private Nh_Config_Export     $export;
        private Nh_Config_Import     $import;

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
                'nh-configuration' => __('Contact', 'ninja'),
                'nh-export'        => __('Export Tool', 'ninja'),
                'nh-import'        => __('Import Tool', 'ninja'),
            ];

            $this->load_dependencies();
            $this->add_actions();
            $this->add_filters();

        }

        private function load_dependencies()
        {
            require_once PLUGIN_PATH . 'admin/classes/nh-config-contact.php';
            $this->contact = new Nh_Config_Contact($this->pages);

            require_once PLUGIN_PATH . 'admin/classes/nh-config-export.php';
            $this->export = new Nh_Config_Export($this->pages);

            require_once PLUGIN_PATH . 'admin/classes/nh-config-import.php';
            $this->import = new Nh_Config_Import($this->pages);
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
            add_menu_page(__('NH Configuration', 'ninja'), __('NH Configuration', 'ninja'), 'manage_options', 'nh-configuration', [
                $this->contact,
                'nh_contact_info_page'
            ], PLUGIN_URL . 'admin/img/icon.png', 4);
            add_submenu_page('nh-configuration', $this->pages['nh-configuration'], __('Contact Info', 'ninja'), 'manage_options', 'nh-configuration', [
                $this->contact,
                'nh_contact_info_page'
            ]);
            add_submenu_page('nh-configuration', $this->pages['nh-export'], $this->pages['nh-export'], 'manage_options', 'nh-export', [
                $this->export,
                'nh_export_page'
            ]);
            add_submenu_page('nh-configuration', $this->pages['nh-import'], $this->pages['nh-import'], 'manage_options', 'nh-import', [
                $this->import,
                'nh_import_page'
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
             * defined in Nh_Configurations_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Nh_Configurations_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            if (isset($_GET['page']) && key_exists($_GET['page'], $this->pages)) {
                wp_enqueue_style($this->plugin_name . '-bs', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', [], $this->version, 'all');
                wp_enqueue_style($this->plugin_name . '-bs-fonts', plugin_dir_url(__FILE__) . 'css/bs-fonts/bootstrap-icons.css', [], $this->version, 'all');
            }

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nh-configurations-admin.css', [], $this->version, 'all');

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
             * defined in Nh_Configurations_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Nh_Configurations_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            if (isset($_GET['page']) && key_exists($_GET['page'], $this->pages)) {
                wp_enqueue_media();
                wp_enqueue_script($this->plugin_name . '-tinymce', plugin_dir_url(__FILE__) . 'js/tinymce/tinymce.min.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-jqueryUI', plugin_dir_url(__FILE__) . 'js/jquery.blockUI.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-bs-script', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-function-script', plugin_dir_url(__FILE__) . 'js/nh-configurations-functions.js', [ 'jquery' ], $this->version, FALSE);
                wp_enqueue_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/nh-configurations-admin.js', [
                    'jquery',
                    $this->plugin_name . '-bs-script',
                    $this->plugin_name . '-function-script',
                    $this->plugin_name . '-tinymce',
                    $this->plugin_name . '-jqueryUI'
                ], $this->version, FALSE);

                wp_localize_script($this->plugin_name . '-script', 'nhGlobals', [
                    'domain_key'  => Nh::_DOMAIN_NAME,
                    'icon'        => PLUGIN_URL . 'admin/img/icon.png',
                    'toast_title' => __('System Updates', 'ninja'),
                    'toast_time'  => __('Just Now', 'ninja'),
                    'loader_text' => __('Processing...', 'ninja'),
                    'submit_text' => __('Save', 'ninja'),
                    'import_text' => __('Start', 'ninja'),
                    'export_text' => __('Export', 'ninja'),
                    'ajaxUrl'     => admin_url('admin-ajax.php')
                ]);
            }

        }
    }