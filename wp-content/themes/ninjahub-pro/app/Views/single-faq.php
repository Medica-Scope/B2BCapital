<?php

/**
 * @Filename: single-service.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
global $post;
$single = new Nh_Faq();
$single = $single->convert($post);
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

</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
