<?php
    /**
     * The template for displaying search results pages
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
     *
     * @package b2b
     */

    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="">


        <header class="page-header">

            <?= B2b_Forms::get_instance()
                         ->create_form([
                             'search' => [
                                 'class'       => '',
                                 'type'        => 'text',
                                 'name'        => 's',
                                 'placeholder' => __('Search', 'b2b'),
                                 'before'      => '',
                                 'after'       => '<i class="fas fa-search"></i>',
                                 'order'       => 0,
                             ]
                         ], [
                             'action' => apply_filters('b2bml_permalink', home_url()),
                             'class'  => B2b::_DOMAIN_NAME . '-search-form',
                             'id'     => B2b::_DOMAIN_NAME . '_search_form'
                         ]); ?>

            <h1 class="page-title">
                <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Search Results for: %s', 'b2b'), '<span>' . get_search_query() . '</span>');
                ?>
            </h1>
        </header><!-- .page-header -->

        <?php
            if (have_posts()) :

                /* Start the Loop */
                while (have_posts()) :

                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('app/Views/search');

                endwhile;

                the_posts_navigation();

            else :

                get_template_part('app/Views/none', 'search');

            endif;
        ?>

    </main><!-- #main -->

<?php
    get_footer();
