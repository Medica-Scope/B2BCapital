<?php global $queried_post_type;

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

    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;

    global $wp_query, $post, $user_ID;

    $blog_obj         = new Nh_Blog();
    $paged            = 1;
    $fav_articles     = [];
    $ignored_articles = [];

    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    }
    if ($user_ID) {
        $profile_obj = new Nh_Profile();
        $profile     = $profile_obj->get_by_id($user_ID);
        // $fav_articles = $profile->meta_data['favorite_articles'];
        $ignored_articles = empty($profile->meta_data['ignored_articles']) ? [] : $profile->meta_data['ignored_articles'];
    }
    $query = $blog_obj->get_all([ 'publish' ], 12, 'date', 'DESC', $ignored_articles, $user_ID, $paged);
    if ($query['posts']): ?>

        <?php
        /* Start the Loop */
        foreach ($query['posts'] as $single_post):
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

        endforeach;

        ?>
        <div class="pagination-con">
            <?php
                echo $query['pagination'];
                // the_posts_navigation();
            ?>
        </div>
    <?php

    else:

        if (empty(locate_template('app/Views/none-' . $queried_post_type['post_type'] . '.php'))) {
            get_template_part('app/Views/none');
        } else {
            get_template_part('app/Views/none', $queried_post_type['post_type']);
        }

    endif;
?>