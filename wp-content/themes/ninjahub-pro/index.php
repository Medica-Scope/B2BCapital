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
    use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-dashboard', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/home-dashboard');


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
                $queried_post_type = $wp_query->query;
                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                }

                $results = $blog_obj->get_all_custom([ 'publish' ], 12, 'date', 'DESC', [], $user_ID, $paged);
                if (!empty($results) && isset($results['posts'])) { 
                    /* Start the Loop */
                    foreach ($results['posts'] as $single_post) {
                        $args            = [];
                        $args['post'] = $single_post;
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
                            echo $results['pagination'];
                        ?>
                    </div>
                    <?php

                } else {

                        get_template_part('app/Views/none');

                }

            ?>
        </div>

    </main><!-- #main -->

<?php
    get_footer();