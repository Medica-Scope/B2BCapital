<?php
    /**
     * Filename: b2b_config_contact.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

     use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Config_Contact
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author  - Mustafa Shaaban
     */
    class B2b_Config_Contact
    {
        protected array $b2b_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->b2b_configuration = B2B_CONFIGURATION;
            $this->pages             = $pages;

            add_action('wp_ajax_b2b_contact_ajax', [
                $this,
                'contact_ajax'
            ]);
            add_action('wp_ajax_b2b_social_ajax', [
                $this,
                'social_ajax'
            ]);
            add_action('wp_ajax_b2b_apps_ajax', [
                $this,
                'apps_ajax'
            ]);
        }

        public function b2b_contact_info_page()
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
                        'msg'       => __('Please fulfill all required inputs!', 'b2b'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'b2b'),
                    ]);
                }

                if (array_key_exists(sanitize_text_field($name), $this->b2b_configuration['contact'])) {
                    $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
                }
            }
            $this->b2b_configuration['contact'] = $new_config;

            update_option('b2b_configurations', $this->b2b_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Contact info links has been updated!', 'b2b'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'b2b')
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
                        'msg'       => __('Please fulfill all required inputs!', 'b2b'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'b2b'),
                    ]);
                }

                $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
            }

            $this->b2b_configuration['social'] = $new_config;

            update_option('b2b_configurations', $this->b2b_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Social links has been updated!', 'b2b'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'b2b')
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
                        'msg'       => __('Please fulfill all required inputs!', 'b2b'),
                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'b2b'),
                    ]);
                }

                $new_config[sanitize_text_field($name)] = sanitize_text_field($value);
            }

            $this->b2b_configuration['apps'] = $new_config;

            update_option('b2b_configurations', $this->b2b_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Application links has been updated!', 'b2b'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'b2b')
            ]);
        }

    }

