<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-dashboard', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/home-dashboard' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-blogs', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/blogs' );

global $user_ID, $post;
$post_obj        = new Nh_Blog();
$opportunity_obj = new Nh_Opportunity();
$single_post     = $post_obj->convert( $post );
$opportunity     = "";
$fav_chk         = false;
$ignore_chk      = false;
$fav_class       = '';
$ignore_class    = '';
$fav_text        = '';
$ignore_text     = '';
if ( ( $single_post->meta_data['opportunity'] ) ) {
	$opportunity = $opportunity_obj->get_by_id( $single_post->meta_data['opportunity'] );
}
$fav_class = 'bbc-star-o';
if ( $user_ID ) {
	$fav_chk = $post_obj->is_post_in_user_favorites( $single_post->ID );
	if ( $fav_chk ) {
		$fav_class = 'bbc-star text-success';
		$fav_text  = __( 'Unfavored', 'ninja' );
	} else {
		$fav_class = 'bbc-star-o text-danger';
		$fav_text  = __( 'Favorite', 'ninja' );
	}
	$ignore_chk = $post_obj->is_post_in_user_ignored( $single_post->ID );
	if ( $ignore_chk ) {
		$ignore_class = 'controll-icon bbc-thumbs-up text-success';
		$ignore_text  = __( 'Ignored', 'ninja' );

	} else {
		$ignore_class = 'controll-icon bbc-thumbs-down text-danger';
		$ignore_text  = __( 'Ignore', 'ninja' );
	}
}
?>
<div class="single-blog container container-xxl">
	<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'blogs' ) ) ) ?>"
		class="btn btn-light text-uppercase mb-2"><i class="bbc-chevron-left"></i>
		<?= __( 'back', 'ninja' ); ?>
	</a>

	<div class="blog-content bg-white">
		<div class="cover-image position-relative bg-primary bg-gradient">
			<h3>
				<?= $single_post->title; ?>
			</h3>
			<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/blog-item-repeat-bg.webp');" />
		</div>
		<div class="container-md content-container">
			<div class="date">
				<img src="<?= get_avatar_url( $single_post->author ) ?>" alt="B2B" />
				<small class="text-muted mr-auto">
					<?= __( 'on', 'ninja' ) ?>
					<?= date( 'F d, Y', strtotime( $single_post->created_date ) ) ?>
				</small>

				<?php if ( ! empty( $user_ID ) ) :
					echo Nh_Forms::get_instance()
						->create_form( [
							'post_id'                   => [
								'type'   => 'hidden',
								'name'   => 'post_id',
								'before' => '',
								'after'  => '',
								'value'  => $single_post->ID,
								'order'  => 0
							],
							'add_to_fav_nonce'          => [
								'class' => '',
								'type'  => 'nonce',
								'name'  => 'add_to_fav_nonce_nonce',
								'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
								'order' => 5
							],
							'submit_add_to_fav_request' => [
								'class'               => 'btn-light bg-white article-to-favorite ninja-add-to-fav ms-4 me-2',
								'id'                  => 'submit_add_to_fav_request',
								'type'                => 'submit',
								'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
								'recaptcha_form_name' => 'frontend_add_to_fav',
								'order'               => 10
							],
						], [
							'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
						] );
					echo Nh_Forms::get_instance()
						->create_form( [
							'post_id'              => [
								'type'   => 'hidden',
								'name'   => 'post_id',
								'before' => '',
								'after'  => '',
								'value'  => $single_post->ID,
								'order'  => 0
							],
							'ignore_article_nonce' => [
								'class' => '',
								'type'  => 'nonce',
								'name'  => 'ignore_article_nonce',
								'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
								'order' => 5
							],
							'submit_ignore'        => [
								'class'               => 'btn-light bg-white',
								'id'                  => 'submit_submit_ignore',
								'type'                => 'submit',
								'value'               => '<i class="' . $ignore_class . ' ignore-star"></i>',
								'recaptcha_form_name' => 'frontend_ignore',
								'order'               => 10
							],
						], [
							'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
						] );
				endif; ?>
			</div>

			<?php if ( ! empty( $opportunity ) ) : ?>
			<div class="opportunity">
				<a href="<?= $opportunity->link ?>">
					<?= $opportunity->name; ?>
				</a>
			</div>
			<div class="opportunity-short-description">
				<p>
					<?= $opportunity->meta_data['short_description']; ?>
				</p>
			</div>
			<?php endif; ?>

			<div class="content d-flex flex-column">
				<?= $single_post->content ?>
			</div>

			<div class="tags">
				<p class="tags-title">
					<?= __( 'Tags:', 'ninja' ) ?>
				</p>
				<div class="tags-items">
					<span>buyes, </span>
					<span>exists, </span>
					<span>investors, </span>
					<span>startups</span>
				</div>
			</div>

			<!-- <div class="related slick-slider">
		<h3>
		</h3>
		<?php
		/* $related = $post_obj->get_all_custom( [ 'publish' ], 10, 'rand', 'ASC', [ $single_post->ID ] );
																																if ( ! empty( $related ) ) {
																																	foreach ( $related['posts'] as $single_related ) { */
		?>
		<div class="related-card">
			<a class="blog-item" href="<?php /* echo  $single_related->link */?>">
				<div class="img">
					<img src="<?php /* echo  $single_related->thumbnail */?>" alt="B2B" />
					<span class="dots"></span>
				</div>
				<div class="date">
					<p>
						<?php /* echo  date( 'F d, Y', strtotime( $single_related->created_date ) ) */?>
					</p>
				</div>
				<div class="content">
					<?php /* echo  $single_related->excerpt */?>
				</div>
			</a>
		</div>
		<?php
		/*}
																															 } */
		?>
	</div> -->
		</div>
	</div>
</div>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_footer();
