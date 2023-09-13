<?php
    /**
     * Filename: nh_config_contact.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

     use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Config_Contact
     * @version 1.0
     * @since 1.0.0
     * @package nh
     * @author  - Mustafa Shaaban
     */
    class Nh_Config_Contact
    {
        protected array $nh_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->nh_configuration = NH_CONFIGURATION;
            $this->pages             = $pages;

            add_action('wp_ajax_ninja_contact_ajax', [
                $this,
                'contact_ajax'
            ]);
            add_action('wp_ajax_ninja_social_ajax', [
                $this,
                'social_ajax'
            ]);
            add_action('wp_ajax_ninja_apps_ajax', [
                $this,
                'apps_ajax'
            ]);
        }

        public function nh_contact_info_page()
        {
            include_once PLUGIN_PATH . 'admin/partials/page-contact.php';
        }

        public function contact_ajax()
        {
            $form_data  = $_POST['data'];
            $new_config = [];

            foreach ($form_data as $name => $value) {
                if (empty($value) && $value !== '0') {
                    wp_send_json([
                        'success'   => False,
                        'msg'       => __('Please fulfill all required inputs!', 'ninja'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'ninja'),
                    ]);
                }

//                if (array_key_exists(sanitize_text_field($name), $this->nh_configuration['contact'])) {
                    $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
//                }
            }
            $this->nh_configuration['contact'] = $new_config;

            update_option('nh_configurations', $this->nh_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Contact info links has been updated!', 'ninja'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'ninja')
            ]);
        }

        public function social_ajax()
        {
            $form_data  = $_POST['data'];
            $new_config = [];

            foreach ($form_data as $name => $value) {
                if (empty($value) && $value !== '0') {
                    wp_send_json([
                        'success'   => False,
                        'msg'       => __('Please fulfill all required inputs!', 'ninja'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'ninja'),
                    ]);
                }

                $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
            }

            $this->nh_configuration['social'] = $new_config;

            update_option('nh_configurations', $this->nh_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Social links has been updated!', 'ninja'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'ninja')
            ]);
        }

        public function apps_ajax()
        {
            $form_data  = $_POST['data'];
            $new_config = [];

            foreach ($form_data as $name => $value) {
                if (empty($value) && $value !== '0') {
                    wp_send_json([
                        'success'   => False,
                        'msg'       => __('Please fulfill all required inputs!', 'ninja'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'ninja'),
                    ]);
                }

                $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
            }

            $this->nh_configuration['apps'] = $new_config;

            update_option('nh_configurations', $this->nh_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Application links has been updated!', 'ninja'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'ninja')
            ]);
        }

    }

