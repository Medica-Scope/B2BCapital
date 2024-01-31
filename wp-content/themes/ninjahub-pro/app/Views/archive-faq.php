<?php

/**
 * @Filename: archive-faq.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\CLASSES\Nh_Post;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\APP\MODELS\FRONT\MODULES\Nh_Faq;
use NH\Nh;

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-archive-faq', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/archive-faq' );

global $wp_query, $post;
$queried_post_type = $wp_query->query;
$post_obj          = new Nh_Post();
$single_post       = $post_obj->convert( $post );
?>

<div class="row p-0 mb-4">
	<div class="col-md-8">
		<a href="<?= esc_url( home_url() ); ?>" class="btn btn-light text-uppercase mb-2 mt-2"><i
				class="bbc-chevron-left"></i>
			<?= __( 'back', 'ninja' ); ?>
		</a>
		<h1 class="page-title mb-4 fw-bold">
			<?= __( "Frequently asked questions", "ninja" ); ?>
		</h1>
		<p class="count">
			<?php printf( __( 'There are %d articles in our base.', 'ninja' ), $wp_query->found_posts ); ?>
		</p>
	</div>
	<div class="search-form search-con col-md-4">
		<?= Nh_Forms::get_instance()
			->create_form( [
				'search'    => [
					'class'       => 'ninja-search-input-group',
					'type'        => 'text',
					'name'        => 's_ajax',
					'placeholder' => __( 'Search', 'ninja' ),
					'before'      => '',
					'after'       => '<i class="bbc-search2 ninja-search-icon"></i>',
					'order'       => 0,
				],
				'post_type' => [
					'class'  => 'ninja-search-type',
					'type'   => 'hidden',
					'name'   => 'search_post_type',
					'before' => '',
					'after'  => '',
					'value'  => get_post_type(),
					'order'  => 0,
				]
			], [
				'action' => apply_filters( 'nhml_permalink', home_url() ),
				'class'  => Nh::_DOMAIN_NAME . '-search-form-ajax',
				'id'     => Nh::_DOMAIN_NAME . '_search_form_ajax'
			] ); ?>
		<div class="search-body">
		</div>
	</div>
</div>

<?php
if ( have_posts() ) {
	$exclude_term = get_term_by( 'slug', 'popular-questions', 'faq-category' );
	if ( is_wp_error( $exclude_term ) || empty( $exclude_term ) ) {
		$exclude_term = 0;
	} else {
		$exclude_term = $exclude_term->term_id;
	}
	$faq_categories = get_terms( [
		'taxonomy'   => 'faq-category',
		'hide_empty' => TRUE,
		'exclude'    => [ $exclude_term ]
		// TODO:: Switch to TRUE on production
	] );

	if ( $faq_categories ) {
		?>
		<div class="container-fluid">
			<div class="categories row row-cols-1 row-cols-md-4 g-4 card-group justify-content-center">
				<?php
				foreach ( $faq_categories as $cat ) {
					?>
					<a class="item col card shadow" href="<?= get_term_link( $cat ); ?>">
						<?php if ( get_field( 'image', $cat ) ) { ?>
							<img src="<?= get_field( 'image', $cat ); ?>" alt="B2B" />
						<?php } else { ?>
							<i class="bbc-info-circle" style="font-size: 34px;"></i>
						<?php } ?>
						<h6 class="mt-3">
							<?= $cat->name; ?>
						</h6>
					</a>
					<?php
				}
				?>

				<div class="item info col card">
					<i class="bbc-question-circle-o"></i>
					<h6>
						<?= __( "Can't find an answer?", "ninja" ) ?>
					</h6>
					<div class="info-con">
						<a href="mailto:" class="email shadow">
							<i class="bbc-mail1"></i>
							<h6>
								<?= __( "Email us", "ninja" ) ?>
							</h6>
						</a>
						<a href="tel:" class="call shadow">
							<i class="bbc-phone2"></i>
							<h6>
								<?= __( "Call us", "ninja" ) ?>
							</h6>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	$faqs_obj = new Nh_Faq();
	$faqs     = $faqs_obj->get_all( [ 'publish' ], 14, 'menu_order', 'ASC', [], [
		'taxonomy' => 'faq-category',
		'field'    => 'slug',
		'terms'    => 'popular-questions'
	] );
	?>

	<div class="row">
		<div class="popular-questions-section col-12 col-md-8">
			<h3>
				<i class="bbc-star-empty"></i>
				<?= __( "Popular Questions", "ninja" ) ?>
			</h3>

			<div class="items row">
				<?php
				if ( ! empty( $faqs ) ) {
					$faqs_chunk = array_chunk( $faqs, ceil( count( $faqs ) / 2 ) );
					?>
					<div class="col-12 col-md-6 items-left pe-5">
						<?php
						if ( isset( $faqs_chunk[0] ) ) {
							foreach ( $faqs_chunk[0] as $faq_item ) {
								?>
								<div class="faq-item">
									<a class="title btn btn-link text-dark" href="<?= $faq_item->link ?>">
										<?= $faq_item->title ?>
									</a>
								</div>
								<?php
							}
						}
						?>
					</div>
					<div class="col-12 col-md-6 items-right">
						<?php
						if ( isset( $faqs_chunk[1] ) ) {
							foreach ( $faqs_chunk[1] as $faq_item ) {
								?>
								<div class="faq-item">
									<a class="title btn btn-link text-dark" href="<?= $faq_item->link ?>">
										<?= $faq_item->title ?>
									</a>
								</div>
								<?php
							}
						}
						?>
					</div>
					<?php
				}
				?>
			</div>

		</div>
		<div class="col-12 col-md-4 ps-md-5">
			<?php get_template_part( 'app/Views/template-parts/useful-links' ); ?>
		</div>
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
