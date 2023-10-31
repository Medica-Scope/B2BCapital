<?php

use NH\APP\HELPERS\Nh_Forms;
use NH\Nh;

$opportunity_link         = !empty($args['opportunity_link']) ? $args['opportunity_link'] : false;
$opportunity_id         = !empty($args['opportunity_id']) ? $args['opportunity_id'] : false;
$opportunity_title        = !empty($args['opportunity_title']) ? $args['opportunity_title'] : false;
$opportunity_thumbnail    = !empty($args['opportunity_thumbnail']) ? $args['opportunity_thumbnail'] : false;
$opportunity_created_date = !empty($args['opportunity_created_date']) ? $args['opportunity_created_date'] : false;
$is_item_controllers      = !empty($args['is_item_controllers']) ? $args['is_item_controllers'] : false;
$is_card_horizontal       = !empty($args['is_card_horizontal']) ? $args['is_card_horizontal'] : false;
$is_fav                   = !empty($args['is_fav']) ? $args['is_fav'] : false;

?>
<div class="opportunity-item card shadow border-0">
	<div class="row g-0">
		<div class="card-image <?= $is_card_horizontal ? 'col-md-4' : ''; ?>">
			<a href="<?= esc_url($opportunity_link); ?>"><img src="<?= esc_url($opportunity_thumbnail); ?>" alt="<?= esc_attr($opportunity_title); ?>"></a>
			<?php
			if ($is_item_controllers) {
				if ($is_fav) {
					$fav_class = 'bbc-star';
				} else {
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
								'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
								'recaptcha_form_name' => 'frontend_add_to_fav',
								'order'               => 10
							],
						], [
							'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
						]);

					echo Nh_Forms::get_instance()
						->create_form([
							'post_id'              => [
								'type'   => 'hidden',
								'name'   => 'opp_id',
								'before' => '',
								'after'  => '',
								'value'  => $opportunity_id,
								'order'  => 0
							],
							'ignore_opportunity_nonce' => [
								'class' => '',
								'type'  => 'nonce',
								'name'  => 'ignore_opportunity_nonce',
								'value' => Nh::_DOMAIN_NAME . "_ignore_opportunity_nonce_form",
								'order' => 5
							],
							'submit_ignore'        => [
								'class'               => 'btn',
								'id'                  => 'submit_submit_ignore',
								'type'                => 'submit',
								'value'               => '<i class="bbc-star-o fav-star"></i>',
								'recaptcha_form_name' => 'frontend_ignore',
								'order'               => 10
							],
						], [
							'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
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
		<div class="card-body p-0 <?= $is_card_horizontal ? 'col-md-8' : ''; ?>">
			<p class="card-text"><small class="text-body-secondary">
					<?= __('Business Type', 'ninja'); ?>
				</small></p>

			<a href="<?= esc_url($opportunity_link); ?>" class="card-title btn btn-link btn-link-dark">
				<?= $opportunity_title; ?>
			</a>

			<p class="card-text"><small class="text-body-secondary">
					<?= $opportunity_created_date; ?>
				</small>
			</p>

			<div class="card-extra-info">
				<div class="card-info-item">
					<small class="text-body-secondary">Location</small>
					<p class="card-text fw-bold">Egypt</p>
				</div>
				<div class="card-info-item">
					<small class="text-body-secondary">Valuation</small>
					<p class="card-text fw-bold">95460$</p>
				</div>
				<div class="card-info-item">
					<small class="text-body-secondary">Location</small>
					<p class="card-text fw-bold">Egypt</p>
				</div>
				<div class="card-info-item">
					<small class="text-body-secondary">Valuation</small>
					<p class="card-text fw-bold">95460$</p>
				</div>
			</div>
		</div>
	</div>
</div>