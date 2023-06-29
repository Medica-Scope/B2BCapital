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
     * @package b2b
     * @since 1.0
     *
     */


    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Opportunity;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="site-home">
        <h1>Create a New Opportunity</h1>

        <?php
            $form_fields = [
                'custom-html-1'      => [
                    'type'    => 'html',
                    'content' => '<div class="row">',
                    'order'   => 0,
                ],
                'project_name'         => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Name', 'b2b'),
                    'name'        => 'project_name',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project name', 'b2b'),
                    'order'       => 5,
                ],
                'category'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Category', 'b2b'),
                    'name'        => 'category',
                    'placeholder' => __('Enter your category', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'opportunity_type'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Opportunity Type', 'b2b'),
                    'name'        => 'category',
                    'placeholder' => __('Enter your opportunity type', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'description'          => [
                    'class'       => 'col-6',
                    'type'        => 'textarea',
                    'label'       => __('Description', 'b2b'),
                    'name'        => 'description',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project description', 'b2b'),
                    'rows'         => '4',
                    'order'       => 10,
                ],
                'short_description'          => [
                    'class'       => 'col-6',
                    'type'        => 'textarea',
                    'label'       => __('Short Description', 'b2b'),
                    'name'        => 'short_description',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project short description', 'b2b'),
                    'rows'         => '4',
                    'order'       => 10,
                ],
                'start_bidding_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Start Bidding Amount', 'b2b'),
                    'name'        => 'start_bidding_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your start bidding amount', 'b2b'),
                    'order'       => 15,
                ],
                'target_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Target Amount', 'b2b'),
                    'name'        => 'target_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your start bidding amount', 'b2b'),
                    'order'       => 15,
                ],
                'project_phase'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Project Phase', 'b2b'),
                    'name'        => 'project_phase',
                    'placeholder' => __('Select your project phase', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [],
                    'before'      => '',
                    'order'       => 25,
                ],
                'project_start_date'       => [
                    'class'       => 'col-6',
                    'type'        => 'date',
                    'label'       => __('Project Start Date', 'b2b'),
                    'name'        => 'project_start_date',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project start date', 'b2b'),
                    'order'       => 15,
                ],
                'project_assets_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Assets Amount', 'b2b'),
                    'name'        => 'project_assets_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project assets amount', 'b2b'),
                    'order'       => 15,
                ],
                'project_yearly_cashflow_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Yearly Cashflow Amount', 'b2b'),
                    'name'        => 'project_yearly_cashflow_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project yearly cashflow amount', 'b2b'),
                    'order'       => 15,
                ],
                'project_yearly_new_profit_amount'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Project Yearly Net Profit Amount', 'b2b'),
                    'name'        => 'project_yearly_new_profit_amount',
                    'value'        => '',
                    'required'    => TRUE,
                    'placeholder' => __('Enter your project yearly cashflow amount', 'b2b'),
                    'order'       => 15,
                ],
                'custom-html-3'      => [
                    'type'    => 'html',
                    'content' => '</div>',
                    'order'   => 45,
                ],
                'create_opportunity_nonce' => [
                    'class' => '',
                    'type'  => 'nonce',
                    'name'  => 'create_opportunity_nonce',
                    'value' => B2b::_DOMAIN_NAME . "_create_opportunity_form",
                    'order' => 50
                ],
                'submit'             => [
                    'class'               => '',
                    'type'                => 'submit',
                    'id'                => B2b::_DOMAIN_NAME . '_create_opportunity_submit',
                    'value'               => __('Save', 'b2b'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_create_opportunity',
                    'order'               => 55
                ],
            ];
            $form_tags   = [
                'class' => B2b::_DOMAIN_NAME . '-create-opportunity-form',
                'id'    => B2b::_DOMAIN_NAME . '_create_opportunity_form'
            ];
            echo B2b_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);
        ?>
    </main><!-- #main -->

<?php get_footer();

