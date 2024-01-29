<?php

/**
 * @Filename: blogs-list.php
 * @Description: Blogs list page
 * @User: Ahmed Gamal
 * @Date: 30/9/2023
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

global $wp_query, $post, $user_ID;

$opportunity_obj          = new Nh_Opportunity();
$paged             = 1;
$favorite_opportunities      = [];
$ignored_opportunities  = [];
$queried_post_type = $wp_query->query;

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
}
if (!empty($user_ID)) {
    $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
    $profile_obj = new Nh_Profile();
    $profile     = $profile_obj->get_by_id((int)$profile_id);
    if (!is_wp_error($profile)) {
        $ignored_opportunities = is_array($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
        $favorite_opportunities = is_array($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
    }
}
$current_page = 'dashboard';

if (preg_match('#my-favorite-opportunities#', $wp->request)) {
    $current_page = 'my-favorite-opportunities';
    $results = $opportunity_obj->get_all_custom(['publish'], 12, 'date', 'DESC', [], [], $user_ID, $paged, $favorite_opportunities);
} elseif (preg_match('#my-ignored-opportunities#', $wp->request)) {
    $current_page = 'my-ignored-opportunities';
    $results = $opportunity_obj->get_all_custom(['publish'], 12, 'date', 'DESC', [], [], $user_ID, $paged, $ignored_opportunities);
} else {
    $current_page = 'dashboard';
    $results = $opportunity_obj->get_all_custom(['publish'], 12, 'date', 'DESC', $ignored_opportunities, [], $user_ID, $paged, []);
}
if ($results['posts']) { ?>

    <?php
    /* Start the Loop */
    foreach ($results['posts'] as $opportunity) {
        $args = [];
        $args['fav_form'] = '';
        $args['ignore_form'] = '';
        if (!empty($user_ID)) {
            $fav_chk            = $opportunity_obj->is_opportunity_in_user_favorites($opportunity->ID);
            $ignore_chk         = $opportunity_obj->is_opportunity_in_user_ignored($opportunity->ID);
            if ($fav_chk) {
                $fav_class = 'bbc-bookmark fav-star';
            } else {
                $fav_class = 'bbc-bookmark-o fav-star';
            }
            $args['fav_form'] = Nh_Forms::get_instance()
                ->create_form([
                    'opp_id'                   => [
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
                        'value' => Nh::_DOMAIN_NAME . '_add_to_fav_nonce_form',
                        'order' => 5
                    ],
                    'submit_add_to_fav_request' => [
                        'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
                        'id'                  => 'submit_add_to_fav_request',
                        'type'                => 'submit',
                        'value'               => '<i class=' . $fav_class . ' ignore-star></i>',
                        'recaptcha_form_name' => 'frontend_add_to_fav',
                        'order'               => 10
                    ],
                ], [
                    'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                ]);
            if ($ignore_chk) {
                $ignore_class = 'controll-icon bbc-thumbs-up text-success ignore-star';
            } else {
                $ignore_class = 'controll-icon bbc-thumbs-down text-success ignore-star';
            }
            $args['ignore_form'] = Nh_Forms::get_instance()
                ->create_form([
                    'opp_id'              => [
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
                        'value' => Nh::_DOMAIN_NAME . '_ignore_opportunity_nonce_form',
                        'order' => 5
                    ],
                    'submit_ignore'        => [
                        'class'               => 'btn',
                        'id'                  => 'submit_submit_ignore',
                        'type'                => 'submit',
                        'value'               => '<i class=' . $ignore_class . ' ignore-star></i>',
                        'recaptcha_form_name' => 'frontend_ignore',
                        'order'               => 10
                    ],
                ], [
                    'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
                ]);
        }
        $args['opportunity'] = $opportunity;

        $args['current_page'] = $current_page;
        /*
             * Include the Post-Type-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
             */
            ?>
            <div class="col">
                <?php get_template_part('app/Views/opportunities/opportunity-item', NULL, $args); ?>
            </div>
    <?php
    }
    ?>
    <div class='pagination-con'>
        <?php
        echo $results['pagination'];
        ?>
    </div>
<?php

} else {
    if (empty(locate_template('app/Views/none-' . $queried_post_type['post_type'] . '.php'))) {
        get_template_part('app/Views/none');
    } else {
        get_template_part('app/Views/none', $queried_post_type['post_type']);
    }
}
?>


