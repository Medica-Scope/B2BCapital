<?php
    /**
     * The main template file
     *
     * This is the most generic template file in a WordPress theme
     * and one of the two required files for a theme (the other being style.css).
     * It is used to display a page when nothing more specific matches a query.
     * E.g., it puts together the home page when no home.php file exists.
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package NinjaHub
     */

    get_header();
    global $wp_query;
?>

    <main id="" class="">

        <?php
            if (have_posts()) :

                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('app/Views/blogs');

                endwhile;
                ?>
                <div class="pagination-con">
                <?php
                $big = 999999999;
                echo paginate_links( array(
                    'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'  => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total'   => $wp_query->max_num_pages,
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                ) );
                // the_posts_navigation();
                ?>
                </div>
                <?php
            else :

                get_template_part('app/Views/none');

            endif;
        ?>

    </main><!-- #main -->

<?php
    get_sidebar();
    get_footer();
