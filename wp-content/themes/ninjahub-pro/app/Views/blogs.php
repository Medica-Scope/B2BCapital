<?php

/**
 * @Filename: blogs.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\Nh;

global $wp_query, $post, $user_ID;
$post_obj        = new Nh_Blog();
$opportunity_obj = new Nh_Opportunity();
$opportunity     = "";
$single_post     = $args['post'];

if ( ( $single_post->meta_data['opportunity'] ) ) {
	$opportunity         = $opportunity_obj->get_by_id( $single_post->meta_data['opportunity'] );
	$args['opportunity'] = $opportunity;
}

if ( $user_ID ) {
	$fav_chk            = $post_obj->is_post_in_user_favorites( $single_post->ID );
	$ignore_chk         = $post_obj->is_post_in_user_ignored( $single_post->ID );
	$args['fav_chk']    = $fav_chk;
	$args['ignore_chk'] = $ignore_chk;
}
$fav_chk     = ( isset( $args['fav_chk'] ) ) ? $args['fav_chk'] : '';
$ignore_chk  = ( isset( $args['ignore_chk'] ) ) ? $args['ignore_chk'] : '';
$opportunity = ( isset( $args['opportunity'] ) ) ? $args['opportunity'] : '';
?>
<div class="col">
	<div class="blog-item card shadow">
		<a href="<?= $single_post->link ?>" class="card-image-top position-relative bg-primary bg-gradient">
			<h3>
				<?= $single_post->title; ?>
			</h3>

			<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/blog-item-repeat-bg.webp');" />
			<div class="opportunity-item-controllers">
				<?php
				// if ( ! empty( $user_ID ) ) :
				// 	if ( $fav_chk ) {
				// 		$fav_class = 'bbc-star';
				// 	} else {
				// 		$fav_class = 'bbc-star-o';
				// 	}
				// 	echo Nh_Forms::get_instance()
				// 		->create_form( [
				// 			'post_id'                   => [
				// 				'type'   => 'hidden',
				// 				'name'   => 'post_id',
				// 				'before' => '',
				// 				'after'  => '',
				// 				'value'  => $single_post->ID,
				// 				'order'  => 0
				// 			],
				// 			'add_to_fav_nonce'          => [
				// 				'class' => '',
				// 				'type'  => 'nonce',
				// 				'name'  => 'add_to_fav_nonce_nonce',
				// 				'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
				// 				'order' => 5
				// 			],
				// 			'submit_add_to_fav_request' => [
				// 				'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
				// 				'id'                  => 'submit_add_to_fav_request',
				// 				'type'                => 'submit',
				// 				'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
				// 				'recaptcha_form_name' => 'frontend_add_to_fav',
				// 				'order'               => 10
				// 			],
				// 		], [
				// 			'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
				// 		] );
				

				// 	echo Nh_Forms::get_instance()
				// 		->create_form( [
				// 			'post_id'              => [
				// 				'type'   => 'hidden',
				// 				'name'   => 'post_id',
				// 				'before' => '',
				// 				'after'  => '',
				// 				'value'  => $single_post->ID,
				// 				'order'  => 0
				// 			],
				// 			'ignore_article_nonce' => [
				// 				'class' => '',
				// 				'type'  => 'nonce',
				// 				'name'  => 'ignore_article_nonce',
				// 				'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
				// 				'order' => 5
				// 			],
				// 			'submit_ignore'        => [
				// 				'class'               => 'btn',
				// 				'id'                  => 'submit_submit_ignore',
				// 				'type'                => 'submit',
				// 				'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
				// 				'recaptcha_form_name' => 'frontend_ignore',
				// 				'order'               => 10
				// 			],
				// 		], [
				// 			'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
				// 		] );
				// endif;
				?>
			</div>
		</a>

		<?php if ( ! empty( $opportunity ) ) : ?>
			<div class="opportunity">
				<a href="<?= $opportunity->link ?>">
					<?= $opportunity->name; ?>
				</a>
			</div>
		<?php endif; ?>


		<div class="date">
			<img src="<?= get_avatar_url( $single_post->author ) ?>" alt="B2B" />
			<small class="text-muted">
				<?= __( 'on', 'ninja' ) ?>
				<?= date( 'F d, Y', strtotime( $single_post->created_date ) ) ?>
			</small>
		</div>
		<p class="short-description">
			<?= $single_post->excerpt ?>
		</p>
	</div>
</div>
