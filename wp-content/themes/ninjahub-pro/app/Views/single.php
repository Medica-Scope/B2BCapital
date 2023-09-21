<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
global $post;
$single = new Nh_Blog();
$single = $single->convert($post);
?>
<div class="single-blog">
    <div class="cover-image">
        <img src="<?= $single->thumbnail ?>" alt="B2B" />
    </div>
    <div class="date">
        <p><?= date('F d, Y', strtotime($single->created_date)); ?></p>
    </div>
    <div class="content">
        <?= $single->content ?>
    </div>
</div>

</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
