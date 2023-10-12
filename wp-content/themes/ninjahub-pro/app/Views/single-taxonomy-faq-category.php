<?php

/**
 * @Filename: taxonomy-faq-category.php
 * @Description: root file for single term view
 * @User: Ahmed Gamal
 * @Date: 9/10/2023
 *
 * @package NinjaHub
 * @since 1.0
 */


use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\Nh;

global $post, $taxonomy;
$term = get_queried_object();

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-about-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/about');
$faqs_obj = new Nh_Faq();
$faqs = $faqs_obj->get_all(['publish'], -1, 'menu_order', 'ASC', [], ['taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $term->slug]);
?>
<!-- Page Content -->
<section class="page-content">

    <h1><?= $term->name ?></h1>
    <div class="container">
        <?php
        if (!empty($faqs)) {
            foreach ($faqs as $single) {
        ?>
                <div class="accordion accordion-flush" id="accordionFlush">
                    <div class="accordion-item" data-id="<?= $single->ID ?>">

                        <div class="accordion-header" id="flush-heading<?= $single->ID ?>">
                            <h3 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush<?= $single->ID ?>" aria-expanded="false" aria-controls="flush<?= $single->ID ?>">
                                <?= $single->title ?>
                            </h3>
                        </div>
                        <div id="flush<?= $single->ID ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $single->ID ?>" data-bs-parent="#accordionFlush">
                            <div class="accordion-body"><?= $single->content ?></div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php
get_footer();
