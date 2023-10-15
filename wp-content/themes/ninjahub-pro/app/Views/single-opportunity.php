<?php

    /**
     * @Filename: single.php
     * @Description:
     * @User: Mustafa Shaaban
     * @Date: 9/21/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\Nh;

    global $post;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-single-opportunity', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-opportunity');

    $opportunity_obj = new Nh_Opportunity();
    $opportunity     = $opportunity_obj->get_by_id($post->ID);
    $business_model  = isset($opportunity->taxonomy['business-model']) ? implode(' + ', array_map(function($single) {
        return $single->name;
    }, $opportunity->taxonomy['business-model'])) : '';

?>

    <main class="container container-xxl">
        <a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'dashboard' ) ) ) ?>" class="btn btn-secondary text-uppercase mb-2"><i class="bbc-chevron-left"></i>
            <?= __('back', 'ninja'); ?>
        </a>
        <h3 class="mb-4">
            <?= $opportunity->title; ?>
        </h3>

        <h3 class="text-warning">
            <?= __('Business Type', 'ninja'); ?>
        </h3>

        <p><?= $opportunity->taxonomy['business-type'][0]->name ?></p>
        <div class="opportunity-details row row-cols-1 row-cols-md-2 g-4 mt-2">
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $opportunity->thumbnail ?>" class="img-fluid rounded-start" alt="<?= esc_attr($opportunity->title); ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= __('About', 'ninja') ?></h5>
                                <div class="card-text"><?= $opportunity->meta_data['short_description']; ?></div>
                                <div class="card-extra-info">
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Date Founded', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= date('F j, Y', strtotime($opportunity->meta_data['date_founded'])); ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Asking price in USD', 'ninja') ?></small>
                                        <p class="card-text fw-bold text-success">$<?= $opportunity->meta_data['asking_price_in_usd']; ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Number of Customers', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['number_of_customers']; ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Business Team size', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['business_team_size']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= __('Financial Details', 'ninja') ?></h5>
                                <div class="card-extra-info">
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Net Profit', 'ninja') ?></small>
                                        <p class="card-text fw-bold text-success">$<?= $opportunity->meta_data['net_profit']; ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Valuation in USD', 'ninja') ?></small>
                                        <p class="card-text fw-bold text-success">$<?= $opportunity->meta_data['valuation_in_usd'] ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Stake to be sold', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['stake_to_be_sold_percentage'] ?>%</p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('USD Exchange rate used in conversion', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= sprintf(__('%s EGP', 'ninja'), $opportunity->meta_data['usd_exchange_rate_used_in_conversion']); ?></p>
                                    </div>
                                </div>
                                <div class="card-extra-info">
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Annual Accounting Revenue', 'ninja') ?></small>
                                        <p class="card-text fw-bold text-success">$<?= $opportunity->meta_data['annual_accounting_revenue'] ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Annual Growth Rate', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['annual_growth_rate_percentage'] ?>%</p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Annual Growth Rate', 'ninja') ?></small>
                                        <p class="card-text fw-bold text-success">$<?= $opportunity->meta_data['annual_growth_rate'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= __('Business Overview', 'ninja') ?></h5>
                                <div class="card-extra-info">
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Business model and pricing', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $business_model ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Tech stack this product is built on', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['tech_stack_this_product_is_built_on'] ?></p>
                                    </div>
                                    <div class="card-info-item">
                                        <small class="text-body-secondary"><?= __('Product competitors', 'ninja') ?></small>
                                        <p class="card-text fw-bold"><?= $opportunity->meta_data['product_competitors'] ?></p>
                                    </div>
                                </div>
                                <div class="extra-info">
                                    <?= $opportunity->meta_data['extra_details'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col details-items">
                <?php get_template_part('app/Views/template-parts/cards/faq-help-card', NULL, []); ?>
            </div>
        </div>

        <div class="related-opportunities mb-4">
            <h3>
                <?= __('Related Opportunities', 'ninja'); ?>
            </h3>
            <?php get_template_part('app/Views/template-parts/related-opportunities-slider', NULL, []); ?>
        </div>
    </main><!-- #main -->
<?php get_template_part('app/Views/js-templates/horizontal-scroll', NULL, [ 'scrollable_container' => '.related-opportunities-slider .overflow-x-auto' ]); ?>
<?php
    get_footer();
