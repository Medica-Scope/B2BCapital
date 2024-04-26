<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package NinjaHub
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\Nh;

get_header();

?>
<style>
	.search-result-page #ninja_s {
		padding-inline-start: 2.5rem !important;
	}

	.search-result-page .ninja-header-search-icon {
		position: absolute;
		top: 50%;
		left: 1rem;
		font-weight: bold;
		transform: translateY(-50%);
	}
</style>
<div class="search-result-page container container-xxl">
	<header class="page-header">

		<?= Nh_Forms::get_instance()
			->create_form( [
				'search' => [
					'class'       => 'mb-4 p-0 ninja-s position-relative shadow radius',
					'type'        => 'text',
					'name'        => 's',
					'placeholder' => __( 'Search', 'ninja' ),
					'before'      => '',
					'after'       => '<i class="bbc-search2 ninja-header-search-icon"></i>',
					'order'       => 0,
				]
			], [
				'action' => apply_filters( 'nhml_permalink', home_url() ),
				'class'  => Nh::_DOMAIN_NAME . '-search-form',
				'id'     => Nh::_DOMAIN_NAME . '_search_form'
			] ); ?>

		<h1 class="page-title mb-5">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'ninja' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header><!-- .page-header -->

	<?php
	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) :

			the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			?>
			<div class="row">
				<div class="col-12">
					<?php get_template_part( 'app/Views/search' ); ?>
				</div>
			</div>
			<?php
		endwhile;

		the_posts_navigation();

	else :

		get_template_part( 'app/Views/none', 'search' );

	endif;
	?>
</div>
<?php
get_footer();
