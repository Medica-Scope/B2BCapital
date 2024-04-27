<?php
    /**
     * @Filename: template-page-create-opportunity.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Create Opportunity Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');
?>

    <main class="create-opportunity">
        <div class="container container-xxl">
            <?php Nh_Public::breadcrumbs(); ?>

            <nav class="dashboard-submenus mt-3 mb-5">
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'create_new_opportunity' ]); ?>
            </nav>

            <div class="row d-flex flex-column justify-content-center align-items-center">
                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="text-primary Opportunity-title">
                        <?= __('Create New Opportunity ', 'ninja'); ?>
                    </h3>
                    <p class="text-wrap text-center">Long established fact that a reader will be <br> distracted by the readable
                                                     content
                    </p>
                </div>
            </div>
            <?php
                $form_fields = [

                    // Start Of General Information
                    'custom-html-1'               => [
                        'type'    => 'html',
                        'content' => '<div class="row"> <h3>' . __('General Information', 'ninja') . '</h3> <small>' . __('*All fields are required.', 'ninja') . '</small>',
                        'order'   => 0,
                    ],
                    'project_name'                => [
                        'class'       => 'col-6',
                        'type'        => 'text',
                        'label'       => __('Opportunity Name', 'ninja'),
                        'name'        => 'project_name',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project name', 'ninja'),
                        'order'       => 5,
                    ],
                    'sectors'               => [
                        'class'             => 'col-sm-6',
                        'type'              => 'select',
                        'label'             => __('Sectors', 'ninja'),
                        'name'              => 'sectors',
                        'placeholder'       => __('Enter your sectors', 'ninja'),
                        'options'           => [],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 10,
                    ],
                    'description'                 => [
                        'class'       => 'col-6',
                        'type'        => 'textarea',
                        'label'       => __('Description', 'ninja'),
                        'name'        => 'description',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project description', 'ninja'),
                        'rows'        => '4',
                        'order'       => 15,
                    ],
                    'short_description'           => [
                        'class'       => 'col-6',
                        'type'        => 'textarea',
                        'label'       => __('Short Description', 'ninja'),
                        'name'        => 'short_description',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project short description', 'ninja'),
                        'rows'        => '4',
                        'order'       => 20,
                    ],
                    'industry'                    => [
                        'class'             => 'col-6',
                        'type'              => 'select',
                        'label'             => __('Industry', 'ninja'),
                        'name'              => 'industry',
                        'placeholder'       => __('Enter your industry', 'ninja'),
                        'options'           => [],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 25,
                    ],
                    'type_of_company'             => [
                        'class'             => 'col-sm-6',
                        'type'              => 'select',
                        'label'             => __('Type of Company', 'ninja'),
                        'name'              => 'type_of_company',
                        'placeholder'       => __('Enter your company type', 'ninja'),
                        'options'           => [
                            'joint-stock'        => __('Joint stock', 'ninja'),
                            'limited-liability'  => __('Limited Liability', 'ninja'),
                            'one-person-company' => __('One Person Company', 'ninja'),
                            'other'              => __('Other', 'ninja')
                        ],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 30,
                    ],
                    'date_founded'                => [
                        'class'       => 'col-6',
                        'type'        => 'date',
                        'label'       => __('Date Founded', 'ninja'),
                        'name'        => 'date_founded',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your date founded', 'ninja'),
                        'order'       => 35,
                    ],
                    'asking_price_in_usd'         => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Asking Price IN USD', 'ninja'),
                        'name'        => 'asking_price_in_usd',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your asking price in USD', 'ninja'),
                        'order'       => 40,
                    ],
                    'number_of_customers'         => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Number of Customers', 'ninja'),
                        'name'        => 'number_of_customers',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your number of customers', 'ninja'),
                        'order'       => 45,
                    ],
                    'business_team_size'          => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Business Team Size', 'ninja'),
                        'name'        => 'business_team_size',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your business team size', 'ninja'),
                        'order'       => 50,
                    ],
                    'location'                    => [
                        'class'       => 'col-12',
                        'type'        => 'text',
                        'label'       => __('Location', 'ninja'),
                        'name'        => 'location',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your location', 'ninja'),
                        'order'       => 55,
                    ],
                    'media_file'                  => [
                        'class'      => 'form-group col-md-6',
                        'type'       => 'file',
                        'label'      => __('Project Logo', 'ninja'),
                        'name'       => 'media_file',
                        'required'   => FALSE,
                        'accept'     => 'image/*',
                        'before'     => '',
                        'after'      => '',
                        'order'      => 60,
                        'extra_attr' => [
                            'data-target' => "media_file_id"
                        ]
                    ],
                    'media_file_id'               => [
                        'class'    => '',
                        'type'     => 'hidden',
                        'name'     => 'media_file_id',
                        'required' => FALSE,
                        'before'   => '',
                        'after'    => '',
                        'order'    => 65,
                    ],
                    'business_model'              => [
                        'class'             => 'col-sm-12',
                        'type'              => 'select',
                        'label'             => __('Business Model & Pricing', 'ninja'),
                        'name'              => 'business_model',
                        'placeholder'       => __('Enter your business model & pricing', 'ninja'),
                        'multiple'          => 'multiple',
                        'options'           => [],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 70,
                    ],
                    'custom-html-2'               => [
                        'type'    => 'html',
                        'content' => '</div>',
                        'order'   => 75,
                    ],


                    // Start Of Opportunity Types
                    'custom-html-opp-types-start' => [
                        'type'    => 'html',
                        'content' => '<div class="mt-5"> <h3>' . __('Opportunity Types', 'ninja') . '</h3> <small>' . __('*All fields are required.', 'ninja') . '</small>',
                        'order'   => 80,
                    ],
                    'opportunity_type'            => [
                        'class'             => 'col-12',
                        'type'              => 'select',
                        'label'             => __('Type', 'ninja'),
                        'name'              => 'opportunity_type',
                        'placeholder'       => __('Enter your opportunity type', 'ninja'),
                        'options'           => [],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 85,
                    ],

                    'custom-html-bidding-fields-1' => [
                        'type'    => 'html',
                        'content' => '<div id="bidding_target"  class="nh-opportunities-fields col-12 nh-hidden"><div class="row">',
                        'order'   => 90,
                    ],
                    'start_bidding_amount'         => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Start Bidding Amount', 'ninja'),
                        'name'        => 'start_bidding_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your start bidding amount', 'ninja'),
                        'order'       => 95,
                    ],
                    'target_amount'                => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Target Amount', 'ninja'),
                        'name'        => 'target_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your target amount', 'ninja'),
                        'order'       => 100,
                    ],
                    'custom-html-bidding-fields-2' => [
                        'type'    => 'html',
                        'content' => '</div></div>',
                        'order'   => 105,
                    ],

                    'custom-html-acquisition-fields-1'     => [
                        'type'    => 'html',
                        'content' => '<div id="acquisition_target" class="nh-opportunities-fields col-12 nh-hidden"><div class="row">',
                        'order'   => 110,
                    ],
                    'project_phase'                        => [
                        'class'          => 'col-6',
                        'type'           => 'select',
                        'label'          => __('Project Phase', 'ninja'),
                        'name'           => 'project_phase',
                        'placeholder'    => __('Select your project phase', 'ninja'),
                        'options'        => [
                            'preparation' => __('Preparation', 'ninja'),
                            'created'     => __('Created', 'ninja'),
                            'started'     => __('Started', 'ninja'),
                            'running'     => __('Running', 'ninja'),
                            'paused'      => __('Paused', 'ninja'),
                        ],
                        'default_option' => '',
                        'select_option'  => [],
                        'before'         => '',
                        'order'          => 115,
                    ],
                    'project_start_date'                   => [
                        'class'       => 'col-6',
                        'type'        => 'date',
                        'label'       => __('Project Start Date', 'ninja'),
                        'name'        => 'project_start_date',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project start date', 'ninja'),
                        'order'       => 120,
                    ],
                    'project_assets_amount'                => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Project Assets Amount', 'ninja'),
                        'name'        => 'project_assets_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project assets amount', 'ninja'),
                        'order'       => 125,
                    ],
                    'project_yearly_cashflow_amount'       => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Project Yearly Cashflow Amount', 'ninja'),
                        'name'        => 'project_yearly_cashflow_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project yearly cashflow amount', 'ninja'),
                        'order'       => 130,
                    ],
                    'project_yearly_net_profit_amount'     => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Project Yearly Net Profit Amount', 'ninja'),
                        'name'        => 'project_yearly_net_profit_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your project yearly cashflow amount', 'ninja'),
                        'order'       => 135,
                    ],
                    'custom-html-acquisition-fields-2'     => [
                        'type'    => 'html',
                        'content' => '</div></div>',
                        'order'   => 140,
                    ],
                    'custom-html-opp-types-end'            => [
                        'type'    => 'html',
                        'content' => '</div>',
                        'order'   => 145,
                    ],


                    // Start Of Financial Information
                    'custom-html-3'                        => [
                        'type'    => 'html',
                        'content' => '<div class="row mt-5"> <h3>' . __('Financial Information', 'ninja') . '</h3> <small>' . __('*All fields are required.', 'ninja') . '</small>',
                        'order'   => 150,
                    ],
                    'net_profit'                           => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Net Profit', 'ninja'),
                        'name'        => 'net_profit',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your net profit', 'ninja'),
                        'order'       => 155,
                    ],
                    'valuation_in_usd'                     => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Valuation In USD', 'ninja'),
                        'name'        => 'valuation_in_usd',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your valuation in USD', 'ninja'),
                        'order'       => 160,
                    ],
                    'shares_to_be_sold_percentage'          => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Shares To Be Sold %', 'ninja'),
                        'name'        => 'shares_to_be_sold_percentage',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your shares to be sold %', 'ninja'),
                        'order'       => 165,
                    ],
                    'usd_exchange_rate_used_in_conversion' => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('USD Exchange Rate Used In Conversion', 'ninja'),
                        'name'        => 'usd_exchange_rate_used_in_conversion',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your usd exchange rate used in conversion', 'ninja'),
                        'order'       => 170,
                    ],
                    'annual_accounting_revenue'            => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Annual Accounting Revenue', 'ninja'),
                        'name'        => 'annual_accounting_revenue',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your annual accounting revenue', 'ninja'),
                        'order'       => 175,
                    ],
                    'annual_growth_rate_percentage'        => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Annual Growth Rate %', 'ninja'),
                        'name'        => 'annual_growth_rate_percentage',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your annual growth rate %', 'ninja'),
                        'order'       => 180,
                    ],
                    'annual_growth_rate'                   => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Annual Growth Rate', 'ninja'),
                        'name'        => 'annual_growth_rate',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your annual growth rate', 'ninja'),
                        'order'       => 185,
                    ],
                    'required_investment_amount'           => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Required Investment Amount', 'ninja'),
                        'name'        => 'required_investment_amount',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your required investment amount', 'ninja'),
                        'order'       => 190,
                    ],
                    'currency'                             => [
                        'class'       => 'col-6',
                        'type'        => 'text',
                        'label'       => __('Currency', 'ninja'),
                        'name'        => 'currency',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your required investment currency', 'ninja'),
                        'order'       => 195,
                    ],
                    'investment_term'                      => [
                        'class'          => 'col-6',
                        'type'           => 'select',
                        'label'          => __('Investment Term', 'ninja'),
                        'name'           => 'investment_term',
                        'placeholder'    => __('Select your investment term', 'ninja'),
                        'options'        => [
                            'years'  => __('Years', 'ninja'),
                            'months' => __('Months', 'ninja'),
                            'days'   => __('Days', 'ninja'),
                        ],
                        'default_option' => '',
                        'select_option'  => [],
                        'before'         => '',
                        'order'          => 200,
                    ],
                    'expected_returns'                     => [
                        'class'       => 'col-6',
                        'type'        => 'number',
                        'label'       => __('Expected Returns %', 'ninja'),
                        'name'        => 'expected_returns',
                        'value'       => '',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your expected returns %', 'ninja'),
                        'order'       => 205,
                    ],
                    'risk_level'                           => [
                        'class'          => 'col-6',
                        'type'           => 'select',
                        'label'          => __('Risk Level', 'ninja'),
                        'name'           => 'risk_level',
                        'placeholder'    => __('Select your risk level', 'ninja'),
                        'options'        => [
                            'low'    => __('Low', 'ninja'),
                            'medium' => __('Medium', 'ninja'),
                            'high'   => __('High', 'ninja'),
                        ],
                        'default_option' => '',
                        'select_option'  => [],
                        'before'         => '',
                        'order'          => 210,
                    ],
                    'legal_structure'                      => [
                        'class'             => 'col-6',
                        'type'              => 'select',
                        'label'             => __('Legal Structure', 'ninja'),
                        'name'              => 'legal_structure',
                        'placeholder'       => __('Enter your legal structure', 'ninja'),
                        'options'           => [],
                        'default_option'    => '',
                        'select_option'     => [],
                        'extra_option_attr' => [],
                        'before'            => '',
                        'order'             => 215,
                    ],
                    'regulatory_compliance'                => [
                        'class'       => 'col-12',
                        'type'        => 'textarea',
                        'label'       => __('Regulatory Compliance', 'ninja'),
                        'name'        => 'regulatory_compliance',
                        'value'       => '',
                        'required'    => FALSE,
                        'placeholder' => __('Enter your regulatory compliance', 'ninja'),
                        'rows'        => '4',
                        'order'       => 220,
                    ],
                    'custom-html-4'                        => [
                        'type'    => 'html',
                        'content' => '</div>',
                        'order'   => 225,
                    ],


                    // Start Of Business Overview
                    'custom-html-5'                        => [
                        'type'    => 'html',
                        'content' => '<div class="row mt-5"> <h3>' . __('Business Overview', 'ninja') . '</h3>',
                        'order'   => 230,
                    ],
                    'tech_stack_this_product_is_built_on'  => [
                        'class'       => 'col-6',
                        'type'        => 'text',
                        'label'       => __('Tech Stack This Product Is Built On', 'ninja'),
                        'name'        => 'tech_stack_this_product_is_built_on',
                        'value'       => '-',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your tech stack this product is built on', 'ninja'),
                        'order'       => 235,
                    ],
                    'product_competitors'                  => [
                        'class'       => 'col-6',
                        'type'        => 'text',
                        'label'       => __('Product Competitors', 'ninja'),
                        'name'        => 'product_competitors',
                        'value'       => '-',
                        'required'    => TRUE,
                        'placeholder' => __('Enter your product competitors', 'ninja'),
                        'order'       => 240,
                    ],
                    'extra_details'                        => [
                        'class'       => 'col-12',
                        'type'        => 'textarea',
                        'label'       => __('Extra details', 'ninja'),
                        'name'        => 'extra_details',
                        'value'       => '',
                        'required'    => FALSE,
                        'placeholder' => __('Enter your business extra details', 'ninja'),
                        'rows'        => '4',
                        'order'       => 245,
                    ],
                    'custom-html-6'                        => [
                        'type'    => 'html',
                        'content' => '</div>',
                        'order'   => 250,
                    ],

                    'create_opportunity_nonce' => [
                        'class' => '',
                        'type'  => 'nonce',
                        'name'  => 'create_opportunity_nonce',
                        'value' => Nh::_DOMAIN_NAME . "_create_opportunity_form",
                        'order' => 255
                    ],
                    'submit'                   => [
                        'class'               => 'btn-lg text-uppercase',
                        'type'                => 'submit',
                        'id'                  => Nh::_DOMAIN_NAME . '_create_opportunity_submit',
                        'value'               => '<i class="bbc-save pe-1"></i> ' . __('Save', 'ninja'),
                        'before'              => '',
                        'after'               => '',
                        'recaptcha_form_name' => 'frontend_create_opportunity',
                        'order'               => 260
                    ],
                ];
                $form_tags   = [
                    'class' => Nh::_DOMAIN_NAME . '-create-opportunity-form',
                    'id'    => Nh::_DOMAIN_NAME . '_create_opportunity_form'
                ];

                $opportunities_obj            = new Nh_Opportunity();
                $opportunities_industry_terms = $opportunities_obj->get_taxonomy_terms('industry');
                $opportunities_type_terms     = $opportunities_obj->get_taxonomy_terms('opportunity-type');
                $sectors_terms          = $opportunities_obj->get_taxonomy_terms('sectors');
                $business_model_terms         = $opportunities_obj->get_taxonomy_terms('business-model');
                $legal_structure              = $opportunities_obj->get_taxonomy_terms('legal-structure');

                foreach ($opportunities_industry_terms as $key => $term) {
                    $status = get_term_meta($term->term_id, 'status', TRUE);
                    if (intval($status) !== 1) {
                        continue;
                    }
                    $form_fields['industry']['options'][$term->term_id] = $term->name;
                }
                foreach ($opportunities_type_terms as $key => $term) {
                    $status = get_term_meta($term->term_id, 'status', TRUE);
                    if (intval($status) !== 1) {
                        continue;
                    }
                    $form_fields['opportunity_type']['options'][$term->term_id]           = $term->name;
                    $form_fields['opportunity_type']['extra_option_attr'][$term->term_id] = [
                        'data-target' => get_term_meta($term->term_id, 'unique_type_name', TRUE),
                    ];

                    if ($key == 0) {
                        $form_fields['opportunity_type']['default_option'] = $term->term_id;
                    }
                }
                foreach ($sectors_terms as $key => $term) {
                    $status = get_term_meta($term->term_id, 'status', TRUE);
                    if (intval($status) !== 1) {
                        continue;
                    }
                    $form_fields['sectors']['options'][$term->term_id] = $term->name;
                }

                foreach ($business_model_terms as $key => $term) {
                    $status = get_term_meta($term->term_id, 'status', TRUE);
                    if (intval($status) !== 1) {
                        continue;
                    }
                    $form_fields['business_model']['options'][$term->term_id] = $term->name;
                }

                foreach ($legal_structure as $key => $term) {
                    $status = get_term_meta($term->term_id, 'status', TRUE);
                    if (intval($status) !== 1) {
                        continue;
                    }
                    $form_fields['legal_structure']['options'][$term->term_id] = $term->name;
                }

                $configurable_fields = [
                    'date_founded',
                    'type_of_company',
                    'asking_price_in_usd',
                    'number_of_customers',
                    'business_team_size',
                    'location',
                    'net_profit',
                    'valuation_in_usd',
                    'shares_to_be_sold_percentage',
                    'usd_exchange_rate_used_in_conversion',
                    'annual_accounting_revenue',
                    'annual_growth_rate_percentage',
                    'annual_growth_rate',
                    'required_investment_amount',
                    'currency',
                    'investment_term',
                    'expected_returns',
                    'risk_level',
                    'regulatory_compliance',
                    'tech_stack_this_product_is_built_on',
                    'product_competitors',
                    'extra_details'
                ];

                foreach ($configurable_fields as $field) {
                    if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_' . $field] === 0) {
                        $form_fields[$field]['class'] .= ' d-none';
                    }
                }

                echo Nh_Forms::get_instance()
                             ->create_form($form_fields, $form_tags);
            ?>
        </div>
    </main><!-- #main -->

<?php get_footer();
