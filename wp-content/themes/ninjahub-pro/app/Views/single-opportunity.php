<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Mustafa Shaaban
 * @Date: 9/21/2023
 */

use NH\APP\CLASSES\Nh_Init;
use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Acquisition;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Bid;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity_Investments;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

global $user_ID, $post;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-single-opportunity', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-opportunity' );

$opportunity_obj             = new Nh_Opportunity();
$opportunity_bids_obj        = new Nh_Opportunity_Bid();
$opportunity_acquisition_obj = new Nh_Opportunity_Acquisition();
$opportunity_investments_obj = new Nh_Opportunity_Investments();
$opportunity                 = $opportunity_obj->get_by_id( $post->ID );
$business_model              = isset( $opportunity->taxonomy['business-model'] ) ? implode( ' + ', array_map( function ($single) {
	return $single->name;
}, $opportunity->taxonomy['business-model'] ) ) : '';
$opportunity_type            = isset( $opportunity->taxonomy['opportunity-type'] ) ? $opportunity->taxonomy['opportunity-type'][0]->term_id : '';
$unique_type_name            = get_term_meta( $opportunity_type, 'unique_type_name', TRUE );
$opportunity_bids            = $opportunity_obj->get_opportunity_bids( $opportunity->ID, TRUE );
$opportunity_acquisitions    = $opportunity_obj->get_opportunity_acquisitions( $opportunity->ID, TRUE );
?>

<main class="container container-xxl">
	<div class="row align-items-end">
		<div class="col-8">
			<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'dashboard' ) ) ) ?>"
				class="btn btn-light text-uppercase mb-2"><i class="bbc-chevron-left"></i>
				<?= __( 'back', 'ninja' ); ?>
			</a>
			<h3 class="mb-4">
				<?= $opportunity->title; ?>
			</h3>

			<h3 class="text-warning">
				<?= __( 'Business Type', 'ninja' ); ?>
			</h3>

			<p>
				<?= $opportunity->taxonomy['business-type'][0]->name ?>
			</p>
		</div>
		<div class="col-4 actions">
			<?php

			echo Nh_Forms::get_instance()
				->create_form( [ 
					'opp_id'                    => [ 
						'type'   => 'hidden',
						'name'   => 'opp_id',
						'before' => '',
						'after'  => '',
						'value'  => $opportunity->ID,
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
						'class'               => 'btn-secondary',
						'id'                  => 'submit_add_to_fav_request',
						'type'                => 'submit',
						'value'               => '<i class="bbc-bookmark"></i> ' . __( 'Add To Favorite', 'ninja' ),
						'recaptcha_form_name' => 'frontend_add_to_fav',
						'order'               => 10
					],
				], [ 
					'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
					'id'    => Nh::_DOMAIN_NAME . '_add_to_fav_form'
				] );


			echo Nh_Forms::get_instance()
				->create_form( [ 
					'opp_id'           => [ 
						'type'   => 'hidden',
						'name'   => 'opp_id',
						'before' => '',
						'after'  => '',
						'value'  => $opportunity->ID,
						'order'  => 0
					],
					'ignore_opp_nonce' => [ 
						'class' => '',
						'type'  => 'nonce',
						'name'  => 'ignore_opp_nonce',
						'value' => Nh::_DOMAIN_NAME . "_ignore_opp_nonce_form",
						'order' => 5
					],
					'submit_ignore'    => [ 
						'class'               => 'btn-danger',
						'id'                  => 'submit_submit_ignore',
						'type'                => 'submit',
						'value'               => '<i class="bbc-x-circle"></i> ' . __( 'Ignore', 'ninja' ),
						'recaptcha_form_name' => 'frontend_ignore',
						'order'               => 10
					],
				], [ 
					'class' => Nh::_DOMAIN_NAME . '-create-ignore-opp-form',
					'id'    => Nh::_DOMAIN_NAME . '_create_ignore_opp_form'
				] );

			if ( $opportunity->meta_data['opportunity_stage'] !== 'success' ) {

				if ( Nh_User::get_user_role() === Nh_User::INVESTOR ) {
					if ( $unique_type_name === 'bidding' ) {
						if ( $opportunity_bids_obj->user_can_bid( $user_ID, $opportunity->ID ) ) {
							?>

							<div class="bidding-modal">
								<!-- Button trigger modal -->
								<button type="button" id="addBidModalBtn" class="btn btn-primary" data-bs-toggle="modal"
									data-bs-target="#addBidModal">
									<?= __( 'Add Bid', 'ninja' ) ?>
								</button>

								<!-- Modal -->
								<div class="modal fade" id="addBidModal" tabindex="-1" aria-labelledby="addBidModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title fs-5" id="addBidModalLabel">
													<?= __( 'Add Bid', 'ninja' ) ?>
												</h1>
											</div>
											<div class="modal-body">
												<div>
													<div>
														<p>
															<?= __( 'Start bidding amount', 'ninja' ) ?>
														</p>
														<span>$
															<?= $opportunity->meta_data['start_bidding_amount'] ?>
														</span>
													</div>
													<div>
														<p>
															<?= __( 'Target amount', 'ninja' ) ?>
														</p>
														<span>$
															<?= $opportunity->meta_data['target_amount'] ?>
														</span>
													</div>
												</div>

												<div>
													<?= Nh_Forms::get_instance()
														->create_form( [ 
															'bid_amount'    => [ 
																'class'       => '',
																'type'        => 'number',
																'name'        => 'bid_amount',
																'placeholder' => __( 'Add Bid', 'ninja' ),
																'before'      => '',
																'order'       => 0,
															],
															'opp_id'        => [ 
																'type'   => 'hidden',
																'name'   => 'opp_id',
																'before' => '',
																'after'  => '',
																'value'  => $opportunity->ID,
																'order'  => 5
															],
															'start_bid'     => [ 
																'type'  => 'hidden',
																'id'    => Nh::_DOMAIN_NAME . '_start_bid',
																'name'  => 'start_bid',
																'value' => (int) $opportunity->meta_data['start_bidding_amount'],
																'order' => 10
															],
															'add_bid_nonce' => [ 
																'class' => '',
																'type'  => 'nonce',
																'name'  => 'add_bid_nonce',
																'value' => Nh::_DOMAIN_NAME . "_add_bid_nonce_form",
																'order' => 15
															],
															'submit_bid'    => [ 
																'class'               => 'btn',
																'id'                  => 'submit_bid',
																'type'                => 'submit',
																'value'               => __( 'Start Bidding', 'ninja' ),
																'recaptcha_form_name' => 'frontend_add_bid',
																'order'               => 20
															],
														], [ 
															'class' => Nh::_DOMAIN_NAME . '-add-bid-form',
															'id'    => Nh::_DOMAIN_NAME . '_add_bid_form'
														] ); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}

						?>
						<span class="btn btn-blue">
							<?= sprintf( __( 'Number Of Bids %s', 'ninja' ), "<span class='bids-numbers'>" . $opportunity_bids . "</span>" ) ?>
						</span>
						<?php
					}

					if ( $unique_type_name === 'acquisition' ) {
						if ( $opportunity_acquisition_obj->user_can_acquire( $user_ID, $opportunity->ID ) ) {
							echo Nh_Forms::get_instance()
								->create_form( [ 
									'opp_id'                      => [ 
										'type'   => 'hidden',
										'name'   => 'opp_id',
										'before' => '',
										'after'  => '',
										'value'  => $opportunity->ID,
										'order'  => 0
									],
									'create_acquisitions_nonce'   => [ 
										'class' => '',
										'type'  => 'nonce',
										'name'  => 'create_acquisitions_nonce',
										'value' => Nh::_DOMAIN_NAME . "_create_acquisitions_nonce_form",
										'order' => 5
									],
									'submit_acquisitions_request' => [ 
										'class'               => 'btn',
										'id'                  => 'submit_acquisitions_request',
										'type'                => 'submit',
										'value'               => __( 'Acquisitions', 'ninja' ),
										'recaptcha_form_name' => 'frontend_create_acquisitions',
										'order'               => 15
									],
								], [ 
									'class' => Nh::_DOMAIN_NAME . '-create-acquisition-form',
									'id'    => Nh::_DOMAIN_NAME . '_create_acquisition_form'
								] );
						}
					}

					if ( $unique_type_name === 'regular' ) {
						if ( $opportunity_investments_obj->user_can_invest( $user_ID, $opportunity->ID ) ) {
							echo Nh_Forms::get_instance()
								->create_form( [ 
									'opp_id'                     => [ 
										'type'   => 'hidden',
										'name'   => 'opp_id',
										'before' => '',
										'after'  => '',
										'value'  => $opportunity->ID,
										'order'  => 0
									],
									'create_investments_nonce'   => [ 
										'class' => '',
										'type'  => 'nonce',
										'name'  => 'create_investments_nonce',
										'value' => Nh::_DOMAIN_NAME . "_create_investments_nonce_form",
										'order' => 5
									],
									'submit_investments_request' => [ 
										'class'               => 'btn',
										'id'                  => 'submit_investments_request',
										'type'                => 'submit',
										'value'               => __( 'Invest Request', 'ninja' ),
										'recaptcha_form_name' => 'frontend_create_investments',
										'order'               => 15
									],
								], [ 
									'class' => Nh::_DOMAIN_NAME . '-create-investment-form',
									'id'    => Nh::_DOMAIN_NAME . '_create_investment_form'
								] );
						}
					}

				}

				if ( Nh_User::get_user_role() === Nh_User::OWNER ) {
					if ( $unique_type_name === 'bidding' ) {
						?>
						<span class="btn btn-blue">
							<?= sprintf( __( 'Number Of Bids %s', 'ninja' ), "<span class='bids-numbers'>" . $opportunity_bids . "</span>" ) ?>
						</span>
						<?php
					}

					if ( $unique_type_name === 'acquisition' ) {
						?>
						<span class="btn btn-blue">
							<?= sprintf( __( 'Number Of Requests %s', 'ninja' ), "<span class='acquisitions-numbers'>" . $opportunity_acquisitions . "</span>" ) ?>
						</span>
						<?php
					}

					if ( $unique_type_name === 'regular' ) {
						?>
						<span class="btn btn-blue">
							<?= sprintf( __( 'Number Of Requests %s', 'ninja' ), "<span class='regular-numbers'>" . $opportunity_acquisitions . "</span>" ) ?>
						</span>
						<?php
					}
				}

			}
			?>
		</div>
	</div>
	<div class="opportunity-details row row-cols-1 row-cols-md-2 g-4 mt-2">
		<div class="col details-items">
			<div class="card shadow">
				<div class="row g-0">
					<div class="col-md-4">
						<img src="<?= $opportunity->thumbnail ?>" class="img-fluid rounded-start"
							alt="<?= esc_attr( $opportunity->title ); ?>">
					</div>
					<div class="col-md-8">
						<div class="card-body">
							<h5 class="card-title text-primary">
								<?= __( 'About', 'ninja' ) ?>
							</h5>
							<div class="card-text">
								<?= wp_html_excerpt( $opportunity->meta_data['short_description'], 140, '...' ); ?>
							</div>
							<div class="card-extra-info">
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Date Founded', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= date( 'F j, Y', strtotime( $opportunity->meta_data['date_founded'] ) ); ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Asking price in USD', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold text-success">$
										<?= $opportunity->meta_data['asking_price_in_usd']; ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Number of Customers', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['number_of_customers']; ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Business Team size', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['business_team_size']; ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col details-items">
			<div class="card shadow">
				<div class="row g-0">
					<div class="col-12">
						<div class="card-body">
							<h5 class="card-title text-primary">
								<?= __( 'Financial Details', 'ninja' ) ?>
							</h5>
							<div class="card-extra-info">
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Net Profit', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold text-success">$
										<?= $opportunity->meta_data['net_profit']; ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Valuation in USD', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold text-success">$
										<?= $opportunity->meta_data['valuation_in_usd'] ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Stake to be sold', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['stake_to_be_sold_percentage'] ?>%
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'USD Exchange rate used in conversion', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= sprintf( __( '%s EGP', 'ninja' ), $opportunity->meta_data['usd_exchange_rate_used_in_conversion'] ); ?>
									</p>
								</div>
							</div>
							<div class="card-extra-info">
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Annual Accounting Revenue', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold text-success">$
										<?= $opportunity->meta_data['annual_accounting_revenue'] ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Annual Growth Rate', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['annual_growth_rate_percentage'] ?>%
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Annual Growth Rate', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold text-success">$
										<?= $opportunity->meta_data['annual_growth_rate'] ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col details-items">
			<div class="card shadow">
				<div class="row g-0">
					<div class="col-12">
						<div class="card-body">
							<h5 class="card-title text-primary">
								<?= __( 'Business Overview', 'ninja' ) ?>
							</h5>
							<div class="card-extra-info">
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Business model and pricing', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $business_model ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Tech stack this product is built on', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['tech_stack_this_product_is_built_on'] ?>
									</p>
								</div>
								<div class="card-info-item">
									<small class="text-body-secondary">
										<?= __( 'Product competitors', 'ninja' ) ?>
									</small>
									<p class="card-text fw-bold">
										<?= $opportunity->meta_data['product_competitors'] ?>
									</p>
								</div>
							</div>
							<div class="extra-info">
								<?= $opportunity->meta_data['extra_details'] ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col details-items">
			<?php get_template_part( 'app/Views/template-parts/cards/faq-help-card', NULL, [] ); ?>
		</div>
	</div>

	<div class="related-opportunities mb-4">
		<h3>
			<?= __( 'Related Opportunities', 'ninja' ); ?>
		</h3>
		<?php get_template_part( 'app/Views/template-parts/related-opportunities-slider', NULL, [ 'related_opportunities' => $opportunity->meta_data['related_opportunities'] ] )
		; ?>
	</div>
</main><!-- #main -->
<?php get_template_part( 'app/Views/js-templates/horizontal-scroll', NULL, [ 'scrollable_container' => '.related-opportunities-slider .overflow-x-auto' ] ); ?>
<?php
get_footer();
