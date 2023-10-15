<?php

    /**
     * @Filename: template-my-opportunities.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Opportunities Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');

    global $user_ID;
    $opportunity_obj  = new Nh_Opportunity();
    $acquisitions_obj = new Nh_Opportunity_Acquisition();
    $opportunities    = $opportunity_obj->get_profile_opportunities();
    $acquisitions     = $acquisitions_obj->get_profile_acquisitions();

?>
    <main class="my-opportunity">
        <div class="container container-xxl">
            <?php Nh_Public::breadcrumbs(); ?>

            <nav class="dashboard-submenus mt-3 mb-5">
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
            </nav>

            <section class="page-content opportunity-content">
                <?php

                    if (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                        foreach ($acquisitions as $acquisition) {
                            ?>
                            <div class="opportunity-card">

                                <h3>
                                    <?= $acquisition->opportunity->title ?>
                                </h3>

                                <span class="date">
                                    <?= date('F jS, Y', strtotime($acquisition->opportunity->created_date)) ?>
                                </span>

                                <p class="short-description">
                                    <?= $acquisition->opportunity->meta_data['short_description'] ?>
                                </p>

                                <span class="status">
                                    <?= $acquisition->meta_data['acquisition_stage'] ?>
                                </span>

                            </div>
                            <?php
                        }
                    } else {
                        foreach ($opportunities as $opportunity) {
                            ?>
                            <div class="opportunity-card">

                                <?php
                                    if (strtotime($opportunity->modified) >= strtotime(date('Y-m-d', strtotime('-30 days')))) {
                                        ?>
                                        <span class="card-badge">
											<?= __("New", "ninja") ?>
										</span>
                                        <?php
                                    }
                                ?>

                                <h3>
                                    <?= $opportunity->title ?>
                                </h3>

                                <span class="date">
                                    <?= date('F jS, Y', strtotime($opportunity->created_date)) ?>
                                </span>

                                <p class="short-description">
                                    <?= $opportunity->meta_data['short_description'] ?>
                                </p>

                                <span class="status">
                                    <?= $opportunity->meta_data['opportunity_stage'] ?>
                                </span>

                            </div>
                            <?php
                        }
                    }

                ?>
            </section>
        </div>
    </main><!-- #main -->

<?php get_footer();
