<?php

/**
 * @Filename: single-service.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-single-faq', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-faq' );


global $post;
$single = new Nh_Faq();
$single = $single->convert( $post );
?>
<div class="single-faq container container-xxl">
	<?php Nh_Public::breadcrumbs(); ?>

	<section class="page-content bg-white shadow">
		<h1 class="page-title mb-4">
			<?= $single->title ?>
		</h1>
		<div class="">
			<?= $single->content ?>
		</div>
	</section>
</div>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
