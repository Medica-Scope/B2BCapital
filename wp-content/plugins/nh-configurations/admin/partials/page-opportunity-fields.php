<?php
    /**
     * @Filename: page-opportunity-fields.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/18/2022
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\Nh;

?>
<main>
    <div class="nh-admin-page">
        <div class="container-fluid">

            <header class="nh-admin-page-header">
                <h5><img src="<?= PLUGIN_URL . 'admin/img/icon.png' ?>" class="rounded me-2" alt="<?= __('NH Logo', 'ninja') ?>">NH Configuration</h5>
            </header>

            <section class="nh-notices mt-4"></section>

            <div class="page-content">

                <header class="nh-admin-page-header">
                    <h4><?= __('Edit opportunity fields settings', 'ninja') ?></h4>
                </header>

                <?php include_once PLUGIN_PATH . 'admin/partials/header.php'; ?>

                <div class="tab-content">
                    <div class="tab-pane nh-admin-page-body active">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <?= __('Find Us', 'ninja'); ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <?= Nh_Forms::get_instance()
                                                    ->create_form([
                                                        'fields_appearance'   => [
                                                            'type'        => 'checkbox',
                                                            'class'       => 'row mb-4',
                                                            'input_class' => '',
                                                            'label_class' => '',
                                                            'choices'     => [
                                                                [
                                                                    'label'      => 'date founded',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_date_founded',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_date_founded'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Type of Company',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_type_of_company',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_type_of_company'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'asking price in usd',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_asking_price_in_usd',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_asking_price_in_usd'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'number of customers',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_number_of_customers',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_number_of_customers'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'business team size',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_business_team_size',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_business_team_size'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'location',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_location',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_location'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'net profit',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_net_profit',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_net_profit'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'valuation in usd',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_valuation_in_usd',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_valuation_in_usd'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Shares To Be Sold percentage',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_shares_to_be_sold_percentage',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_shares_to_be_sold_percentage'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'usd exchange rate used in conversion',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_usd_exchange_rate_used_in_conversion',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_usd_exchange_rate_used_in_conversion'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'annual accounting revenue',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_annual_accounting_revenue',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_accounting_revenue'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'annual growth rate percentage',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_annual_growth_rate_percentage',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate_percentage'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'annual growth rate',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_annual_growth_rate',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_annual_growth_rate'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Legal Structure',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_legal_structure',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_legal_structure'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Required Investment Amount',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_required_investment_amount',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_required_investment_amount'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Currency',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_currency',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_currency'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Investment Term',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_investment_term',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_investment_term'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Expected Returns',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_expected_returns',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_expected_returns'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Risk Level',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_risk_level',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_risk_level'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'Regulatory Compliance',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_regulatory_compliance',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_regulatory_compliance'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'tech stack this product is built on',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_tech_stack_this_product_is_built_on',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_tech_stack_this_product_is_built_on'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'product competitors',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_product_competitors',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_product_competitors'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                                [
                                                                    'label'      => 'extra details',
                                                                    'required'   => '',
                                                                    'class'      => '',
                                                                    'id'         => '',
                                                                    'name'       => Nh::_DOMAIN_NAME . '_extra_details',
                                                                    'value'      => 1,
                                                                    'before'     => '',
                                                                    'after'      => '',
                                                                    'checked'    => (int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_extra_details'] === 1 ? 'checked' : '',
                                                                    'order'      => 0,
                                                                    'extra_attr' => []
                                                                ],
                                                            ],
                                                            'before'      => '
                                                            <div class="col-sm-2 ">
                                                                <label for="ninja_ninja_contact_address_en" class="ninja-label">
                                                                    ' . __('Fields Appearance', 'ninja') . '
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-10 ">
                                                            ',
                                                            'after'       => '</div>',
                                                            'order'       => 0,
                                                        ],
                                                        'submit' => [
                                                            'class'  => 'col-lg-2 col-md-2 offset-lg-10 offset-md-10 mb-2',
                                                            'type'   => 'submit',
                                                            'value'  => __('Save', 'ninja'),
                                                            'before' => '',
                                                            'after'  => '',
                                                            'order'  => 20,
                                                        ]
                                                    ], [
                                                        'attr'       => 'novalidate',
                                                        'class'      => Nh::_DOMAIN_NAME . '-opportunities-form',
                                                        'form_class' => 'needs-validation',
                                                        'id'         => Nh::_DOMAIN_NAME . '_opportunities_form'
                                                    ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
