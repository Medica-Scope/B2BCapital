<?php

    /**
     * The template for displaying archive pages
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package NinjaHub
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;

    get_header();
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');

    global $wp_query, $post;
    $queried_post_type = $wp_query->query;
?>

    <main id="" class="">
        <?php
            if ($queried_post_type['post_type'] !== 'service') {
                Nh_Public::breadcrumbs();
            }

            if (empty(locate_template('app/Views/archive-' . get_post_type() . '.php'))) {
                get_template_part('app/Views/archive');
            } else {
                get_template_part('app/Views/archive', get_post_type());
            }

        ?>
        <?php
            //         if (have_posts() && $queried_post_type['post_type'] !== 'faq') :

            /* Start the Loop */
            //            while (have_posts()) :
            //                the_post();
            //
            //                /*
            //                     * Include the Post-Type-specific template for the content.
            //                     * If you want to override this in a child theme, then include a file
            //                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
            //                     */
//                            if (empty(locate_template('app/Views/archive-' . get_post_type() . '.php'))) {
//                                get_template_part('app/Views/archive');
//                            } else {
//                                get_template_part('app/Views/archive', get_post_type());
//                            }
            //
            //            endwhile;
            //        endif;
        ?>

    </main><!-- #main -->

<?php
    // get_sidebar();
    get_footer();
