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
// print_r($single);
// echo $single->meta_data['cover'];
?>

</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
