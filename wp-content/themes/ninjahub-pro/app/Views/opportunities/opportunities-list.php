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
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

global $wp_query, $post, $user_ID;

$blog_obj          = new Nh_Blog();
$paged             = 1;
$fav_articles      = [];
$ignored_articles  = [];
$queried_post_type = $wp_query->query;

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
}
$results = $blog_obj->get_all_custom(['publish'], 12, 'date', 'DESC', $ignored_articles, $user_ID, $paged);
if ($results['posts']) { ?>

    <?php
    /* Start the Loop */
    foreach ($results['posts'] as $single_post) {
        $args = [];
        $args['fav_form'] = '';
        $args['ignore_form'] = '';
        if (!empty($user_ID)) {
            $fav_chk            = $blog_obj->is_post_in_user_favorites($single_post->ID);
            $ignore_chk         = $blog_obj->is_post_in_user_ignored($single_post->ID);
            $args['fav_chk']    = $fav_chk;
            $args['ignore_chk'] = $ignore_chk;
            if ($fav_chk) {
                $fav_class = 'bbc-star';
            } else {
                $fav_class = 'bbc-star-o';
            }
            $args['fav_form'] = Nh_Forms::get_instance()
                ->create_form([
                    'post_id'                   => [
                        'type'   => 'hidden',
                        'name'   => 'post_id',
                        'before' => '',
                        'after'  => '',
                        'value'  => $single_post->ID,
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
                $ignore_class = 'bbc-star';
            } else {
                $ignore_class = 'bbc-star-o';
            }
            $args['ignore_form'] = Nh_Forms::get_instance()
                ->create_form([
                    'post_id'              => [
                        'type'   => 'hidden',
                        'name'   => 'post_id',
                        'before' => '',
                        'after'  => '',
                        'value'  => $single_post->ID,
                        'order'  => 0
                    ],
                    'ignore_article_nonce' => [
                        'class' => '',
                        'type'  => 'nonce',
                        'name'  => 'ignore_article_nonce',
                        'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
                        'order' => 5
                    ],
                    'submit_ignore'        => [
                        'class'               => 'btn',
                        'id'                  => 'submit_submit_ignore',
                        'type'                => 'submit',
                        'value'               => '<i class="' . $ignore_class . ' ignore-star"></i>',
                        'recaptcha_form_name' => 'frontend_ignore',
                        'order'               => 10
                    ],
                ], [
                    'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
                ]);
        }
        $args['post'] = $single_post;
        /*
             * Include the Post-Type-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
             */
        get_template_part('app/Views/blogs/blogs-item', NULL, $args);
    }

    ?>
    <div class="pagination-con">
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

<?php

global $user_ID;
$opportunity_obj = new Nh_Opportunity();
$profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
$profile_obj = new Nh_Profile();
$profile     = $profile_obj->get_by_id((int)$profile_id);
$favorites = [];
$opportunities = [];



            if (!is_wp_error($profile)) {
                $favorite_opportunities = ($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
                $ignored_opportunities = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
                $not_in = array_merge($favorite_opportunities, $ignored_opportunities);
                $opportunities = $opportunity_obj->get_all_custom(['publish'], -1, 'date', 'DESC', $favorite_opportunities, [], $user_ID);
                if (!empty($opportunities) && isset($opportunities['posts'])) {
            ?>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-opportunity-tab" data-bs-toggle="pill" data-bs-target="#my-opportunity" type="button" role="tab" aria-controls="my-opportunity" aria-selected="true"><?= __("My Opportunities", "ninja") ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fav-opportunity-tab" data-bs-toggle="pill" data-bs-target="#fav-opportunity" type="button" role="tab" aria-controls="fav-opportunity" aria-selected="false"><?= __("My Favorite Opportunities", "ninja") ?></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="my-opportunity" role="tabpanel" aria-labelledby="my-opportunity-tab" tabindex="0">
                            <?php
                            foreach ($opportunities['posts'] as $opportunity) {

                                $args = [];
                                $args['fav_form'] = '';
                                $args['ignore_form'] = '';
                                $args['date'] = get_the_date('Y-m-d', $opportunity->ID);
                                if (!empty($user_ID)) {
                                    $fav_chk            = $opportunity_obj->is_opportunity_in_user_favorites($opportunity->ID);
                                    $ignore_chk         = $opportunity_obj->is_opportunity_in_user_ignored($opportunity->ID);
                                    $args['fav_chk']    = $fav_chk;
                                    $args['ignore_chk'] = $ignore_chk;
                                    if ($fav_chk) {
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
                                    if ($ignore_chk) {
                                        $ignore_class = 'bbc-star';
                                    } else {
                                        $ignore_class = 'bbc-star-o';
                                    }
                                    $args['ignore_form'] = Nh_Forms::get_instance()
                                    ->create_form([
                                        'opp_id'              => [
                                            'type'   => 'hidden',
                                            'name'   => 'opp_id',
                                            'before' => '',
                                            'after'  => '',
                                            'value'  => $opportunity_id,
                                            'order'  => 0
                                        ],
                                        'ignore_opportunity_nonce' => [
                                            'class' => '',
                                            'type'  => 'nonce',
                                            'name'  => 'ignore_opportunity_nonce',
                                            'value' => Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form",
                                            'order' => 5
                                        ],
                                        'submit_ignore'        => [
                                            'class'               => 'btn',
                                            'id'                  => 'submit_submit_ignore',
                                            'type'                => 'submit',
                                            'value'               => '<i class="bbc-star-o fav-star"></i>',
                                            'recaptcha_form_name' => 'frontend_ignore',
                                            'order'               => 10
                                        ],
                                    ], [
                                        'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
                                    ]);
                                }
                                $args['opportunity'] = $opportunity;
                                /*
                                     * Include the Post-Type-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                     */
                                get_template_part('app/Views/opportunities/opportunity-item', NULL, $args);
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="fav-opportunity" role="tabpanel" aria-labelledby="fav-opportunity-tab" tabindex="0">
                            <?php
                            if (!empty($favorite_opportunities)) {
                                foreach ($favorite_opportunities as $fav_opportunity_id) {
                                    $obj = new Nh_Opportunity();
                                    $favorite_opportunity = $obj->get_by_id((int) $fav_opportunity_id);
                                    if ($favorite_opportunity) {
                                        $favorite_opportunity_date = get_the_date('Y-m-d', $favorite_opportunity->ID);
                            
                            ?>
                                        <div class="opportunity-card">
                                            <?php
                                            if ($favorite_opportunity_date >= date('Y-m-d', strtotime('-20 days'))) {
                                            ?>
                                                <span class="new"><?= __("New", "ninja") ?></span>
                                            <?php } ?>
                                            <h3><?= $favorite_opportunity->name ?></h3>
                                            <span class="date"><?php echo get_the_date('F jS, Y', $favorite_opportunity->ID) ?></span>
                                            <p class="short-description"><?= $favorite_opportunity->meta_data['short_description'] ?></p>
                                            <span class="status"><?= $favorite_opportunity->status ?></span>
                                        </div>
                                <?php
                                    }
                                }
                            } else { ?>
                                <p><?= __("No Favorites", "ninja") ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php }  ?>