<?php

    /**
     * @Filename: template-my-investments.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Investments Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     */


    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Investments;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-opportunities', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-opportunities');

    global $user_ID;
    $opportunity_obj = new Nh_Opportunity();
    $investments_obj = new Nh_Opportunity_Investments();
    $opportunities   = $opportunity_obj->get_profile_opportunities();
    $investments     = $investments_obj->get_profile_investments(TRUE);

?>
    <main class="my-opportunities">
        <div class="container container-xxl">
            <?php Nh_Public::breadcrumbs(); ?>

            <nav class="dashboard-submenus mt-3 mb-5">
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'my_investments' ]); ?>
            </nav>

            <section class="my-opportunities container">
                <?php
                    if (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                        if (!empty($investments)) {
                            ?>
                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                <?php foreach ($investments as $investment) { ?>
                                    <div class="opportunity-card">

                                        <h3>
                                            <a href="<?= $investment->opportunity->link ?>">
                                                <?= $investment->opportunity->title; ?>
                                            </a>
                                        </h3>

                                        <span class="date">
                                        <?= date('F jS, Y', strtotime($investment->opportunity->created_date)); ?>
                                    </span>

                                        <p class="short-description">
                                            <?= $investment->opportunity->meta_data['short_description']; ?>
                                        </p>

                                        <span class="status">
                                        <?= $investment->meta_data['investments_stage']; ?>
                                    </span>

                                    </div>
                                <?php } ?>
                            </div> <!-- </row-cols-1 -->
                            <?php
                        } else {
                            get_template_part('app/Views/template-parts/cards/my-opportunities-empty', NULL, []);
                        }

                    }
                ?>
            </section>
        </div>
    </main><!-- #main -->

<?php
    get_footer();
