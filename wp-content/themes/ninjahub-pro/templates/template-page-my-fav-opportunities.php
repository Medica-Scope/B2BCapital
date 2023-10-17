<?php
    /**
     * @Filename: template-my-fav-opportunities.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Favorite Opportunities Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');

    global $user_ID;
    $opportunity_obj  = new Nh_Opportunity();
    $opportunities    = $opportunity_obj->get_profile_fav_opportunities();
    $user_obj         = Nh_User::get_current_user();
?>

    <main class="my-fav-opportunities">
        <div class="container container-xxl">
            <?php Nh_Public::breadcrumbs(); ?>

            <nav class="dashboard-submenus mt-3 mb-5">
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, [ 'active_link' => 'opportunities' ]); ?>
                <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, [ 'active_link' => 'my_favorite' ]); ?>
            </nav>
        </div>

        <section class="page-content opportunity-content">
            <?php

                foreach ($opportunities as $opportunity) {
                    $fav_check = $opportunity_obj->is_opportunity_in_user_favorites($opportunity->ID);
                    $args = [
                        'opportunity_link'         => $opportunity->link,
                        'opportunity_title'        => $opportunity->title,
                        'opportunity_thumbnail'    => $opportunity->thumbnail,
                        'opportunity_created_date' => $opportunity->created_date,
                        'is_item_controllers'      => TRUE,
                        'opportunity_id'           => $opportunity->ID,
                        'is_fav'                   => $fav_check
                    ];
                    ?>
                    <div class="col">
                        <?php get_template_part('app/Views/template-parts/cards/opportunity-card-vertical', NULL, $args); ?>
                    </div>
                    <?php
                }

            ?>
        </section>
    </main><!-- #main -->

<?php get_footer();
