<?php

use NH\APP\HELPERS\Nh_Forms;
use NH\Nh;

$opportunity_link         = ! empty( $args['opportunity_link'] ) ? $args['opportunity_link'] : FALSE;
$opportunity_id           = ! empty( $args['opportunity_id'] ) ? $args['opportunity_id'] : FALSE;
$opportunity_title        = ! empty( $args['opportunity_title'] ) ? $args['opportunity_title'] : FALSE;
$opportunity_thumbnail    = ! empty( $args['opportunity_thumbnail'] ) ? $args['opportunity_thumbnail'] : FALSE;
$opportunity_created_date = ! empty( $args['opportunity_created_date'] ) ? $args['opportunity_created_date'] : FALSE;
$is_item_controllers      = ! empty( $args['is_item_controllers'] ) ? $args['is_item_controllers'] : FALSE;
$is_fav                   = ! empty( $args['is_fav'] ) ? $args['is_fav'] : FALSE;
$business_type            = ! empty( $args['business_type'] ) ? $args['business_type'] : FALSE;
$location                 = ! empty( $args['location'] ) ? $args['location'] : FALSE;
$location_appearance      = ! empty( $args['location_appearance'] ) ? $args['location_appearance'] : FALSE;
$valuation                = ! empty( $args['valuation'] ) ? $args['valuation'] : FALSE;
$valuation_appearance     = ! empty( $args['valuation_appearance'] ) ? $args['valuation_appearance'] : FALSE;
?>
<div class="opportunity-item card new-acquisition-item-card card-horizontal border p-0">
	<div class="row g-0 d-flex card-content">
		<div class="card-image col-md-4">
			<a href="<?= esc_url( $opportunity_link ); ?>"><img src="<?= esc_url( $opportunity_thumbnail ); ?>" alt="<?= esc_attr( $opportunity_title ); ?>"></a>
			<?php
			if ( $is_item_controllers ) {
				if ( $is_fav ) {
					$fav_class = 'bbc-star';
				} else {
					$fav_class = 'bbc-star-o';
				}
				?>
			<button class="show-controllers" type="button">...</button>
			<div class="opportunity-item-controllers ninja-hidden">
							<?php
							echo Nh_Forms::get_instance()
								->create_form( [ 
									'opp_id'                    => [ 
										'type'   => 'hidden',
										'name'   => 'opp_id',
										'before' => '',
										'after'  => '',
										'value'  => $opportunity_id,
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
										'class'               => 'btn btn-light bg-white opportunity-to-favorite ninja-add-to-fav',
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
									'opp_id'                   => [ 
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
									'submit_ignore'            => [ 
										'class'               => 'btn',
										'id'                  => 'submit_submit_ignore',
										'type'                => 'submit',
										'value'               => '<i class="controll-icon bbc-thumbs-down text-danger ignore-star"></i>',
										'recaptcha_form_name' => 'frontend_ignore',
										'order'               => 10
									],
								], [ 
									'class' => Nh::_DOMAIN_NAME . '-create-ignore-opportunity-form',
								] );

							?>
							<button class="btn btn-light bg-white opportunity-btn-more">
								<i class="bbc-more-vertical"></i>
							</button>
						</div>
						<?php
			}
			?>
		</div>
		<div class="col-md-8 cardRight-content">
			<div class="card-body p-0">
			

				<a href="<?= esc_url( $opportunity_link ); ?>" class="card-title btn btn-link btn-link-dark">
					<?= $opportunity_title; ?>
				</a>

			
				<p class="card-text business_type ">
					<strong class="text-body-secondary">
						<?= __( 'Business Type', 'ninja' ); ?>
					</strong>
					<br>
					<?= $business_type ?>
				</p>
				<p class="card-text">
					<small class="text-body-secondary date">
						<?= date( 'F j, Y', strtotime( $opportunity_created_date ) );
						; ?>
					</small>
				</p>
			</div>
		</div>
	</div>
	<div class="card-footer card-extra-info">
		<div class="card-info-item">
			<?php if ( (int) NH_CONFIGURATION['opportunities_fields'][ Nh::_DOMAIN_NAME . '_location' ] === 1 ) { ?>
					<small class="text-body-secondary"><?= __( 'Location', 'ninja' ) ?></small>
					<?php
					if ( (int) $location_appearance === 1 ) {
						?><p class="card-text fw-bold"><?= $location; ?></p><?php
					} else {
						_ex( '<p class="card-text fw-bold">HIDDEN</p>', 'ninja' );
					}
					?>
			<?php } ?>
		</div>
		<div class="card-info-item">
			<?php if ( (int) NH_CONFIGURATION['opportunities_fields'][ Nh::_DOMAIN_NAME . '_valuation_in_usd' ] === 1 ) { ?>
					<small class="text-body-secondary"><?= __( 'Valuation', 'ninja' ) ?></small>
					<?php
					if ( (int) $valuation_appearance === 1 ) {
						?><p class="card-text fw-bold"><?= '$ ' . $valuation; ?></p><?php
					} else {
						_ex( '<p class="card-text fw-bold">HIDDEN</p>', 'ninja' );
					}
					?>
			<?php } ?>
		</div>
	</div>
</div>
