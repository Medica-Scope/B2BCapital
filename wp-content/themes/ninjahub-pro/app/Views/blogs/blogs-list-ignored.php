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
if(!empty($user_ID)){
    $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
    $profile_obj = new Nh_Profile();
    $profile     = $profile_obj->get_by_id((int)$profile_id);
    if (!is_wp_error($profile)) {
        $ignored_articles = is_array($profile->meta_data['ignored_articles']) ? $profile->meta_data['ignored_articles'] : [];
    }
}
$results = $blog_obj->get_all_custom(['publish'], 12, 'date', 'DESC', [], $user_ID, $paged, $ignored_articles);
if ($results['posts'] && !empty($ignored_articles)) { ?>

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