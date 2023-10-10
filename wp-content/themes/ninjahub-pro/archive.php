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
$nh_faq = new Nh_Faq();
?>

<main id="" class="">
    <ul class="breadcrumbs">
        <li><a href="<?= home_url() ?>"><?= _e("Home", "ninja") ?></a></li>
        <?php
        $post_type = get_post_type();

        if (is_archive() && $post_type == 'faq') {
        ?>
            <li>&raquo;</li>
            <li><span class="page-title"><?= _e("FAQs", "ninja") ?></span></li>
        <?php } ?>
    </ul>

    <a href="<?= home_url() ?>" class="back-btn"><?= _e("Back", "ninja") ?></a>

    <h1 class="page-title"><?= _e("Frequently asked questions", "ninja") ?></h1>

    <?php if (have_posts()) : ?>
        <div class="left">
            <p class="count"><?php printf(__('There are %d articles in our base.', 'ninja'), $wp_query->found_posts); ?></p>
        </div>
        <div class="right">
            <div class="search-form search-con">
                <?= Nh_Forms::get_instance()
                    ->create_form([
                        'search' => [
                            'class'       => 'ninja-search-input-group',
                            'type'        => 'text',
                            'name'        => 's',
                            'placeholder' => __('Search', 'ninja'),
                            'before'      => '',
                            'after'       => '<i class="fas fa-search ninja-search-icon"></i>',
                            'order'       => 0,
                        ],
                        'post_type' => [
                            'class'       => 'ninja-search-type',
                            'type'        => 'hidden',
                            'name'        => 'search_post_type',
                            'before'      => '',
                            'after'       => '',
                            'value'       => get_post_type(),
                            'order'       => 0,
                        ]
                    ], [
                        'action' => apply_filters('nhml_permalink', home_url()),
                        'class'  => Nh::_DOMAIN_NAME . '-search-form-ajax',
                        'id'     => Nh::_DOMAIN_NAME . '_search_form_ajax'
                    ]); ?>
                <div class="search-body"></div>
            </div>
        </div>
        <?php
        $exclude_term = get_term_by('slug', 'popular-questions', 'faq-category');
        if (is_wp_error($exclude_term) || empty($exclude_term)) {
            $exclude_term = 0;
        } else {
            $exclude_term = $exclude_term->term_id;
        }
        $faq_categories = get_terms([
            'taxonomy'   => 'faq-category',
            'hide_empty' => FALSE,
            'exclude'  => array($exclude_term)
            // TODO:: Switch to TRUE on production
        ]);
        if ($faq_categories) {
        ?>
            <div class="categories">
                <?php
                foreach ($faq_categories as $cat) {
                ?>
                    <a class="item" href="<?= get_term_link($cat); ?>">
                        <?php if (get_field('image', $cat)) : ?>
                            <img src="<?= get_field('image', $cat); ?>" alt="B2B" />
                        <?php endif; ?>
                        <h3><?= $cat->name; ?></h3>
                    </a>
                <?php } ?>
                <div class="item info">
                    <img src="<?= Nh_Hooks::PATHS['public']['img'] ?>/icons8-info-100.webp" alt="B2B" />
                    <span><?= _e("Can't find an answer?", "ninja") ?></span>
                    <div class="info-con">
                        <a href="mailto:" class="email">
                            <img src="<?= Nh_Hooks::PATHS['public']['img'] ?>/icons8-email-100.webp" alt="B2B" />
                            <span><?= _e("Email us", "ninja") ?></span>
                        </a>
                        <a href="tel:" class="call">
                            <img src="<?= Nh_Hooks::PATHS['public']['img'] ?>/icons8-call-100.webp" alt="B2B" />
                            <span><?= _e("Call us", "ninja") ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        $faqs_obj = new Nh_Faq();
        $faqs = $faqs_obj->get_all(['publish'], 14, 'menu_order', 'ASC', [], ['taxonomy' => 'faq-category', 'field' => 'slug', 'terms' => 'popular-questions']);
        ?>
        <div class="popular-questions-section">
            <h2><?= _e("Popular Questions", "ninja") ?></h2>
            <?php if (!empty($faqs)) : foreach ($faqs as $single) : ?>
                    <div class="faq-item">
                        <a class="title" href="<?= $single->link ?>"><?= $single->title ?></a>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>

        <?= get_template_part('app/Views/template-parts/useful-links') ?>
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
