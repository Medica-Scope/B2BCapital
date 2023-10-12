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
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\APP\MODELS\FRONT\Nh_Public;

get_header();

global $user_ID;
$opportunity_obj = new Nh_Opportunity();
$profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
$profile_obj = new Nh_Profile();
$profile     = $profile_obj->get_by_id((int)$profile_id);
$favorites = [];
$opportunities = [];
?>

<main id="" class="">
    <div class="container">
        <?php Nh_Public::breadcrumbs(); ?>
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"><?= __('My Account', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja'); ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-widgets'))) ?>"><?= __('Widgets', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"><?= __('Notifications', 'ninja') ?></a>
        </nav>
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= sprintf(__('My %s', 'ninja'), Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja')); ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-favorite-opportunities'))) ?>"><?= sprintf(__('My Favorite %s', 'ninja'), Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja')) ?></a>
        </nav>

        <section class="page-content">
            <?php
            if (!is_wp_error($profile)) {
                $favorite_opportunities = ($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
                $opportunities = $opportunity_obj->get_all_custom(['publish'], -1, 'date', 'DESC', $favorite_opportunities, [], $user_ID);
                if (!empty($opportunities)) {
            ?>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-my-opportunity-tab" data-toggle="tab" href="#nav-my-opportunity" role="tab" aria-controls="nav-my-opportunity" aria-selected="true"><?= __("My Opportunities", "ninja"); ?></a>
                            <?php //if(!empty($favorite_opportunities)){ 
                            ?>
                            <a class="nav-item nav-link" id="nav-fav-opportunity-tab" data-toggle="tab" href="#nav-fav-opportunity" role="tab" aria-controls="nav-fav-opportunity" aria-selected="false"><?= __("My Favorite Opportunities", "ninja"); ?></a>
                            <?php //} 
                            ?>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-my-opportunity" role="tabpanel" aria-labelledby="nav-my-opportunity-tab">
                            <?php
                            foreach ($opportunities as $opportunity) {
                                $opportunity_date = get_the_date('Y-m-d', $opportunity->ID);
                            ?>
                                <div class="opportunity-card">
                                    <?php
                                    if ($opportunity_date >= date('Y-m-d', strtotime('-20 days'))) {
                                    ?>
                                        <span class="new"><?= __("New", "ninja") ?></span>
                                    <?php
                                    }
                                    ?>
                                    <h3><?= $opportunity->name ?></h3>
                                    <span class="date"><?php echo get_the_date('F jS, Y', $opportunity->ID) ?></span>
                                    <p class="short-description"><?= $opportunity->meta_data['short_description'] ?></p>
                                    <span class="status" style="display: none;"><?php print_r($opportunity); ?></span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php //if(!empty($favorite_opportunities)){ 
                        ?>
                        <div class="tab-pane fade" id="nav-fav-opportunity" role="tabpanel" aria-labelledby="nav-fav-opportunity-tab">
                            <p>No Favorites</p>
                        </div>
                    <?php } ?>
                    </div>
                <?php }  ?>
        </section>
    </div>
</main><!-- #main -->

<?php get_footer();
