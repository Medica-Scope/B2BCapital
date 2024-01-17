<?php
    /**
     * @Filename: template-page-dashboard.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Dashboard Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile_Widget;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    global $user_ID;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-dashboard', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/home-dashboard');

    $opportunities_obj = new Nh_Opportunity();
    $acquisitions_obj  = new Nh_Opportunity_Acquisition();
    $paged             = 1;
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    }

    $user = Nh_User::get_current_user();
?>

    <main class="site-dashboard-home">
        <div class="container-xxl">
            <div class="dashboard-overview">
                <h3 class="fs-3 mt-5 mb-3 text-primary">
                    <?= __('Overview', 'ninja') ?>
                </h3>
                <div class="widget-list">
                    <div class="single-widget">
                        <?php
                            if (is_array($user->profile->meta_data['widget_list'])) {
                                foreach ($user->profile->meta_data['widget_list'] as $widget) {

                                    $language_info = wpml_get_language_information(NULL, (int)$widget);

                                    if (is_wp_error($language_info) || $language_info['language_code'] !== NH_lANG) {
                                        continue;
                                    }

                                    $widgets_obj = new Nh_Profile_Widget();
                                    $nh_widget   = $widgets_obj->get_by_id((int)$widget);

                                    if (intval($nh_widget->meta_data['widget_active']) === 0) {
                                        continue;
                                    }

                                    $html = $nh_widget->get_widget_html();

                                    if (is_wp_error($html)) {
                                        continue;
                                    }
                                    ?>
                                    <div class="widget-container">
                                        <?php
                                            echo $nh_widget->get_widget_html();
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>


            <section class="dashboard-body">
                <div class="collapse shadow" id="collapseFilter">
                    <div class="filter-con">
                        <?php
                            $business_type_terms = $opportunities_obj->get_taxonomy_terms('business-type');
                            $business_options = [];
                            $business_options[''] = __("All", "ninja") ;
                            foreach ($business_type_terms as $key => $term) {
                                $status = get_term_meta($term->term_id, 'status', TRUE);
                                if (intval($status) !== 1) {
                                    continue;
                                }
                                $business_options[$term->slug] = $term->name;
                            }
                            $args = [
                                'post_type'      => 'opportunity',
                                'fields'         => 'ids',
                                'posts_per_page' => 1,
                                'meta_key'       => 'net_profit_group_net_profit',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                            ];

                            $highest_net_profit = get_posts($args);

                            $args = [
                                'post_type'      => 'opportunity',
                                'fields'         => 'ids',
                                'posts_per_page' => 1,
                                'meta_key'       => 'annual_accounting_revenue_group_annual_accounting_revenue',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                            ];

                            $highest_annual_accounting_revenue = get_posts($args);

                            $args = [
                                'post_type'      => 'opportunity',
                                'fields'         => 'ids',
                                'posts_per_page' => 1,
                                'meta_key'       => 'annual_growth_rate_group_annual_growth_rate',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                            ];

                            $highest_annual_growth_rate = get_posts($args);

                            $args = [
                                'post_type'      => 'opportunity',
                                'fields'         => 'ids',
                                'posts_per_page' => 1,
                                'meta_key'       => 'asking_price_in_usd_group_asking_price_in_usd',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                            ];

                            $highest_asking_price_in_usd = get_posts($args);

                            echo Nh_Forms::get_instance()
                                         ->create_form([
                                             'filter_fields_container_start'                             => [
                                                 'type'    => 'html',
                                                 'content' => '<div class="filter-fields-container">',
                                                 'before'  => '',
                                                 'after'   => '',
                                                 'order'   => 0
                                             ],
                                             'business_type'                                             => [
                                                 'type'           => 'select',
                                                 'label'          => 'Business type',
                                                 'name'           => 'business_type',
                                                 'before'         => '',
                                                 'after'          => '',
                                                 'default_option' => isset($_GET['business_type']) && !empty($_GET['business_type']) ? $_GET['business_type'] : 'All',
                                                 'options'        => $business_options,
                                                 'order'          => 10
                                             ],
                                             'location_group_location'                                   => [
                                                 'type'           => 'select',
                                                 'label'          => 'Based in',
                                                 'name'           => 'location_group_location',
                                                 'before'         => '',
                                                 'after'          => '',
                                                //  'value'          => isset($_GET['location_group_location']) ? $_GET['location_group_location'] : '',
                                                 'default_option' => isset($_GET['location_group_location']) && !empty($_GET['location_group_location']) ? $_GET['location_group_location'] : 'All',
                                                 'options'        => [
                                                     ''          => __("All", "ninja"),
                                                     'Egypt'        => __("Egypt", "ninja"),
                                                     'Russia'       => __("Russia", "ninja"),
                                                     'Sheikh Zayed' => __("Sheikh Zayed", "ninja"),
                                                 ],
                                                 'order'          => 20
                                             ],
                                             // 'ttm_gross_revenue'    => [
                                             // 	'type'   => 'range',
                                             // 	'label'  => 'TTM Gross Revenue',
                                             // 	'from'   => 50,
                                             // 	'to'     => 500000,
                                             // 	'name'   => 'ttm_gross_revenue',
                                             // 	'before' => '',
                                             // 	'after'  => '',
                                             // 	'value'  => isset($_GET['ttm_gross_revenue'])?$_GET['ttm_gross_revenue']:'',
                                             // 	'order'  => 20
                                             // ],
                                             'net_profit_group_net_profit'                               => [
                                                 'type'   => 'range',
                                                 'label'  => 'TTM Net Profit',
                                                 'from'   => 50,
                                                 'to'     => (!empty($highest_net_profit)) ? get_post_meta($highest_net_profit[0], 'net_profit_group_net_profit', TRUE) : 500000,
                                                 'name'   => 'net_profit_group_net_profit',
                                                 'before' => '',
                                                 'after'  => '',
                                                 'value'  => isset($_GET['net_profit_group_net_profit']) ? $_GET['net_profit_group_net_profit'] : '',
                                                 'order'  => 30
                                             ],
                                             'annual_accounting_revenue_group_annual_accounting_revenue' => [
                                                 'type'   => 'range',
                                                 'label'  => 'TTM Accruing Revenue',
                                                 'from'   => 1,
                                                 'to'     => (!empty($highest_annual_accounting_revenue)) ? get_post_meta($highest_annual_accounting_revenue[0], 'annual_accounting_revenue_group_annual_accounting_revenue', TRUE) : 500000,
                                                 'name'   => 'annual_accounting_revenue_group_annual_accounting_revenue',
                                                 'before' => '',
                                                 'after'  => '',
                                                 'value'  => isset($_GET['annual_accounting_revenue_group_annual_accounting_revenue']) ? $_GET['annual_accounting_revenue_group_annual_accounting_revenue'] : '',
                                                 'order'  => 40
                                             ],
                                             'annual_growth_rate_group_annual_growth_rate'               => [
                                                 'type'   => 'range',
                                                 'label'  => 'Annual Growth Rate',
                                                 'from'   => 1,
                                                 'to'     => (!empty($highest_annual_growth_rate)) ? get_post_meta($highest_annual_growth_rate[0], 'annual_growth_rate_group_annual_growth_rate', TRUE) : 500000,
                                                 'name'   => 'annual_growth_rate_group_annual_growth_rate',
                                                 'before' => '',
                                                 'after'  => '',
                                                 'value'  => isset($_GET['annual_growth_rate_group_annual_growth_rate']) ? $_GET['annual_growth_rate_group_annual_growth_rate'] : '',
                                                 'order'  => 50
                                             ],
                                             'asking_price_in_usd_group_asking_price_in_usd'             => [
                                                 'type'   => 'range',
                                                 'label'  => 'Asking Price',
                                                 'from'   => 1,
                                                 'to'     => (!empty($highest_asking_price_in_usd)) ? get_post_meta($highest_asking_price_in_usd[0], 'asking_price_in_usd_group_asking_price_in_usd', TRUE) : 500000,
                                                 'name'   => 'asking_price_in_usd_group_asking_price_in_usd',
                                                 'before' => '',
                                                 'after'  => '',
                                                 'value'  => isset($_GET['asking_price_in_usd_group_asking_price_in_usd']) ? $_GET['asking_price_in_usd_group_asking_price_in_usd'] : '',
                                                 'order'  => 60
                                             ],
                                             'filter_fields_container_end'                               => [
                                                 'type'    => 'html',
                                                 'content' => '</div>',
                                                 'before'  => '',
                                                 'after'   => '',
                                                 'order'   => 70
                                             ],
                                             'filter_actions_container_start'                            => [
                                                 'type'    => 'html',
                                                 'content' => '<div class="filter-actions-container">',
                                                 'before'  => '',
                                                 'after'   => '',
                                                 'order'   => 80
                                             ],
                                             'search_input'                                              => [
                                                 'type'        => 'text',
                                                 'name'        => 'search',
                                                 'before'      => '',
                                                 'after'       => '<i class="bbc-search2"></i>',
                                                 'placeholder' => 'Find topics by entering terms in the search box',
                                                 'value'       => isset($_GET['search']) ? $_GET['search'] : '',
                                                 'order'       => 90
                                             ],
                                             // 'filters_nonce'          => [
                                             // 	'class' => '',
                                             // 	'type'  => 'nonce',
                                             // 	'name'  => 'filters_nonce',
                                             // 	'value' => Nh::_DOMAIN_NAME . "_filters_nonce_form",
                                             // 	'order' => 80
                                             // ],
                                             'submit_filters_request'                                    => [
                                                 'class'               => 'btn ms-2 filter-opportunities ninja-filter-opportunities text-uppercase fw-bold',
                                                 'id'                  => 'submit_filters_request',
                                                 'type'                => 'submit',
                                                 'value'               => 'Search',
                                                 'recaptcha_form_name' => 'frontend_filters',
                                                 'order'               => 100
                                             ],
                                             'reset_filters'                                             => [
                                                 // 'type'  => 'reset',
                                                 'type'    => 'html',
                                                 'content' => '<a class="reset-btn btn btn-link text-dark text-uppercase ms-2 p-0">' . __("Reset Filters", "ninja") . '</a>',
                                                 // 'class' => 'btn btn-link',
                                                 // 'id'    => 'reset_filters_request',
                                                 // 'value' => 'Reset filters',
                                                 'order'   => 110
                                             ],
                                             'filter_actions_container_end'                              => [
                                                 'type'    => 'html',
                                                 'content' => '</div>',
                                                 'before'  => '',
                                                 'after'   => '',
                                                 'order'   => 120
                                             ],
                                         ], [
                                             'class' => Nh::_DOMAIN_NAME . '-filters-form',
                                             'id'    => Nh::_DOMAIN_NAME . '_filters_form',
                                         ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="dashboard-opportunity-list-container">
                            <div class="opportunity-list-header row justify-content-between align-items-center">
                                <div class="opportunity-title col-6">
                                    <h3 class="fs-3 text-primary mb-3">
                                        <?= __('Latest Opportunities', 'ninja') ?>
                                    </h3>
                                    <p>
                                        <?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores eaque eos fuga neque, pariatur.', 'ninja') ?>
                                    </p>
                                </div>
                                <div class="opportunity-actions col-6">
                                    <div class="filters">
                                        <button class="btn btn-outline-warning opportunity-adv-filter" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                            <i class="bbc-sliders"></i>
                                            <?= __('Advanced Filters', 'ninja') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="opportunity-list">
                                <?php
                                    $search_fields = $_GET;
                                    $opportunities = $opportunities_obj->get_all_custom([ 'publish' ], 12, 'date', 'DESC', [], [], $user_ID, $paged, [], $search_fields);
                                    if (!empty($opportunities)) {
                                        ?>
                                        <div
                                                class="row row-cols-1 row-cols-md-2 g-4 <?= (isset($_COOKIE['grid_view'])) ? $_COOKIE['grid_view'] : 'card-group' ?>">
                                            <?php
                                                foreach ($opportunities['posts'] as $opportunity) {
                                                    $args                = [];
                                                    $args['fav_form']    = '';
                                                    $args['ignore_form'] = '';
                                                    if (!empty($user_ID)) {
                                                        $fav_chk            = $opportunities_obj->is_opportunity_in_user_favorites($opportunity->ID);
                                                        $ignore_chk         = $opportunities_obj->is_opportunity_in_user_ignored($opportunity->ID);
                                                        $args['fav_chk']    = $fav_chk;
                                                        $args['ignore_chk'] = $ignore_chk;
                                                        if ($fav_chk) {
                                                            $fav_class = 'controll-icon bbc-star';
                                                        } else {
                                                            $fav_class = 'controll-icon bbc-star-o';
                                                        }
                                                        $args['fav_form'] = Nh_Forms::get_instance()
                                                                                    ->create_form([
                                                                                        'opp_id'                    => [
                                                                                            'type'   => 'hidden',
                                                                                            'name'   => 'opp_id',
                                                                                            'before' => '',
                                                                                            'after'  => '',
                                                                                            'value'  => $opportunity->ID,
                                                                                            'order'  => 0
                                                                                        ],
                                                                                        'add_to_fav_nonce'          => [
                                                                                            'class' => '',
                                                                                            'type'  => 'nonce',
                                                                                            'name'  => 'add_to_fav_nonce_nonce',
                                                                                            'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
                                                                                            'order' => 5
                                                                                        ],
                                                                                        'submit_add_to_fav_request' => [
                                                                                            'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
                                                                                            'id'                  => 'submit_add_to_fav_request',
                                                                                            'type'                => 'submit',
                                                                                            'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                                                                                            'recaptcha_form_name' => 'frontend_add_to_fav',
                                                                                            'order'               => 10
                                                                                        ],
                                                                                    ], [
                                                                                        'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                                                                                    ]);
                                                        if ($ignore_chk) {
                                                            $ignore_class = 'controll-icon bbc-thumbs-up text-success';
                                                        } else {
                                                            $ignore_class = 'controll-icon bbc-thumbs-down text-danger';
                                                        }
                                                        $args['ignore_form'] = Nh_Forms::get_instance()
                                                                                       ->create_form([
                                                                                           'opp_id'                   => [
                                                                                               'type'   => 'hidden',
                                                                                               'name'   => 'opp_id',
                                                                                               'before' => '',
                                                                                               'after'  => '',
                                                                                               'value'  => $opportunity->ID,
                                                                                               'order'  => 0
                                                                                           ],
                                                                                           'ignore_opportunity_nonce' => [
                                                                                               'class' => '',
                                                                                               'type'  => 'nonce',
                                                                                               'name'  => 'ignore_opportunity_nonce',
                                                                                               'value' => Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form",
                                                                                               'order' => 5
                                                                                           ],
                                                                                           'submit_ignore'            => [
                                                                                               'class'               => 'btn btn-light bg-white ms-2',
                                                                                               'id'                  => 'submit_submit_ignore',
                                                                                               'type'                => 'submit',
                                                                                               'value'               => '<i class="' . $ignore_class . ' ignore-star"></i>',
                                                                                               'recaptcha_form_name' => 'frontend_ignore',
                                                                                               'order'               => 10
                                                                                           ],
                                                                                       ], [
                                                                                           'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
                                                                                       ]);
                                                    }
                                                    $args['current_page'] = 'dashboard';
                                                    $args['opportunity']  = $opportunity;
                                                    /*
                                                     * Include the Post-Type-specific template for the content.
                                                     * If you want to override this in a child theme, then include a file
                                                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                                     */
                                                    ?>
                                                    <div class="col">
                                                        <?php get_template_part('app/Views/opportunities/opportunity-item', NULL, $args); // GAMAL ?>
                                                        <?php //get_template_part( 'app/Views/template-parts/cards/opportunity-card-vertical', NULL, $args ); // KHALED?>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>

                                        <div class="pagination-con">
                                            <?php
                                                echo $opportunities['pagination'];
                                            ?>
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="sidebar-container mt-5 mt-md-0">

                            <?php if (Nh_User::get_user_role() !== Nh_User::INVESTOR) { ?>
                                <div class="sidebar-create-opportunity shadow">
                                    <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity'))); ?>"
                                       class="btn-create-opportunity btn btn-success btn-lg shadow text-uppercase">
                                        <i class="bbc-plus-square"></i>
                                        <?= __('Create New Opportunity', 'ninja') ?>
                                    </a>

                                    <small class="pt-3">
                                        <i class="bbc-lightbulb-o"></i>
                                        <?= __('Please Note You Can Add Only', 'ninja'); ?>
                                        <span class="text-warning">
									<?= __('One Opportunity In Month', 'ninja') ?>
								</span>
                                    </small>
                                </div>
                            <?php } ?>
                            <div class="sidebar-my-opportunities shadow">
                                <div>
                                    <?php
                                        if (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                                            ?>
                                            <h3 class="text-primary">
                                                <?= __('My Acquisitions', 'ninja'); ?>
                                            </h3>
                                            <small class="text-muted">
                                                <?= sprintf(__('Latest update in %s', 'ninja'), date_i18n('F j, Y', strtotime(date('F j, Y')))); ?>
                                            </small>
                                            <h6>
                                                <?= __('Acquisitions', 'ninja') ?>
                                            </h6>

                                            <?php

                                        } else {
                                            ?>
                                            <h3 class="text-primary">
                                                <?= __('My Opportunities', 'ninja'); ?>
                                            </h3>
                                            <small class="text-muted">
                                                <?= sprintf(__('Latest update in %s', 'ninja'), date_i18n('F j, Y', strtotime(date('F j, Y')))); ?>
                                            </small>
                                            <h6>
                                                <?= __('Opportunities', 'ninja') ?>
                                            </h6>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="acquisitions-list">
                                    <div class="row row-cols-1 g-4 card-group">
                                        <?php

                                            if (Nh_User::get_user_role() === Nh_User::INVESTOR) {

                                                $acquisitions = $acquisitions_obj->get_dashboard_sidebar_acquisitions(TRUE);

                                                foreach ($acquisitions as $acquisition) {
                                                    $args = [
                                                        'opportunity_link'         => $acquisition->opportunity->link,
                                                        'opportunity_title'        => $acquisition->opportunity->title,
                                                        'opportunity_thumbnail'    => $acquisition->opportunity->thumbnail,
                                                        'opportunity_created_date' => $acquisition->opportunity->created_date,
                                                        'is_item_controllers'      => FALSE,
                                                        'opportunity_id'           => $opportunity->ID,
                                                        'short_description'        => $opportunity->meta_data['short_description'],
                                                        'business_type'            => $acquisition->opportunity->taxonomy['business-type'][0]->name,
                                                        'location'                 => $opportunity->meta_data['location_group_location'],
                                                        'location_appearance'      => $opportunity->meta_data['location_group_appearance'],
                                                        'valuation'                => $opportunity->meta_data['valuation_in_usd_group_valuation_in_usd'],
                                                        'valuation_appearance'     => $opportunity->meta_data['valuation_in_usd_group_appearance'],
                                                    ];

                                                    ?>
                                                    <div class="col">
                                                        <?php get_template_part('app/Views/template-parts/cards/acquisition-card-horizontal', NULL, $args); ?>
                                                    </div>
                                                    <?php
                                                }
                                            } else {

                                                $opportunities = $opportunities_obj->get_dashboard_sidebar_opportunities();

                                                foreach ($opportunities as $opportunity) {
                                                    $args = [
                                                        'opportunity_link'         => $opportunity->link,
                                                        'opportunity_title'        => $opportunity->title,
                                                        'opportunity_thumbnail'    => $opportunity->thumbnail,
                                                        'opportunity_created_date' => $opportunity->created_date,
                                                        'is_item_controllers'      => FALSE,
                                                        'opportunity_id'           => $opportunity->ID,
                                                        'short_description'        => $opportunity->meta_data['short_description'],
                                                        'business_type'            => $opportunity->taxonomy['business-type'][0]->name,
                                                        'location'                 => $opportunity->meta_data['location_group_location'],
                                                        'location_appearance'      => $opportunity->meta_data['location_group_appearance'],
                                                        'valuation'                => $opportunity->meta_data['valuation_in_usd_group_valuation_in_usd'],
                                                        'valuation_appearance'     => $opportunity->meta_data['valuation_in_usd_group_appearance'],
                                                    ];
                                                    ?>
                                                    <div class="col">
                                                        <?php get_template_part('app/Views/template-parts/cards/opportunity-card-horizontal', NULL, $args); ?>
                                                    </div>
                                                    <?php

                                                }
                                            }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-latest-acquisitions shadow">
                                <div>
                                    <h3 class="text-primary">
                                        <?= __('Latest Acquisitions', 'ninja') ?>
                                    </h3>
                                    <small class="text-muted">
                                        <?= sprintf(__('Latest update in %s', 'ninja'), date_i18n('F j, Y', strtotime(date('F j, Y')))); ?>
                                    </small>
                                    <h6>
                                        <?= __('Acquisitions', 'ninja') ?>
                                    </h6>
                                </div>
                                <div class="acquisitions-list">
                                    <div class="row row-cols-1 g-4 card-group">
                                        <?php
                                            $acquisitions = $acquisitions_obj->get_dashboard_sidebar_acquisitions();

                                            foreach ($acquisitions as $acquisition) {
                                                if (is_wp_error($acquisition->opportunity)) {
                                                    continue;
                                                }
                                                $args = [
                                                    'opportunity_link'         => $acquisition->opportunity->link,
                                                    'opportunity_title'        => $acquisition->opportunity->title,
                                                    'opportunity_thumbnail'    => $acquisition->opportunity->thumbnail,
                                                    'opportunity_created_date' => $acquisition->opportunity->created_date,
                                                    'is_item_controllers'      => FALSE,
                                                    'short_description'        => $acquisition->opportunity->meta_data['short_description'],
                                                    'business_type'            => $acquisition->opportunity->taxonomy['business-type'][0]->name,
                                                    'location'                 => $acquisition->opportunity->meta_data['location_group_location'],
                                                    'location_appearance'      => $acquisition->opportunity->meta_data['location_group_appearance'],
                                                    'valuation'                => $acquisition->opportunity->meta_data['valuation_in_usd_group_valuation_in_usd'],
                                                    'valuation_appearance'     => $acquisition->opportunity->meta_data['valuation_in_usd_group_appearance'],
                                                ];
                                                ?>
                                                <div class="col">
                                                    <?php get_template_part('app/Views/template-parts/cards/acquisition-card-horizontal', NULL, $args); ?>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php get_template_part('app/Views/template-parts/cards/faq-help-card', NULL, []); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main><!-- #main -->

<?php get_footer();
