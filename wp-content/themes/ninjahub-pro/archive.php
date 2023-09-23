<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NinjaHub
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();
Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');

global $wp_query;
$queried_post_type = $wp_query->query;
$nh_faq = new Nh_Faq();
?>

<main id="" class="">
<?php global $post; ?>
    <ul class="breadcrumbs">
        <li><a href="<?= home_url() ?>"><?= _e("Home", "ninja") ?></a></li>
        <?php
        $post_type = get_post_type();

        if (is_archive() && $post_type == 'faq') {
        ?>
            <li>&raquo;</li>
            <li><span class="page-title"><?= _e("FAQs", "ninja") ?></span></li>
        <?php } elseif (is_archive() && $post_type == 'post') {
        ?>
            <li>&raquo;</li>
            <li><span class="page-title"><?= _e("Blogs", "ninja") ?></span></li>
        <?php } ?>
    </ul>
    <h1 class="page-title"><?= _e("FAQs", "ninja") ?></h1>
    <?php if (have_posts()) : ?>

        <?php
        /* Start the Loop */
        while (have_posts()) :
            the_post();

            /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
            if (empty(locate_template('app/Views/archive-' . get_post_type() . '.php'))) {
                get_template_part('app/Views/archive');
            } else {
                get_template_part('app/Views/archive', get_post_type());
            }

        endwhile;


        ?>
        <div class="pagination-con">
            <?php
            $big = 999999999;
            echo paginate_links(array(
                'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'  => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total'   => $wp_query->max_num_pages,
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
            ));
            // the_posts_navigation();
            ?>
        </div>
    <?php

    else :

        if (empty(locate_template('app/Views/none-' . $queried_post_type['post_type'] . '.php'))) {
            get_template_part('app/Views/none');
        } else {
            get_template_part('app/Views/none', $queried_post_type['post_type']);
        }

    endif;
    ?>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
