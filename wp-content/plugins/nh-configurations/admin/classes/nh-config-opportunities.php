<?php
    /**
     * @Filename: nh_config_opportunities.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/18/2022
     */

     use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Config_Opportunities
     * @version 1.0
     * @since 1.0.0
     * @package nh
     * @author  - Mustafa Shaaban
     */
    class Nh_Config_Opportunities
    {
        protected array $nh_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->nh_configuration = NH_CONFIGURATION;
            $this->pages             = $pages;

            add_action('wp_ajax_ninja_opportunities_ajax', [
                $this,
                'opportunities_ajax'
            ]);
        }

        public function nh_opportunities_page(): void
        {
            include_once PLUGIN_PATH . 'admin/partials/page-opportunity-fields.php';
        }

        public function opportunities_ajax(): void
        {
            $form_data  = $_POST['data'];
            $new_config = [
                Nh::_DOMAIN_NAME . '_date_founded' => 0,
                Nh::_DOMAIN_NAME . '_asking_price_in_usd' => 0,
                Nh::_DOMAIN_NAME . '_number_of_customers' => 0,
                Nh::_DOMAIN_NAME . '_business_team_size' => 0,
                Nh::_DOMAIN_NAME . '_location' => 0,
                Nh::_DOMAIN_NAME . '_net_profit' => 0,
                Nh::_DOMAIN_NAME . '_valuation_in_usd' => 0,
                Nh::_DOMAIN_NAME . '_stake_to_be_sold_percentage' => 0,
                Nh::_DOMAIN_NAME . '_usd_exchange_rate_used_in_conversion' => 0,
                Nh::_DOMAIN_NAME . '_annual_accounting_revenue' => 0,
                Nh::_DOMAIN_NAME . '_annual_growth_rate_percentage' => 0,
                Nh::_DOMAIN_NAME . '_annual_growth_rate' => 0,
                Nh::_DOMAIN_NAME . '_tech_stack_this_product_is_built_on' => 0,
                Nh::_DOMAIN_NAME . '_product_competitors' => 0,
                Nh::_DOMAIN_NAME . '_extra_details' => 0,
            ];

            foreach ($form_data as $name => $value) {
//                if (empty($value) && $value !== '0') {
//                    wp_send_json([
//                        'success'   => False,
//                        'msg'       => __('Please fulfill all required inputs!', 'ninja'),
//                        'toast_msg' => __("The system didn't update the configuration due to certain issues.", 'ninja'),
//                    ]);
//                }

                $new_config[sanitize_text_field($name)] = sanitize_text_field($value);

            }
            $this->nh_configuration['opportunities_fields'] = $new_config;

            update_option('nh_configurations', $this->nh_configuration);

            wp_send_json([
                'success'   => TRUE,
                'msg'       => __('Opportunity fields has been updated!', 'ninja'),
                'toast_msg' => __('Your configuration has been updated successfully.', 'ninja')
            ]);
        }

    }

