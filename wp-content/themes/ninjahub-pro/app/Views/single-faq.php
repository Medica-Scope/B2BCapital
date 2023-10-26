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


global $post;
$single = new Nh_Faq();
$single = $single->convert( $post );
?>
<section class="page-content">

	<?php Nh_Public::breadcrumbs(); ?>

	<h1 class="page-title mb-4">
		<?= $single->title ?>
	</h1>
	<div class="">
		<?= $single->content ?>
	</div>


</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
