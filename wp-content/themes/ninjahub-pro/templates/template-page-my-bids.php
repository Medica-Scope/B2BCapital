<?php

    /**
     * @Filename: template-my-bids.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Bids Page
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
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Bid;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-opportunities', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-opportunities');

    global $user_ID;
    $opportunity_obj = new Nh_Opportunity();
    $bids_obj        = new Nh_Opportunity_Bid();
    $opportunities   = $opportunity_obj->get_profile_opportunities();
    $bids            = $bids_obj->get_profile_bids(true);

?>
    <main class="my-opportunities">
        <div class="container container-xxl">
            <?php Nh_Public::breadcrumbs(); ?>

            <nav class="dashboard-submenus mt-3 mb-5">
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'my_bids' ]); ?>
            </nav>

            <section class="my-opportunities container">
                <?php
                    if (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                        if (!empty($bids)) {
                            ?>
                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                <?php
                                    foreach ($bids as $bid) {
                                        ?>
                                        <div class="opportunity-card">

                                            <h3>
                                                <a href="<?= $bid->opportunity->link ?>">
                                                    <?= $bid->opportunity->title; ?>
                                                </a>
                                            </h3>

                                            <span class="date">
                                            <?= date('F jS, Y', strtotime($bid->opportunity->created_date)); ?>
                                        </span>

                                            <p class="short-description">
                                                <?= $bid->opportunity->meta_data['short_description']; ?>
                                            </p>

                                            <span class="status">
                                            <?= $bid->meta_data['bidding_stage']; ?>
                                        </span>

                                        </div>
                                        <?php
                                    }
                                ?>
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
