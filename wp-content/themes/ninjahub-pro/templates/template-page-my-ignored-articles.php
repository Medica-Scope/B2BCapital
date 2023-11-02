<?php

/**
 * @Filename: template-my-ignored-articles.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 21/2/2023
 *
 * Template Name: My Ignored Articles Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account');

global $user_ID;
$Blog_obj  = new Nh_Blog();
// $blogs    = $Blog_obj->get_profile_ignored_articles();
$ignored_articles     = [];
if(!empty($user_ID)){
$profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
$profile_obj = new Nh_Profile();
$profile     = $profile_obj->get_by_id((int)$profile_id);
    if (!is_wp_error($profile)) {
        $ignored_articles = is_array($profile->meta_data['ignored_articles']) ? $profile->meta_data['ignored_articles'] : [];
    }
}
$user_obj         = Nh_User::get_current_user();
?>

<main class="my-fav-opportunities">
    <div class="container container-xxl">
        <?php Nh_Public::breadcrumbs(); ?>

        <nav class="dashboard-submenus mt-3 mb-5">
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/main-nav', NULL, ['active_link' => 'my_favorite_article']); ?>
            <?php get_template_part('app/Views/template-parts/dashboard-submenus/articles-sub-nav', NULL, ['active_link' => 'my_ignored_article']); ?>
        </nav>
    </div>

    <section class="page-content opportunity-content">
    <div class="container-fluid">
        <div class="blogs-list row row-cols-1 row-cols-md-3 g-4">
            <?php

            $blog_obj          = new Nh_Blog();
            $paged             = 1;
            $queried_post_type = $wp_query->query;
            if(!empty($ignored_articles)){
                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                }

                $results = $blog_obj->get_all_custom(['publish'], 12, 'date', 'DESC', [], $user_ID, $paged, $ignored_articles);

                if (!empty($results) && isset($results['posts'])) {
                    /* Start the Loop */
                    foreach ($results['posts'] as $single_post) {
                        $args = [];
                        $args['fav_form'] = '';
                        $args['ignore_form'] = '';
                        if (!empty($user_ID)) {
                            $ignore_chk         = $blog_obj->is_post_in_user_ignored($single_post->ID);
                            $args['ignore_chk'] = $ignore_chk;
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
                                        'value'               => '<i class="' . $ignore_class . ' fav-star"></i>',
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
                    get_template_part('app/Views/blogs/blogs', 'empty');
                }
            }else{
                get_template_part('app/Views/blogs/blogs', 'empty');
            }
            ?>
        </div>
    </div>
    </section>
</main><!-- #main -->

<?php get_footer();
