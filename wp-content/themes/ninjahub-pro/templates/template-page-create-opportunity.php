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

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
?>

<main class="create-opportunity">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ] ); ?>
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'create_new_opportunity' ] ); ?>
		</nav>

		<div class="row d-flex flex-column justify-content-center align-items-center">
			<div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
				<h3 class="text-primary Opportunity-title">
					<?= __( 'Create New Opportunity ', 'ninja' ); ?>
				</h3>
				<p class="text-wrap text-center">Long established fact that a reader will be <br> distracted by the readable
					content
				</p>
			</div>
		</div>
		<?php
		$form_fields = [
			'custom-html-1'                        => [
				'type'    => 'html',
				'content' => '<div class="row"> <h3>'.__('General Information','ninja').'</h3>',
				'order'   => 0,
			],
			'project_name'                         => [
				'class'       => 'col-6',
				'type'        => 'text',
				'label'       => __( 'Project Name', 'ninja' ),
				'name'        => 'project_name',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project name', 'ninja' ),
				'order'       => 5,
			],
			'category'                             => [
				'class'             => 'col-6',
				'type'              => 'select',
				'label'             => __( 'Category', 'ninja' ),
				'name'              => 'category',
				'placeholder'       => __( 'Enter your category', 'ninja' ),
				'options'           => [],
				'default_option'    => '',
				'select_option'     => [],
				'extra_option_attr' => [],
				'before'            => '',
				'order'             => 10,
			],
			'description'                          => [
				'class'       => 'col-6',
				'type'        => 'textarea',
				'label'       => __( 'Description', 'ninja' ),
				'name'        => 'description',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project description', 'ninja' ),
				'rows'        => '4',
				'order'       => 15,
			],
			'short_description'                    => [
				'class'       => 'col-6',
				'type'        => 'textarea',
				'label'       => __( 'Short Description', 'ninja' ),
				'name'        => 'short_description',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project short description', 'ninja' ),
				'rows'        => '4',
				'order'       => 20,
			],
			'business_type'                        => [
				'class'             => 'col-sm-6',
				'type'              => 'select',
				'label'             => __( 'Business Type', 'ninja' ),
				'name'              => 'business_type',
				'placeholder'       => __( 'Enter your business type', 'ninja' ),
				'options'           => [],
				'default_option'    => '',
				'select_option'     => [],
				'extra_option_attr' => [],
				'before'            => '',
				'order'             => 25,
			],
			'date_founded'                         => [
				'class'       => 'col-6',
				'type'        => 'date',
				'label'       => __( 'Date Founded', 'ninja' ),
				'name'        => 'date_founded',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your date founded', 'ninja' ),
				'order'       => 30,
			],
			'asking_price_in_usd'                  => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Asking Price IN USD', 'ninja' ),
				'name'        => 'asking_price_in_usd',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your asking price in USD', 'ninja' ),
				'order'       => 35,
			],
			'number_of_customers'                  => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Number of Customers', 'ninja' ),
				'name'        => 'number_of_customers',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your number of customers', 'ninja' ),
				'order'       => 40,
			],
			'business_team_size'                   => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Business Team Size', 'ninja' ),
				'name'        => 'business_team_size',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your business team size', 'ninja' ),
				'order'       => 45,
			],
			'location'                             => [
				'class'       => 'col-6',
				'type'        => 'text',
				'label'       => __( 'Location', 'ninja' ),
				'name'        => 'location',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your location', 'ninja' ),
				'order'       => 50,
			],

			'media_file'                           => [
				'class'      => 'form-group col-md-6',
				'type'       => 'file',
				'name'       => 'media_file',
				'required'   => FALSE,
				'accept'     => 'image/*',
				'before'     => '',
				'after'      => '',
				'order'      => 55,
				'extra_attr' => [
					'data-target' => "media_file_id"
				]
			],
			'media_file_id'                        => [
				'class'    => '',
				'type'     => 'hidden',
				'name'     => 'media_file_id',
				'required' => FALSE,
				'before'   => '',
				'after'    => '',
				'order'    => 60,
			],

			'custom-html-2'                        => [
				'type'    => 'html',
				'content' => '</div>',
				'order'   => 61,
			],


			'opportunity_type'                     => [
				'class'             => 'col-12',
				'type'              => 'select',
				'label'             => __( 'Opportunity Type', 'ninja' ),
				'name'              => 'opportunity_type',
				'placeholder'       => __( 'Enter your opportunity type', 'ninja' ),
				'options'           => [],
				'default_option'    => '',
				'select_option'     => [],
				'extra_option_attr' => [],
				'before'            => '',
				'order'             => 65,
			],

			'custom-html-bidding-fields-1'         => [
				'type'    => 'html',
				'content' => '<div id="bidding_target"  class="nh-opportunities-fields col-12 nh-hidden"><div class="row">',
				'order'   => 69,
			],
			'start_bidding_amount'                 => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Start Bidding Amount', 'ninja' ),
				'name'        => 'start_bidding_amount',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your start bidding amount', 'ninja' ),
				'order'       => 70,
			],
			'target_amount'                        => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Target Amount', 'ninja' ),
				'name'        => 'target_amount',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your target amount', 'ninja' ),
				'order'       => 75,
			],
			'custom-html-bidding-fields-2'         => [
				'type'    => 'html',
				'content' => '</div></div>',
				'order'   => 80,
			],

			'custom-html-acquisition-fields-1'     => [
				'type'    => 'html',
				'content' => '<div id="acquisition_target" class="nh-opportunities-fields col-12 nh-hidden"><div class="row">',
				'order'   => 85,
			],
			'project_phase'                        => [
				'class'          => 'col-6',
				'type'           => 'select',
				'label'          => __( 'Project Phase', 'ninja' ),
				'name'           => 'project_phase',
				'placeholder'    => __( 'Select your project phase', 'ninja' ),
				'options'        => [
					'preparation' => __( 'Preparation', 'ninja' ),
					'created'     => __( 'Created', 'ninja' ),
					'started'     => __( 'Started', 'ninja' ),
					'running'     => __( 'Running', 'ninja' ),
					'paused'      => __( 'Paused', 'ninja' ),
				],
				'default_option' => '',
				'select_option'  => [],
				'before'         => '',
				'order'          => 90,
			],
			'project_start_date'                   => [
				'class'       => 'col-6',
				'type'        => 'date',
				'label'       => __( 'Project Start Date', 'ninja' ),
				'name'        => 'project_start_date',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project start date', 'ninja' ),
				'order'       => 95,
			],
			'project_assets_amount'                => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Project Assets Amount', 'ninja' ),
				'name'        => 'project_assets_amount',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project assets amount', 'ninja' ),
				'order'       => 100,
			],
			'project_yearly_cashflow_amount'       => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Project Yearly Cashflow Amount', 'ninja' ),
				'name'        => 'project_yearly_cashflow_amount',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project yearly cashflow amount', 'ninja' ),
				'order'       => 105,
			],
			'project_yearly_net_profit_amount'     => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Project Yearly Net Profit Amount', 'ninja' ),
				'name'        => 'project_yearly_net_profit_amount',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your project yearly cashflow amount', 'ninja' ),
				'order'       => 110,
			],
			'custom-html-acquisition-fields-2'     => [
				'type'    => 'html',
				'content' => '</div></div>',
				'order'   => 115,
			],

			'custom-html-3'                        => [
				'type'    => 'html',
				'content' => '<div class="row">',
				'order'   => 120,
			],

			'net_profit'                           => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Net Profit', 'ninja' ),
				'name'        => 'net_profit',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your net profit', 'ninja' ),
				'order'       => 135,
			],
			'valuation_in_usd'                     => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Valuation In USD', 'ninja' ),
				'name'        => 'valuation_in_usd',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your valuation in USD', 'ninja' ),
				'order'       => 140,
			],
			'stake_to_be_sold_percentage'          => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Stake To Be Sold %', 'ninja' ),
				'name'        => 'stake_to_be_sold_percentage',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your stake to be sold %', 'ninja' ),
				'order'       => 145,
			],
			'usd_exchange_rate_used_in_conversion' => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'USD Exchange Rate Used In Conversion', 'ninja' ),
				'name'        => 'usd_exchange_rate_used_in_conversion',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your usd exchange rate used in conversion', 'ninja' ),
				'order'       => 150,
			],
			'annual_accounting_revenue'            => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Annual Accounting Revenue', 'ninja' ),
				'name'        => 'annual_accounting_revenue',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your annual accounting revenue', 'ninja' ),
				'order'       => 155,
			],
			'annual_growth_rate_percentage'        => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Annual Growth Rate %', 'ninja' ),
				'name'        => 'annual_growth_rate_percentage',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your annual growth rate %', 'ninja' ),
				'order'       => 160,
			],
			'annual_growth_rate'                   => [
				'class'       => 'col-6',
				'type'        => 'number',
				'label'       => __( 'Annual Growth Rate', 'ninja' ),
				'name'        => 'annual_growth_rate',
				'value'       => '',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your annual growth rate', 'ninja' ),
				'order'       => 165,
			],
			'custom-html-4'                        => [
				'type'    => 'html',
				'content' => '</div>',
				'order'   => 166,
			],

			'custom-html-5'                        => [
				'type'    => 'html',
				'content' => '<div class="row">',
				'order'   => 167,
			],
			'business_model'                       => [
				'class'             => 'col-sm-12',
				'type'              => 'select',
				'label'             => __( 'Business Model & Pricing', 'ninja' ),
				'name'              => 'business_model',
				'placeholder'       => __( 'Enter your business model & pricing', 'ninja' ),
				'multiple'          => 'multiple',
				'options'           => [],
				'default_option'    => '',
				'select_option'     => [],
				'extra_option_attr' => [],
				'before'            => '',
				'order'             => 170,
			],
			'tech_stack_this_product_is_built_on'  => [
				'class'       => 'col-6',
				'type'        => 'text',
				'label'       => __( 'Tech Stack This Product Is Built On', 'ninja' ),
				'name'        => 'tech_stack_this_product_is_built_on',
				'value'       => 'N/A',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your tech stack this product is built on', 'ninja' ),
				'order'       => 175,
			],
			'product_competitors'                  => [
				'class'       => 'col-6',
				'type'        => 'text',
				'label'       => __( 'Product Competitors', 'ninja' ),
				'name'        => 'product_competitors',
				'value'       => 'N/A',
				'required'    => TRUE,
				'placeholder' => __( 'Enter your product competitors', 'ninja' ),
				'order'       => 180,
			],
			'extra_details'                        => [
				'class'       => 'col-12',
				'type'        => 'textarea',
				'label'       => __( 'Extra details', 'ninja' ),
				'name'        => 'extra_details',
				'value'       => '',
				'required'    => FALSE,
				'placeholder' => __( 'Enter your business extra details', 'ninja' ),
				'rows'        => '4',
				'order'       => 185,
			],
			'custom-html-6'                        => [
				'type'    => 'html',
				'content' => '</div>',
				'order'   => 186,
			],

			'create_opportunity_nonce'             => [
				'class' => '',
				'type'  => 'nonce',
				'name'  => 'create_opportunity_nonce',
				'value' => Nh::_DOMAIN_NAME . "_create_opportunity_form",
				'order' => 189
			],

			'submit'                               => [
				'class'               => 'btn-lg text-uppercase',
				'type'                => 'submit',
				'id'                  => Nh::_DOMAIN_NAME . '_create_opportunity_submit',
				'value'               => '<i class="bbc-save pe-1"></i> ' . __( 'Save', 'ninja' ),
				'before'              => '',
				'after'               => '',
				'recaptcha_form_name' => 'frontend_create_opportunity',
				'order'               => 190
			],
		];
		$form_tags   = [
			'class' => Nh::_DOMAIN_NAME . '-create-opportunity-form',
			'id'    => Nh::_DOMAIN_NAME . '_create_opportunity_form'
		];

		$opportunities_obj            = new Nh_Opportunity();
		$opportunities_category_terms = $opportunities_obj->get_taxonomy_terms( 'opportunity-category' );
		$opportunities_type_terms     = $opportunities_obj->get_taxonomy_terms( 'opportunity-type' );
		$business_type_terms          = $opportunities_obj->get_taxonomy_terms( 'business-type' );
		$business_model_terms         = $opportunities_obj->get_taxonomy_terms( 'business-model' );

		foreach ( $opportunities_category_terms as $key => $term ) {
			$status = get_term_meta( $term->term_id, 'status', TRUE );
			if ( intval( $status ) !== 1 ) {
				continue;
			}
			$form_fields['category']['options'][ $term->term_id ] = $term->name;
		}
		foreach ( $opportunities_type_terms as $key => $term ) {
			$status = get_term_meta( $term->term_id, 'status', TRUE );
			if ( intval( $status ) !== 1 ) {
				continue;
			}
			$form_fields['opportunity_type']['options'][ $term->term_id ]           = $term->name;
			$form_fields['opportunity_type']['extra_option_attr'][ $term->term_id ] = [
				'data-target' => get_term_meta( $term->term_id, 'unique_type_name', TRUE ),
			];

			if ( $key == 0 ) {
				$form_fields['opportunity_type']['default_option'] = $term->term_id;
			}
		}
		foreach ( $business_type_terms as $key => $term ) {
			$status = get_term_meta( $term->term_id, 'status', TRUE );
			if ( intval( $status ) !== 1 ) {
				continue;
			}
			$form_fields['business_type']['options'][ $term->term_id ] = $term->name;
		}

		foreach ( $business_model_terms as $key => $term ) {
			$status = get_term_meta( $term->term_id, 'status', TRUE );
			if ( intval( $status ) !== 1 ) {
				continue;
			}
			$form_fields['business_model']['options'][ $term->term_id ] = $term->name;
		}

		$configurable_fields = [
			'date_founded',
			'asking_price_in_usd',
			'number_of_customers',
			'business_team_size',
			'location',
			'net_profit',
			'valuation_in_usd',
			'stake_to_be_sold_percentage',
			'usd_exchange_rate_used_in_conversion',
			'annual_accounting_revenue',
			'annual_growth_rate_percentage',
			'annual_growth_rate',
			'tech_stack_this_product_is_built_on',
			'product_competitors',
			'extra_details'
		];

		foreach ( $configurable_fields as $field ) {
			if ( (int) NH_CONFIGURATION['opportunities_fields'][ Nh::_DOMAIN_NAME . '_' . $field ] === 0 ) {
				$form_fields[ $field ]['class'] .= ' d-none';
			}
		}

		echo Nh_Forms::get_instance()
			->create_form( $form_fields, $form_tags );
		?>
	</div>
</main><!-- #main -->

<?php get_footer();
