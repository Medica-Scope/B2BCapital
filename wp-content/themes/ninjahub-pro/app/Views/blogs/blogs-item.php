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
$fav_form        = ( isset( $args['fav_form'] ) ) ? $args['fav_form'] : '';
$ignore_form     = ( isset( $args['ignore_form'] ) ) ? $args['ignore_form'] : '';

if ( ( $single_post->meta_data['opportunity'] ) ) {
	$opportunity         = $opportunity_obj->get_by_id( $single_post->meta_data['opportunity'] );
	$args['opportunity'] = $opportunity;
}

$fav_chk     = ( isset( $args['fav_chk'] ) ) ? $args['fav_chk'] : '';
$ignore_chk  = ( isset( $args['ignore_chk'] ) ) ? $args['ignore_chk'] : '';
$opportunity = ( isset( $args['opportunity'] ) ) ? $args['opportunity'] : '';
?>
<div class="blog-item">
	<div class="card">
		<div class="card-image-top bg-gradient bg-primary">
			<img src="<?= Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-abstract-logo.webp"
				alt="B2B Capital Abstract Logo" />
			<a href="<?= $single_post->link ?>">
				<h3 class="title">
					<?= $single_post->title ?>
				</h3>
			</a>


			<?php if ( ! empty( $user_ID ) ) : ?>
			<button class="show-controllers" type="button"><i class="bbc-more-vertical"></i></button>
			<div class="opportunity-item-controllers ninja-hidden">
				<?php
					echo $args['fav_form'];
					echo $args['ignore_form'];
					?>
			</div>
			<?php
			endif;
			?>
		</div>

		<?php if ( ! empty( $single_post->taxonomy['category'] ) ) : ?>
		<div class="category">
			<small class="text-muted">
				<?= $single_post->taxonomy['category'][0]->name ?>
			</small>
		</div>
		<?php endif; ?>


		<?php if ( ! empty( $opportunity ) ) : ?>
		<div class="opportunity">
			<a href="<?= $opportunity->link ?>">
				<?= $opportunity->name; ?>
			</a>
		</div>
		<?php endif; ?>


		<div class="date">
			
			<img src="<?= get_avatar_url( $single_post->author ) ?>" alt="B2B" />
			<!-- <img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/brand/b2b-capital-light-logo.webp" alt="B2B" /> -->
			<p>
				<!-- <strong> <?= __( 'B2B', 'ninja' ) ?></strong> -->
				<?php $author = get_user_by( 'ID', $single_post->author ); ?>
				<strong><?= $author->display_name; ?></strong>
				<?= __( 'on', 'ninja' ) ?>
				<?= date( 'F d, Y', strtotime( $single_post->created_date ) ) ?>
			</p>
		</div>

		<a href="<?= $single_post->link ?>">
			<div class="short-description text-break">
				<?= mb_strimwidth( $single_post->excerpt, 0, 80, '...' ); ?>
			</div>
		</a>
	</div>
</div>
