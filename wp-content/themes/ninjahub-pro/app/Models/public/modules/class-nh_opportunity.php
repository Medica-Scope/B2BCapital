<?php
    /**
     * @Filename: class-nh_opportunity.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Ajax_Response;
    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\Nh;
    use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Opportunity
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Opportunity extends Nh_Module
    {
        public array $meta_data = [
            // Opportunity Data
            'opportunity_type',
            'start_bidding_amount',
            'target_amount',
            'project_phase',
            'project_start_date',
            'project_assets_amount',
            'project_yearly_cashflow_amount',
            'project_yearly_net_profit_amount',

            //Basic Info
            'short_description',
            //            'date_founded',
            //            'asking_price_in_usd',
            //            'number_of_customers',
            //            'business_team_size',
            //            'location',

            'type_of_company_group_type_of_company',
            'type_of_company_group_appearance',

            'date_founded_group_date_founded',
            'date_founded_group_appearance',

            'asking_price_in_usd_group_asking_price_in_usd',
            'asking_price_in_usd_group_appearance',

            'number_of_customers_group_number_of_customers',
            'number_of_customers_group_appearance',

            'business_team_size_group_business_team_size',
            'business_team_size_group_appearance',

            'location_group_location',
            'location_group_appearance',

            // Financial Info
            //            'net_profit',
            //            'valuation_in_usd',
            //            'shares_to_be_sold_percentage',
            //            'usd_exchange_rate_used_in_conversion',
            //            'annual_accounting_revenue',
            //            'annual_growth_rate_percentage',
            //            'annual_growth_rate',

            'net_profit_group_net_profit',
            'net_profit_group_appearance',

            'valuation_in_usd_group_valuation_in_usd',
            'valuation_in_usd_group_appearance',

            'shares_to_be_sold_percentage_group_shares_to_be_sold_percentage',
            'shares_to_be_sold_percentage_group_appearance',

            'usd_exchange_rate_used_in_conversion_group_usd_exchange_rate_used_in_conversion',
            'usd_exchange_rate_used_in_conversion_group_appearance',

            'annual_accounting_revenue_group_annual_accounting_revenue',
            'annual_accounting_revenue_group_appearance',

            'annual_growth_rate_percentage_group_annual_growth_rate_percentage',
            'annual_growth_rate_percentage_group_appearance',

            'annual_growth_rate_group_annual_growth_rate',
            'annual_growth_rate_group_appearance',

            'required_investment_amount_group_required_investment_amount',
            'required_investment_amount_group_appearance',

            'currency_group_currency',
            'currency_group_appearance',

            'investment_term_group_investment_term',
            'investment_term_group_appearance',

            'expected_returns_group_expected_returns',
            'expected_returns_group_appearance',

            'risk_level_group_risk_level',
            'risk_level_group_appearance',

            'regulatory_compliance_group_regulatory_compliance',
            'regulatory_compliance_group_appearance',


            // Business Information
            //            'tech_stack_this_product_is_built_on',
            //            'product_competitors',
            //            'extra_details',

            'tech_stack_this_product_is_built_on_group_tech_stack_this_product_is_built_on',
            'tech_stack_this_product_is_built_on_group_appearance',

            'product_competitors_group_product_competitors',
            'product_competitors_group_appearance',

            'extra_details_group_extra_details',
            'extra_details_group_appearance',

            // Status
            'opportunity_stage',
            'opportunity_stage_old',

            'related_opportunities',

            'step_two',
            'fav_count',
            'ignore_count',
            'opportunity_bids',
            'opportunity_acquisitions',
            'opportunity_investments',
        ];
        public array $taxonomy  = [
            'opportunity-category',
            'opportunity-type',
            'industry',
            'sectors',
            'business-model',
            'legal-structure'
        ];

        public function __construct()
        {
            parent::__construct('opportunity');
        }

        /**
         * Description...
         *
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_Post
         */
        public function convert(WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_create_opportunity_ajax', $this, 'create_opportunity');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_filter_opportunity_ajax', $this, 'filter_opportunity');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_filter_opportunity_ajax', $this, 'filter_opportunity');
            $this->hooks->add_action('get_header', $this, 'acf_form_head');
            $this->hooks->add_action('acf/save_post', $this, 'after_acf_form_submission', 20);
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_upload_attachment', $this, 'upload_attachment');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_upload_attachment', $this, 'upload_attachment');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_remove_attachment', $this, 'remove_attachment');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_remove_attachment', $this, 'remove_attachment');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_toggle_favorite_opportunity_ajax', $this, 'toggle_opportunity_favorite');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_toggle_favorite_opportunity_ajax', $this, 'toggle_opportunity_favorite');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_ignore_opportunity_ajax', $this, 'ignore_opportunity');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_ignore_opportunity_ajax', $this, 'ignore_opportunity');
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
            $this->hooks->add_filter('filter_opportunities_stage', $this, 'filter_opportunities_stage', 10, 2);

        }

        /**
         * @throws \Exception
         */
        public function create_opportunity(): void
        {
            global $user_ID;

            $form_data                        = $_POST['data'];
            $project_name                     = sanitize_text_field($form_data['project_name']);
            $sectors                          = (int)sanitize_text_field($form_data['sectors']);
            $legal_structure                  = (int)sanitize_text_field($form_data['legal_structure']);
            $description                      = sanitize_text_field($form_data['description']);
            $short_description                = sanitize_text_field($form_data['short_description']);
            $opportunity_type                 = (int)sanitize_text_field($form_data['opportunity_type']);
            $attachment_id                    = (int)sanitize_text_field(Nh_Cryptor::Decrypt($form_data['media_file_id']));
            $start_bidding_amount             = sanitize_text_field($form_data['start_bidding_amount']);
            $target_amount                    = sanitize_text_field($form_data['target_amount']);
            $project_phase                    = isset($form_data['project_phase']) ? sanitize_text_field($form_data['project_phase']) : '';
            $project_start_date               = sanitize_text_field($form_data['project_start_date']);
            $project_assets_amount            = sanitize_text_field($form_data['project_assets_amount']);
            $project_yearly_cashflow_amount   = sanitize_text_field($form_data['project_yearly_cashflow_amount']);
            $project_yearly_net_profit_amount = sanitize_text_field($form_data['project_yearly_net_profit_amount']);
            $type_of_company                  = sanitize_text_field($form_data['type_of_company']);
            $required_investment_amount       = sanitize_text_field($form_data['required_investment_amount']);
            $currency                         = sanitize_text_field($form_data['currency']);
            $investment_term                  = sanitize_text_field($form_data['investment_term']);
            $expected_returns                 = sanitize_text_field($form_data['expected_returns']);
            $risk_level                       = sanitize_text_field($form_data['risk_level']);
            $regulatory_compliance            = sanitize_text_field($form_data['regulatory_compliance']);

            $date_founded                         = sanitize_text_field($form_data['date_founded']);
            $asking_price_in_usd                  = sanitize_text_field($form_data['asking_price_in_usd']);
            $number_of_customers                  = sanitize_text_field($form_data['number_of_customers']);
            $business_team_size                   = sanitize_text_field($form_data['business_team_size']);
            $location                             = sanitize_text_field($form_data['location']);
            $net_profit                           = sanitize_text_field($form_data['net_profit']);
            $valuation_in_usd                     = sanitize_text_field($form_data['valuation_in_usd']);
            $shares_to_be_sold_percentage         = sanitize_text_field($form_data['shares_to_be_sold_percentage']);
            $usd_exchange_rate_used_in_conversion = sanitize_text_field($form_data['usd_exchange_rate_used_in_conversion']);
            $annual_accounting_revenue            = sanitize_text_field($form_data['annual_accounting_revenue']);
            $annual_growth_rate_percentage        = sanitize_text_field($form_data['annual_growth_rate_percentage']);
            $annual_growth_rate                   = sanitize_text_field($form_data['annual_growth_rate']);
            $tech_stack_this_product_is_built_on  = sanitize_text_field($form_data['tech_stack_this_product_is_built_on']);
            $product_competitors                  = sanitize_text_field($form_data['product_competitors']);
            $allowed_tags                         = '<p><h1><h2><h3><h4><h5><h6><a><abbr><b><bdi><br><code><em><i><mark><q><s><samp><small><span><strong><sub><sup><u><var><wbr>';
            $extra_details                        = strip_tags($form_data['extra_details'], $allowed_tags);
            $business_model                       = !is_array($form_data['business_model']) ? [ $form_data['business_model'] ] : $form_data['business_model'];

            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (empty($form_data)) {
                new Nh_Ajax_Response(FALSE, __("Can't create with empty credentials.", 'ninja'));
            }

            if (!wp_verify_nonce($form_data['create_opportunity_nonce'], Nh::_DOMAIN_NAME . "_create_opportunity_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            if (Nh_User::get_user_role() !== Nh_User::OWNER) {
                new Nh_Ajax_Response(FALSE, __("You are not eligible to create opportunities!.", 'ninja'));
            }

            if (empty($project_name)) {
                new Nh_Ajax_Response(FALSE, __("The project name field shouldn't be empty!.", 'ninja'));
            }
            if (empty($sectors)) {
                new Nh_Ajax_Response(FALSE, __("The sectors field shouldn't be empty!.", 'ninja'));
            }
            if (empty($legal_structure)) {
                new Nh_Ajax_Response(FALSE, __("The legal structure field shouldn't be empty!.", 'ninja'));
            }
            if (empty($description)) {
                new Nh_Ajax_Response(FALSE, __("The description field shouldn't be empty!.", 'ninja'));
            }
            if (empty($short_description)) {
                new Nh_Ajax_Response(FALSE, __("The short description field shouldn't be empty!.", 'ninja'));
            }
            if (empty($opportunity_type)) {
                new Nh_Ajax_Response(FALSE, __("The opportunity type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($type_of_company)) {
                new Nh_Ajax_Response(FALSE, __("The type of company type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($required_investment_amount)) {
                new Nh_Ajax_Response(FALSE, __("The required investment amount type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($currency)) {
                new Nh_Ajax_Response(FALSE, __("The currency type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($investment_term)) {
                new Nh_Ajax_Response(FALSE, __("The investment term type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($expected_returns)) {
                new Nh_Ajax_Response(FALSE, __("The expected returns type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($risk_level)) {
                new Nh_Ajax_Response(FALSE, __("The risk level type field shouldn't be empty!.", 'ninja'));
            }
            if (empty($regulatory_compliance)) {
                new Nh_Ajax_Response(FALSE, __("The regulatory compliance type field shouldn't be empty!.", 'ninja'));
            }

            $unique_type_name = get_term_meta($opportunity_type, 'unique_type_name', TRUE);

            if ($unique_type_name === 'bidding') {
                if (empty($start_bidding_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The start bidding amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($target_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The target amount field shouldn't be empty!.", 'ninja'));
                }
            } elseif ($unique_type_name === 'acquisition') {
                if (empty($project_phase)) {
                    new Nh_Ajax_Response(FALSE, __("The project phase field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_start_date)) {
                    new Nh_Ajax_Response(FALSE, __("The project start date field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_assets_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project assets amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_yearly_cashflow_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project yearly cash flow amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_yearly_net_profit_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project yearly new profit amount field shouldn't be empty!.", 'ninja'));
                }
            }


            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_date_founded'] === 1 && empty($date_founded)) {
                new Nh_Ajax_Response(FALSE, __("The date founded field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_asking_price_in_usd'] === 1 && empty($asking_price_in_usd)) {
                new Nh_Ajax_Response(FALSE, __("The asking price in usd field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_number_of_customers'] === 1 && empty($number_of_customers)) {
                new Nh_Ajax_Response(FALSE, __("The number of customers field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_business_team_size'] === 1 && empty($business_team_size)) {
                new Nh_Ajax_Response(FALSE, __("The business team size field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_location'] === 1 && empty($location)) {
                new Nh_Ajax_Response(FALSE, __("The location field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_net_profit'] === 1 && empty($net_profit)) {
                new Nh_Ajax_Response(FALSE, __("The net profit field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_valuation_in_usd'] === 1 && empty($valuation_in_usd)) {
                new Nh_Ajax_Response(FALSE, __("The valuation in usd field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_shares_to_be_sold_percentage'] === 1 && $shares_to_be_sold_percentage != 0 && empty
                ($shares_to_be_sold_percentage)) {
                new Nh_Ajax_Response(FALSE, __("The Shares To Be Sold percentage field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_usd_exchange_rate_used_in_conversion'] === 1 && empty($usd_exchange_rate_used_in_conversion)) {
                new Nh_Ajax_Response(FALSE, __("The usd exchange rate used in conversion field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_accounting_revenue'] === 1 && empty($annual_accounting_revenue)) {
                new Nh_Ajax_Response(FALSE, __("The annual accounting revenue field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate_percentage'] === 1 && $annual_growth_rate_percentage != 0 && empty
                ($annual_growth_rate_percentage)) {
                new Nh_Ajax_Response(FALSE, __("The annual growth rate percentage field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate'] === 1 && empty($annual_growth_rate)) {
                new Nh_Ajax_Response(FALSE, __("The annual growth rate field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_tech_stack_this_product_is_built_on'] === 1 && empty($tech_stack_this_product_is_built_on)) {
                new Nh_Ajax_Response(FALSE, __("The tech stack this product is built on field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_product_competitors'] === 1 && empty($product_competitors)) {
                new Nh_Ajax_Response(FALSE, __("The product competitors field shouldn't be empty!.", 'ninja'));
            }

            if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_extra_details'] === 1 && empty($extra_details)) {
                new Nh_Ajax_Response(FALSE, __("The extra details field shouldn't be empty!.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_create_opportunity');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }

            if (!$this->can_create_opportunity()) {
                new Nh_Ajax_Response(FALSE, sprintf(__("Sorry you can create only one opportunity in month please try again on %s.", 'ninja'), $this->next_opportunity_date()));
            }

            $this->title           = $project_name;
            $this->content         = $description;
            $this->author          = $user_ID;
            $this->thumbnail       = $attachment_id;
            $this->taxonomy        = [
                'opportunity-type' => [ $opportunity_type ],
                'sectors'          => [ $sectors ],
                'legal-structure'  => [ $legal_structure ],
                'business-model'   => array_map(function($ID) {
                    return (int)$ID;
                }, $business_model)
            ];
            $opportunity_type_slug = get_term_meta($opportunity_type, 'unique_type_name', TRUE);


            $groups = [
                //Basic Info
                'type_of_company_group_type_of_company' => $type_of_company,
                'type_of_company_group_appearance'      => '1',

                'date_founded_group_date_founded' => $date_founded,
                'date_founded_group_appearance'   => '1',

                'asking_price_in_usd_group_asking_price_in_usd' => $asking_price_in_usd,
                'asking_price_in_usd_group_appearance'          => '1',

                'number_of_customers_group_number_of_customers' => $number_of_customers,
                'number_of_customers_group_appearance'          => '1',

                'business_team_size_group_business_team_size' => $business_team_size,
                'business_team_size_group_appearance'         => '1',

                'location_group_location'     => $location,
                'location_group_appearance'   => '1',


                // Financial Info
                'net_profit_group_net_profit' => $net_profit,
                'net_profit_group_appearance' => '1',

                'valuation_in_usd_group_valuation_in_usd' => $valuation_in_usd,
                'valuation_in_usd_group_appearance'       => '1',

                'shares_to_be_sold_percentage_group_shares_to_be_sold_percentage' => $shares_to_be_sold_percentage,
                'shares_to_be_sold_percentage_group_appearance'                   => '1',

                'usd_exchange_rate_used_in_conversion_group_usd_exchange_rate_used_in_conversion' => $usd_exchange_rate_used_in_conversion,
                'usd_exchange_rate_used_in_conversion_group_appearance'                           => '1',

                'annual_accounting_revenue_group_annual_accounting_revenue' => $annual_accounting_revenue,
                'annual_accounting_revenue_group_appearance'                => '1',

                'annual_growth_rate_percentage_group_annual_growth_rate_percentage' => $annual_growth_rate_percentage,
                'annual_growth_rate_percentage_group_appearance'                    => '1',

                'annual_growth_rate_group_annual_growth_rate' => $annual_growth_rate,
                'annual_growth_rate_group_appearance'         => '1',

                'required_investment_amount_group_required_investment_amount' => $required_investment_amount,
                'required_investment_amount_group_appearance'                 => '1',

                'currency_group_currency'   => $currency,
                'currency_group_appearance' => '1',

                'investment_term_group_investment_term' => $investment_term,
                'investment_term_group_appearance'      => '1',

                'expected_returns_group_expected_returns' => $expected_returns,
                'expected_returns_group_appearance'       => '1',

                'risk_level_group_risk_level' => $risk_level,
                'risk_level_group_appearance' => '1',

                'regulatory_compliance_group_regulatory_compliance'                             => $regulatory_compliance,
                'regulatory_compliance_group_appearance'                                        => '1',


                // Business Information
                'tech_stack_this_product_is_built_on_group_tech_stack_this_product_is_built_on' => $tech_stack_this_product_is_built_on,
                'tech_stack_this_product_is_built_on_group_appearance'                          => '1',

                'product_competitors_group_product_competitors' => $product_competitors,
                'product_competitors_group_appearance'          => '1',

                'extra_details_group_extra_details' => $extra_details,
                'extra_details_group_appearance'    => '1',


                'short_description'                => $short_description,
                'opportunity_type'                 => $opportunity_type_slug,
                'start_bidding_amount'             => $start_bidding_amount,
                'target_amount'                    => $target_amount,
                'project_phase'                    => $project_phase,
                'project_start_date'               => $project_start_date,
                'project_assets_amount'            => $project_assets_amount,
                'project_yearly_cashflow_amount'   => $project_yearly_cashflow_amount,
                'project_yearly_net_profit_amount' => $project_yearly_net_profit_amount,
                'opportunity_stage'                => 'new',
                'opportunity_stage_old'            => 'new',
            ];

            foreach ($groups as $key => $value) {
                $this->set_meta_data($key, $value);
            }

            $opportunity       = $this->insert();
            $opportunity_id    = $opportunity->ID;
            $opportunity_title = $opportunity->title;

            // DRAFT FOR CLIENT
            $this->title           = $opportunity->title . ' - [CLIENT VERSION]';
            $this->parent          = $opportunity->ID;
            $this->ID              = 0;
            $this->status          = 'draft';
            $opportunity_client    = $this->insert();
            $opportunity_client_id = $opportunity_client->ID;

            if (is_wp_error($opportunity)) {
                new Nh_Ajax_Response(FALSE, $opportunity->get_error_message());
            }

            $form_template = get_term_meta($sectors, 'form_template', TRUE);

            if (!empty($form_template)) {
                $field_group = self::get_field_groups_by_post_id($form_template);
                if (!empty($field_group)) {
                    $field_group[0]['opp_id']        = $opportunity_id;
                    $field_group[0]['opp_client_id'] = $opportunity_client_id;

                    if (!session_id()) {
                        session_start();
                    }

                    $_SESSION['step_two'] = [
                        'status' => TRUE,
                        'ID'     => $opportunity->ID
                    ];

                    $notifications = new Nh_Notification();
                    $notifications->send(0, 0, 'opportunity_new', [
                        'opportunity_id' => $opportunity_id,
                        'opportunity'    => $opportunity_title
                    ]);

                    new Nh_Ajax_Response(TRUE, __('Opportunity has been added successfully', 'ninja'), [
                        'redirect_url' => add_query_arg([ 'q' => Nh_Cryptor::Encrypt(serialize($field_group[0])) ], apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity/create-opportunity-step-2'))))
                    ]);
                }
            }

            $notifications = new Nh_Notification();
            $notifications->send(0, 0, 'opportunity_new', [
                'opportunity_id' => $opportunity_id,
                'opportunity'    => $opportunity_title
            ]);

            new Nh_Ajax_Response(TRUE, __('Opportunity has been added successfully', 'ninja'), [
                'redirect_url' => apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities')))
            ]);
        }

        public function filter_opportunity(): void
        {
            global $user_ID;

            $form_data          = $_POST['data'];
            $opportunity_type   = (int)sanitize_text_field($form_data['opportunity_type']);
            $opportunity_status = sanitize_text_field($form_data['opportunity_status']);

            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (empty($form_data)) {
                new Nh_Ajax_Response(FALSE, __("Can't create with empty credentials.", 'ninja'));
            }

            if (!wp_verify_nonce($form_data['filter_opportunity_nonce'], Nh::_DOMAIN_NAME . "_filter_opportunity_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }
            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_create_opportunity');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }
            $args = [
                'post_type'   => $this->module,
                'post_status' => 'publish',
                'orderby'     => 'ID',
                'order'       => 'DESC',
                'author'      => $user_ID,
                'tax_query'   => [
                    'relation' => 'AND',
                ]
            ];
            if ($opportunity_status) {
                $args['meta_key']   = 'opportunity_stage';
                $args['meta_value'] = $opportunity_status;
            }
            if ($opportunity_type) {
                $args['tax_query'][] = [
                    'taxonomy' => 'opportunity-type',
                    'terms'    => $opportunity_type,
                    'field'    => 'term_id',
                ];
            }
            $opportunities = new \WP_Query($args);
            ob_start();
            if (!empty($opportunities->get_posts())) {
                foreach ($opportunities->get_posts() as $opportunity_post) {
                    $opportunity = $this->convert($opportunity_post, $this->meta_data);
                    echo '<div class="col">';
                    get_template_part('app/Views/template-parts/cards/my-opportunities-card', NULL, [
                        'opportunity_title'             => $opportunity->title,
                        'opportunity_link'              => $opportunity->link,
                        'opportunity_modified'          => $opportunity->modified,
                        'opportunity_created_date'      => $opportunity->created_date,
                        'opportunity_short_description' => $opportunity->meta_data['short_description'],
                        'opportunity_stage'             => $opportunity->meta_data['opportunity_stage'],
                    ]);
                    echo '</div>';
                }
            } else {
                get_template_part('app/Views/template-parts/cards/my-opportunities-empty', NULL, []);
            }
            $html = ob_get_clean();
            new Nh_Ajax_Response(TRUE, __('Opportunities filtered successfully', 'ninja'), [
                'html' => $html,
            ]);
        }

        public function acf_form_head(): void
        {
            if (is_page('create-opportunity-step-2')) {
                acf_form_head();
            }
        }

        public function after_acf_form_submission($post_id): void
        {

            if (is_page('create-opportunity-step-2') && isset($_GET['q']) && !empty(unserialize(Nh_Cryptor::Decrypt($_GET['q'])))) {
                $data = unserialize(Nh_Cryptor::Decrypt($_GET['q']));
                if ($post_id === $data['opp_id']) {
                    if (!session_id()) {
                        session_start();
                    }

                    remove_action('acf/save_post', [
                        $this,
                        'after_acf_form_submission'
                    ], 20);
                    $_POST['_acf_post_id'] = $data['opp_client_id']; // Temporarily set post_id to the current post in the loop
                    acf_save_post($data['opp_client_id']); // Save the ACF data for this post
                    add_action('acf/save_post', [
                        $this,
                        'after_acf_form_submission'
                    ], 20);


                    $_SESSION['step_two'] = [];
                    wp_safe_redirect(apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))));
                    exit();
                }
            }
        }

        public static function get_field_groups_by_post_id($post_id): array
        {
            $matched_groups = [];

            // Get all the field groups
            $field_groups = acf_get_field_groups();

            foreach ($field_groups as $field_group) {

                if (isset($field_group['location']) && is_array($field_group['location'])) {

                    foreach ($field_group['location'] as $group_locations) {
                        foreach ($group_locations as $rule) {

                            if ( // Check if field group is assigned to the specific post ID
                            ($rule['param'] === 'post' && $rule['operator'] === '==' && intval($rule['value']) === (int)$post_id)) {
                                $matched_groups[] = [
                                    'ID'  => $field_group['ID'],
                                    'key' => $field_group['key']
                                ]; // Store the field group key
                                break 2; // exit both foreach loops if match found
                            }

                        }
                    }
                }
            }

            return $matched_groups;
        }

        /**
         * Description...
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return array
         */
        public function get_all_custom(array $status = [ 'any' ], int $limit = 10, string $orderby = 'ID', string $order = 'DESC', array $not_in = [ '0' ], array $tax_query = [], int $user_id = 0, int $page = 1, array $in = [], array $search_fields = [], string $fields = ''): array
        {
            if ($user_id) {
                $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                // $fav_opportunities = $profile->meta_data['favorite_opportunities'];
                if (!is_wp_error($profile)) {
                    $not_in = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : []; // for ignored opportunities
                }
            }

            $args = [
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                'paged'          => $page,
                "orderby"        => $orderby,
                "post__not_in"   => $not_in,
                "order"          => $order,
                "tax_query"      => [
                    'relation' => 'AND',
                ],
                "meta_query"     => [
                    'relation' => 'AND',
                    [
                        'key'     => 'opportunity_stage',
                        'value'   => [
                            'publish',
                            'closed'
                        ],
                        'compare' => 'IN',
                    ]
                ]
            ];
            if (!empty($search_fields)) {

                if (isset($search_fields['sectors']) && $search_fields['sectors']) {
                    $args['tax_query'][] = [
                        'taxonomy' => 'sectors',
                        'terms'    => $search_fields['sectors'],
                        'field'    => 'slug',
                    ];
                }
                unset($search_fields['sectors']);
                if (isset($search_fields['search']) && !empty($search_fields['search'])) {
                    $args['s'] = $search_fields['search'];
                }
                unset($search_fields['search']);
                foreach ($search_fields as $key => $value) {
                    if (!empty($value)) {
                        if (is_numeric($value)) {
                            $args['meta_query'][] = [
                                'key'     => $key,
                                'value'   => $value,
                                'compare' => '<='
                            ];
                        } else {
                            $args['meta_query'][] = [
                                'key'   => $key,
                                'value' => $value,
                            ];
                        }
                    }

                }
            }
            if (!empty($tax_query)) {
                $args['tax_query'][] = $tax_query;
            }
            if (!empty($in)) {
                $args['post__in'] = $in;
            }
            // if ( ! empty( $fields ) ) {
            // 	$args['fields'] = $fields;
            // }
            $posts    = new \WP_Query($args);
            $Nh_Posts = [];

            if ($posts->get_posts()) {
                foreach ($posts->get_posts() as $post) {
                    $Nh_Posts['posts'][] = $this->convert($post, $this->meta_data);
                }
            } else {
                $Nh_Posts['posts'] = [];
            }
            $Nh_Posts['pagination'] = $this->get_pagination($args);
            return $Nh_Posts;
        }

        public function get_pagination(array $args): array|string|null
        {
            $all_posts                   = $args;
            $all_posts['posts_per_page'] = -1;
            $all_posts['fields']         = 'ids';
            $all_posts                   = new \WP_Query($all_posts);
            $count                       = $all_posts->found_posts;
            $big                         = 999999999;
            $pagination                  = paginate_links([
                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'    => '?paged=%#%',
                'current'   => max(1, get_query_var('paged')),
                'total'     => ceil($count / $args['posts_per_page']),
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
            ]);

            return $pagination;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function upload_attachment(): void
        {
            $file = $_FILES;

            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                new Nh_Ajax_Response(FALSE, __('The reCaptcha verification failed. Please try again.', 'ninja')); /* the reCAPTCHA answer  */
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'submit_application');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }

            if (!empty($file)) {

                $upload     = wp_upload_bits($file['file']['name'], NULL, file_get_contents($file['file']['tmp_name']));
                $maxsize    = 5242880;
                $acceptable = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ];

                if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
                    new Nh_Ajax_Response(FALSE, __("File too large. File must be less than 2 megabytes.", 'ninja'));
                }

                if ((!in_array($_FILES['file']['type'], $acceptable)) && (!empty($_FILES["file"]["type"]))) {
                    new Nh_Ajax_Response(FALSE, __("Invalid file type. Only JPG, JPEG and PNG types are accepted.", 'ninja'));
                }

                if (!empty($upload['error'])) {
                    new Nh_Ajax_Response(FALSE, __($upload['error'], 'ninja'));
                }

                $wp_filetype = wp_check_filetype(basename($upload['file']), NULL);

                $wp_upload_dir = wp_upload_dir();

                $attachment = [
                    'guid'           => $wp_upload_dir['baseurl'] . _wp_relative_upload_path($upload['file']),
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];

                $attach_id = wp_insert_attachment($attachment, $upload['file']);

                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);

                wp_update_attachment_metadata($attach_id, $attach_data);

                wp_upload_bits($file['file']["name"], NULL, file_get_contents($file['file']["tmp_name"]));

                new Nh_Ajax_Response(TRUE, __('Attachment has been uploaded successfully.', 'ninja'), [
                    'attachment_ID' => Nh_Cryptor::Encrypt($attach_id)
                ]);
            } else {
                new Nh_Ajax_Response(FALSE, __("Can't upload empty file", 'ninja'));
            }
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function remove_attachment(): void
        {
            $attachment_id = Nh_Cryptor::Decrypt(sanitize_text_field($_POST['attachment_id']));

            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                new Nh_Ajax_Response(FALSE, __('The reCaptcha verification failed. Please try again.', 'ninja')); /* the reCAPTCHA answer  */
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'submit_application');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }

            $deleted = wp_delete_attachment($attachment_id);

            if (!$deleted) {
                new Nh_Ajax_Response(FALSE, __("Can't remove attachment", 'ninja'));
            } else {
                new Nh_Ajax_Response(TRUE, __("Attachment has been removed successfully", 'ninja'));
            }
        }

        /**
         * Description...toggle fav opportunity and save it to user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         */
        public function toggle_opportunity_favorite(): void
        {
            global $user_ID;

            $form_data                     = $_POST['data'];
            $opp_id                        = (int)sanitize_text_field($form_data['opp_id']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;
            $opportunity                   = $this->get_by_id($opp_id);
            if (!wp_verify_nonce($form_data['add_to_fav_nonce_nonce'], Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_add_to_fav');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }
            $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $favorites   = [];
            if (!is_wp_error($profile)) {
                $favorites = ($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
                if (in_array($opp_id, $favorites)) {
                    $key = array_search($opp_id, $favorites);
                    if ($key !== FALSE) {
                        unset($favorites[$key]);
                    }
                    $profile->set_meta_data('favorite_opportunities', $favorites);
                    $profile->update();
                    $fav_count = get_post_meta($opp_id, 'fav_count', TRUE);
                    update_post_meta($opp_id, 'fav_count', (int)$fav_count - 1);
                    new Nh_Ajax_Response(TRUE, sprintf(__('<strong>%s</strong> has been removed from favorites', 'ninja'), $opportunity->title), [
                        'fav_active'   => 1,
                        'updated_text' => __('Add to favorite', 'ninja'),
                        'button_text'  => __('Done', 'ninja')
                    ]);
                } else {
                    $favorites[] = $opp_id;
                    $profile->set_meta_data('favorite_opportunities', $favorites);
                    $profile->update();
                    $fav_count = get_post_meta($opp_id, 'fav_count', TRUE);
                    update_post_meta($opp_id, 'fav_count', (int)$fav_count + 1);
                    new Nh_Ajax_Response(TRUE, sprintf(__('<strong>%s</strong> has been added favorites', 'ninja'), $opportunity->title), [
                        'fav_active'   => 0,
                        'updated_text' => __('Added to favorites', 'ninja'),
                        'button_text'  => __('Done', 'ninja')
                    ]);
                }
            } else {
                new Nh_Ajax_Response(FALSE, __('Something went wrong!', 'ninja'), [
                    'status'     => FALSE,
                    'msg'        => 'Invalid profile ID',
                    'fav_active' => 1
                ]);
            }
        }

        /**
         * Description...Check if post exists in user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         *
         * @param post_id
         *
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_opportunity_in_user_favorites($opp_id): bool
        {
            global $user_ID;

            $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $favorites   = [];
            if (!is_wp_error($profile)) {
                $favorites = is_array($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
                $favorites = array_combine($favorites, $favorites);
            }
            return isset($favorites[$opp_id]);
        }

        /**
         * Description...ignore oppertunitie and save it to user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function ignore_opportunity(): void
        {
            global $user_ID, $wp;
            $form_data                     = $_POST['data'];
            $opp_id                        = (int)sanitize_text_field($form_data['opp_id']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;
            $opportunity                   = $this->get_by_id($opp_id);

            if (!wp_verify_nonce($form_data['ignore_opportunity_nonce'], Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_ignore');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja')); /* the reCAPTCHA answer  */
            }
            $profile_id            = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj           = new Nh_Profile();
            $profile               = $profile_obj->get_by_id((int)$profile_id);
            $ignored_opportunities = [];
            if (!is_wp_error($profile)) {
                $ignored_opportunities = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
                $ignored_opportunities = array_combine($ignored_opportunities, $ignored_opportunities);
                if (isset($ignored_opportunities[$opp_id])) {
                    unset($ignored_opportunities[$opp_id]);
                    $ignored_opportunities = array_values($ignored_opportunities);
                    $profile->set_meta_data('ignored_opportunities', $ignored_opportunities);
                    $profile->update();
                    $ignore_count = get_post_meta($opp_id, 'ignore_count', TRUE);
                    update_post_meta($opp_id, 'ignore_count', (int)$ignore_count + 1);
                    new Nh_Ajax_Response(TRUE, sprintf(__('<strong>%s</strong> has been un-ignored', 'ninja'), $opportunity->title), [
                        'ignore_active' => 1,
                        'updated_text'  => __('Ignore', 'ninja'),
                        'button_text'   => __('Done', 'ninja')
                    ]);
                } else {
                    $ignored_opportunities[] = $opp_id;
                    $profile->set_meta_data('ignored_opportunities', $ignored_opportunities);
                    $profile->update();
                    $ignore_count = get_post_meta($opp_id, 'ignore_count', TRUE);
                    update_post_meta($opp_id, 'ignore_count', (int)$ignore_count - 1);
                    new Nh_Ajax_Response(TRUE, sprintf(__('<strong>%s</strong> has been ignored', 'ninja'), $opportunity->title), [
                        'ignore_active' => 1,
                        'updated_text'  => __('Un-ignore', 'ninja'),
                        'button_text'   => __('Done', 'ninja')
                    ]);
                }
            } else {
                new Nh_Ajax_Response(FALSE, __('Error Response!', 'ninja'), [
                    'status'        => FALSE,
                    'msg'           => 'You must have profile',
                    'ignore_active' => 1,

                ]);
            }
        }

        /**
         * Description...Check if post exists in user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_opportunity_in_user_ignored($opp_id): bool
        {
            global $user_ID;

            $profile_id            = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj           = new Nh_Profile();
            $profile               = $profile_obj->get_by_id((int)$profile_id);
            $ignored_opportunities = [];
            if (!is_wp_error($profile)) {
                $ignored_opportunities = is_array($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
                $ignored_opportunities = array_combine($ignored_opportunities, $ignored_opportunities);
            }
            return isset($ignored_opportunities[$opp_id]);
        }


        public function filter_opportunities_stage($opportunity, $stage = []): array
        {
            $opportunities = [];

            if (property_exists($opportunity, 'meta_data')) {
                if (in_array($stage, $opportunity->meta_data['opportunity_stage'])) {
                    $opportunities[] = $opportunity;
                }
            } else {
                $opportunities = $opportunity;
            }

            return $opportunities;
        }

        /**
         * Get dashboard opportunities to be displayed in the sidebar
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function get_dashboard_sidebar_opportunities(): array
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'      => $this->module,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'DESC',
                'author'         => $user_ID,
                'posts_per_page' => 6
            ]);

            $Nh_opportunities = [];

            foreach ($opportunities->get_posts() as $opportunity) {
                $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
            }

            return $Nh_opportunities;
        }

        public function get_opportunities()
        {

        }

        public function get_profile_opportunities(): array
        {
            global $user_ID;

            if ($user_ID) {
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                // $fav_opportunities = $profile->meta_data['favorite_opportunities'];
                if (!is_wp_error($profile)) {
                    $not_in = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : []; // for ignored opportunities
                }
            }
            $opportunities = new \WP_Query([
                'post_type'    => $this->module,
                'post_status'  => 'publish',
                'orderby'      => 'ID',
                'order'        => 'DESC',
                "post__not_in" => $not_in,
                'author'       => $user_ID
            ]);

            $Nh_opportunities = [];

            foreach ($opportunities->get_posts() as $opportunity) {
                $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
            }

            return $Nh_opportunities;
        }

        public function get_profile_fav_opportunities(): array
        {
            global $user_ID;

            $profile_id       = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj      = new Nh_Profile();
            $profile          = $profile_obj->get_by_id((int)$profile_id);
            $Nh_opportunities = [];

            if (!is_wp_error($profile)) {
                $fav_ids = is_array($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];

                if (!empty($fav_ids)) {
                    $opportunities = new \WP_Query([
                        'post_type'   => $this->module,
                        'post_status' => 'publish',
                        'orderby'     => 'ID',
                        'order'       => 'DESC',
                        "post__in"    => $profile->meta_data['favorite_opportunities'],
                    ]);
                    foreach ($opportunities->get_posts() as $opportunity) {
                        $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
                    }
                }
            }

            return $Nh_opportunities;
        }

        public function get_profile_ignored_opportunities(): array
        {
            global $user_ID;

            $profile_id       = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj      = new Nh_Profile();
            $profile          = $profile_obj->get_by_id((int)$profile_id);
            $Nh_opportunities = [];

            if (!is_wp_error($profile)) {
                $ignored_ids = is_array($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];

                if (!empty($ignored_ids)) {
                    $opportunities = new \WP_Query([
                        'post_type'   => $this->module,
                        'post_status' => 'publish',
                        'orderby'     => 'ID',
                        'order'       => 'DESC',
                        "post__in"    => $profile->meta_data['ignored_opportunities'],
                    ]);
                    foreach ($opportunities->get_posts() as $opportunity) {
                        $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
                    }
                }
            }

            return $Nh_opportunities;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return bool
         * @throws \Exception
         */
        public function can_create_opportunity(): bool
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'      => $this->module,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'DESC',
                'author'         => $user_ID,
                'posts_per_page' => 1
            ]);

            if ($opportunities->have_posts()) {
                $now  = new \DateTime();
                $date = new \DateTime($opportunities->post->post_date);

                // Add one month to the current date
                $oneMonthLater = clone $date;
                $oneMonthLater->add(new \DateInterval('P1M'));

                // Check if the input date is more than one month from today
                if ($now > $oneMonthLater) {
                    return TRUE;
                }

                return FALSE;
            } else {
                return TRUE;
            }

        }

        public function next_opportunity_date(): string
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'      => $this->module,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'DESC',
                'author'         => $user_ID,
                'posts_per_page' => 1
            ]);

            $now  = new \DateTime();
            $date = new \DateTime($opportunities->post->post_date);

            // Add one month to the current date
            $oneMonthLater = clone $date;
            $oneMonthLater->add(new \DateInterval('P1M'));

            return $oneMonthLater->format('F j, Y - h:i A');


        }

        public function get_opportunity_bids(int $opp_id = 0, $count = FALSE): int|array
        {
            $id                      = $opp_id ? $opp_id : $this->ID;
            $nh_opportunity_bids_obj = new Nh_Opportunity_Bid();
            $nh_opportunity_bids     = [];

            $bids = new \WP_Query([
                'post_type'   => $nh_opportunity_bids_obj->module,
                'post_status' => 'publish',
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => $id,
                        'compare' => 'LIKE',
                    ],
                ],
            ]);

            if ($count) {
                return $bids->found_posts;
            }

            if ($bids->have_posts()) {
                foreach ($bids->posts as $single) {
                    $nh_opportunity_bids[] = $nh_opportunity_bids_obj->convert($single);
                }
            }

            return $nh_opportunity_bids;

        }

        public function get_opportunity_acquisitions(int $opp_id = 0, $count = FALSE): int|array
        {
            $id                              = $opp_id ? $opp_id : $this->ID;
            $nh_opportunity_acquisitions_obj = new Nh_Opportunity_Acquisition();
            $nh_opportunity_acquisitions     = [];

            $acquisitions = new \WP_Query([
                'post_type'   => $nh_opportunity_acquisitions_obj->module,
                'post_status' => 'publish',
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => $id,
                        'compare' => 'LIKE',
                    ],
                ],
            ]);

            if ($count) {
                return $acquisitions->found_posts;
            }

            if ($acquisitions->have_posts()) {
                foreach ($acquisitions->posts as $single) {
                    $nh_opportunity_acquisitions[] = $nh_opportunity_acquisitions_obj->convert($single);
                }
            }

            return $nh_opportunity_acquisitions;

        }

        public function get_opportunity_investments(int $opp_id = 0, $count = FALSE): int|array
        {
            $id                             = $opp_id ? $opp_id : $this->ID;
            $nh_opportunity_investments_obj = new Nh_Opportunity_Investments();
            $nh_opportunity_investments     = [];

            $investments = new \WP_Query([
                'post_type'   => $nh_opportunity_investments_obj->module,
                'post_status' => 'publish',
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => $id,
                        'compare' => 'LIKE',
                    ],
                ],
            ]);

            if ($count) {
                return $investments->found_posts;
            }

            if ($investments->have_posts()) {
                foreach ($investments->posts as $single) {
                    $nh_opportunity_investments[] = $nh_opportunity_investments_obj->convert($single);
                }
            }

            return $nh_opportunity_investments;

        }
    }
