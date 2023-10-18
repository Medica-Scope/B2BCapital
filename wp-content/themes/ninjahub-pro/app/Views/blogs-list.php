<?php

/**
 * @Filename: blogs-list.php
 * @Description: Blogs list page
 * @User: Ahmed Gamal
 * @Date: 30/9/2023
 *
 * @package NinjaHub
 * @since 1.0
 *
 */

use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;

global $wp_query, $post, $user_ID;

$blog_obj         = new Nh_Blog();
$paged            = 1;
$fav_articles     = [];
$ignored_articles = [];

if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
}

$results = $blog_obj->get_all_custom( [ 'publish' ], 12, 'date', 'DESC', $ignored_articles, $user_ID, $paged );
if ( $results['posts'] ) { ?>

<?php
	/* Start the Loop */
	foreach ( $results['posts'] as $single_post ) {
		$args         = [];
		$args['post'] = $single_post;
		/*
		 * Include the Post-Type-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		 */
		get_template_part( 'app/Views/blogs', NULL, $args );
	}

	?>
<div class="pagination-con">
	<?php
		echo $results['pagination'];
		?>
</div>
<?php

} else {

	if ( empty( locate_template( 'app/Views/none-' . $queried_post_type['post_type'] . '.php' ) ) ) {
		get_template_part( 'app/Views/none' );
	} else {
		get_template_part( 'app/Views/none', $queried_post_type['post_type'] );
	}
}
?>
