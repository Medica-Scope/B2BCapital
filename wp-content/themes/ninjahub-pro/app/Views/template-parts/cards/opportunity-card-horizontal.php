<?php

use NH\APP\HELPERS\Nh_Forms;
use NH\Nh;

$opportunity_link         = ! empty( $args['opportunity_link'] ) ? $args['opportunity_link'] : false;
$opportunity_id           = ! empty( $args['opportunity_id'] ) ? $args['opportunity_id'] : false;
$opportunity_title        = ! empty( $args['opportunity_title'] ) ? $args['opportunity_title'] : false;
$opportunity_thumbnail    = ! empty( $args['opportunity_thumbnail'] ) ? $args['opportunity_thumbnail'] : false;
$opportunity_created_date = ! empty( $args['opportunity_created_date'] ) ? $args['opportunity_created_date'] : false;
$is_item_controllers      = ! empty( $args['is_item_controllers'] ) ? $args['is_item_controllers'] : false;
$is_fav                   = ! empty( $args['is_fav'] ) ? $args['is_fav'] : false;
?>
<div class="opportunity-item card card-horizontal shadow border p-0">
	<div class="row g-0">
		<div class="card-image col-md-4">
			<a href="<?= esc_url( $opportunity_link ); ?>"><img src="<?= esc_url( $opportunity_thumbnail ); ?>"
					alt="<?= esc_attr( $opportunity_title ); ?>"></a>
			<?php
			if ( $is_item_controllers ) {
				if($is_fav){
					$fav_class = 'bbc-star';
				}
				else{
					$fav_class = 'bbc-star-o';
				}
				?>
				<div class="opportunity-item-controllers">
					<?php
					echo Nh_Forms::get_instance()
					->create_form([
						'opp_id'                      => [
							'type'   => 'hidden',
							'name'   => 'opp_id',
							'before' => '',
							'after'  => '',
							'value'  => $opportunity_id,
							'order'  => 0
						],
						'add_to_fav_nonce'               => [
							'class' => '',
							'type'  => 'nonce',
							'name'  => 'add_to_fav_nonce_nonce',
							'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
							'order' => 5
						],
						'submit_add_to_fav_request' => [
							'class'               => 'btn btn-light bg-white opportunity-to-favorite ninja-add-to-fav',
							'id'                  => 'submit_add_to_fav_request',
							'type'                => 'submit',
							'value'               => '<i class="'.$fav_class.' fav-star"></i>',
							'recaptcha_form_name' => 'frontend_add_to_fav',
							'order'               => 10
						],
					], [
						'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
					]);
					?>
					<button class="btn btn-light bg-white opportunity-btn-more">
						<i class="bbc-more-vertical"></i>
					</button>
				</div>
				<?php
			}
			?>
		</div>
		<div class="col-md-8">
			<div class="card-body p-0">
				<p class="card-text"><small class="text-body-secondary">
						<?= __( 'Business Type', 'ninja' ); ?>
					</small></p>

				<a href="<?= esc_url( $opportunity_link ); ?>" class="card-title btn btn-link btn-link-dark">
					<?= $opportunity_title; ?>
				</a>

				<p class="card-text"><small class="text-body-secondary">
						<?= $opportunity_created_date; ?>
					</small>
				</p>
			</div>
		</div>
	</div>
	<div class="card-footer card-extra-info">
		<div class="card-info-item">
			<small class="text-body-secondary"><?= __('Location', 'ninja') ?></small>
			<p class="card-text fw-bold">Egypt</p>
		</div>
		<div class="card-info-item">
			<small class="text-body-secondary"><?= __('Valuation', 'ninja') ?></small>
			<p class="card-text fw-bold">95460$</p>
		</div>
	</div>
</div>
