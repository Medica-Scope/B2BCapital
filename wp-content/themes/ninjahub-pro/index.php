<?php

    /**
     * @Filename: index.php
     * @Description: Blog Page
     * @User: Ahmed Gamal
     * @Date: 26/9/2023
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();

    global $wp_query, $post, $user_ID;
?>

    <main id="" class="">

        <?php Nh_Public::breadcrumbs(); ?>

        <h1 class="page-title"><?= __("Blogs", "ninja") ?></h1>

        <div class="blogs-list">
            <?php

                $blog_obj         = new Nh_Blog();
                $paged            = 1;
                $fav_articles     = [];
                $ignored_articles = [];
                $queried_post_type = $wp_query->query;

                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                }

                if ($user_ID) {
                    $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                    $profile_obj = new Nh_Profile();
                    $profile     = $profile_obj->get_by_id((int)$profile_id);
                    // $fav_articles = $profile->meta_data['favorite_articles'];
                    if (!is_wp_error($profile)) {
                        $ignored_articles = ($profile->meta_data['ignored_articles']) ? $profile->meta_data['ignored_articles'] : [];
                    }
                }

                $query = $blog_obj->get_all([ 'publish' ], 12, 'date', 'DESC', $ignored_articles, $user_ID, $paged);
                if ($query['posts']) { ?>

                    <?php
                    /* Start the Loop */
                    foreach ($query['posts'] as $single_post) {
                        $post_obj        = new Nh_Blog();
                        $opportunity_obj = new Nh_Opportunity();
                        $opportunity     = "";
                        $args            = [];
                        $args['post']    = $single_post;
                        if (($single_post->meta_data['opportunity'])) {
                            $opportunity         = $opportunity_obj->get_by_id($single_post->meta_data['opportunity']);
                            $args['opportunity'] = $opportunity;
                        }

                        if ($user_ID) {
                            $fav_chk            = $post_obj->is_post_in_user_favorites($single_post->ID, $user_ID);
                            $ignore_chk         = $post_obj->is_post_in_user_ignored_articles($single_post->ID, $user_ID);
                            $args['fav_chk']    = $fav_chk;
                            $args['ignore_chk'] = $ignore_chk;
                        }
                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part('app/Views/blogs', NULL, $args);

                    }

                    ?>
                    <div class="pagination-con">
                        <?php
                            echo $query['pagination'];
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
        </div>

    </main><!-- #main -->

<?php
    get_footer();