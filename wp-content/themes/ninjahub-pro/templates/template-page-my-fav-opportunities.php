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
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, ['active_link' => 'opportunities']); ?>
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/opportunities-sub-nav', NULL, ['active_link' => 'my_favorite']); ?>
        </nav>
    </div>

    <section class="page-content opportunity-content">
        <div class="opportunity-list ignore-list">
            <div class="card-group">
                <?php
                if (!empty($opportunities)) {
                    foreach ($opportunities as $opportunity) {
                        $fav_check = $opportunity_obj->is_opportunity_in_user_favorites($opportunity->ID);
                        $fav_class = '';
                        if ($fav_check) {
                            $fav_class = 'bbc-star';
                        } else {
                            $fav_class = 'bbc-star-o';
                        }
                        $args['fav_form'] = Nh_Forms::get_instance()
                            ->create_form([
                                'opp_id'                      => [
                                    'type'   => 'hidden',
                                    'name'   => 'opp_id',
                                    'before' => '',
                                    'after'  => '',
                                    'value'  => $opportunity->ID,
                                    'order'  => 0
                                ],
                                'add_to_fav_nonce'               => [
                                    'class' => '',
                                    'type'  => 'nonce',
                                    'name'  => 'add_to_fav_nonce_nonce',
                                    'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
                                    'order' => 5
                                ],
                                'submit_add_to_fav_request' => [
                                    'class'               => 'btn btn-light bg-white opportunity-to-favorite ninja-add-to-fav',
                                    'id'                  => 'submit_add_to_fav_request',
                                    'type'                => 'submit',
                                    'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                                    'recaptcha_form_name' => 'frontend_add_to_fav',
                                    'order'               => 10
                                ],
                            ], [
                                'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                            ]);
                            $args['current_page'] = 'my-favorite-opportunities';
                        $args['opportunity'] = $opportunity;
                ?>
                        <div class="col">
                            <?php get_template_part('app/Views/opportunities/opportunity-item', NULL, $args); ?>
                        </div>
                <?php
                    }
                } else {
                    get_template_part('app/Views/opportunities/opportunities', 'empty');
                }
                ?>
            </div>
        </div>
    </section>
</main><!-- #main -->

<?php get_footer();
