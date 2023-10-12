<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Mustafa Shaaban
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

global $post;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-single-opportunity', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-opportunity' );
?>

<main class="container">
	<button class="btn btn-secondary text-uppercase mb-2"><i class="bbc-chevron-left"></i>
		<?= __( 'back', 'ninja' ); ?>
	</button>
	<h3 class="mb-4">
		<?= __( 'General Information', 'ninja' ); ?>
	</h3>

	<h3 class="text-warning">
		<?= __( 'Business Type', 'ninja' ); ?>
	</h3>

	<p>SaaS</p>
	<div class="row row-cols-1 row-cols-md-2"></div>

	<div class="related-opportunities">
		<h3>
			<?= __( 'Related Opportunities', 'ninja' ); ?>
		</h3>
		<?php get_template_part( 'app/Views/template-parts/related-opportunities-slider', null,
			[] ); ?>
	</div>
</main><!-- #main -->

<?php
get_footer();
