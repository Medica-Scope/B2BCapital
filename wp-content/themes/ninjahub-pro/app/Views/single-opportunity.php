<?php

/**
 * @Filename: single.php
 * @Description:
 * @User: Mustafa Shaaban
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;
use NH\Nh;

global $post;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-single-opportunity', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/single-opportunity' );
?>

<main class="container container-xxl">
	<button class="btn btn-secondary text-uppercase mb-2"><i class="bbc-chevron-left"></i>
		<?= __( 'back', 'ninja' ); ?>
	</button>
	<h3 class="mb-4">
		<?= $post->post_title; ?>
	</h3>

	<h3 class="text-warning">
		<?= __( 'Business Type', 'ninja' ); ?>
	</h3>

	<p>SaaS</p>
	<div class="row row-cols-1 row-cols-md-2 g-0">
		<div class="card">
			<div class="row g-0">
				<div class="col-md-4">
					<img src="<?= get_attachment_link( $post ); ?>" class="img-fluid rounded-start"
						alt="<?= esc_attr( $post->post_title ); ?>">
				</div>
				<div class="col-md-8">
					<div class="card-body">
						<h5 class="card-title text-primary">About</h5>
						<p class="card-text">This is a wider card with supporting text below as a natural lead-in to
							additional
							content. This content is a little bit longer.</p>
						<div class="card-extra-info">
							<div class="card-info-item">
								<small class="text-body-secondary">Date Founded</small>
								<p class="card-text fw-bold">January 1, 2020</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Asking price</small>
								<p class="card-text fw-bold text-success">95460$</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Number of Customers</small>
								<p class="card-text fw-bold">200</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Team size</small>
								<p class="card-text fw-bold">8</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row g-0">
				<div class="col-12">
					<div class="card-body">
						<h5 class="card-title text-primary">Financial Details</h5>
						<div class="card-extra-info">
							<div class="card-info-item">
								<small class="text-body-secondary">Net Profit</small>
								<p class="card-text fw-bold text-success">9475460$</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Valuation in USD</small>
								<p class="card-text fw-bold text-success">95460$</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Stake to be sold</small>
								<p class="card-text fw-bold">5 %</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">USD Exchange rate</small>
								<p class="card-text fw-bold">18.7 EGP</p>
							</div>
						</div>
						<div class="card-extra-info">
							<div class="card-info-item">
								<small class="text-body-secondary">Annual Accounting Revenue</small>
								<p class="card-text fw-bold text-success">95460$</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Asking price</small>
								<p class="card-text fw-bold text-success">95460$</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Annual Growth Rate</small>
								<p class="card-text fw-bold">18 %</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Annual Growth Rate</small>
								<p class="card-text fw-bold text-success">95460$</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row g-0">
				<div class="col-12">
					<div class="card-body">
						<h5 class="card-title text-primary">Bussiness Overview</h5>
						<div class="card-extra-info">
							<div class="card-info-item">
								<small class="text-body-secondary">Business model and pricing</small>
								<p class="card-text fw-bold">Selling Hardware + Subscription fees</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Tech stack this product is built on</small>
								<p class="card-text fw-bold">N/A</p>
							</div>
							<div class="card-info-item">
								<small class="text-body-secondary">Product competitors</small>
								<p class="card-text fw-bold">Happy or Not , Vcount, Cross point</p>
							</div>
						</div>
						<div class="card-extra-info">
							<div class="card-info-item">
								<p class="card-text fw-bold">* Growth opportunity</p>
							</div>
							<div class="card-info-item">
								<p class="card-text fw-bold">* Unique Selling Points</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php get_template_part( 'app/Views/template-parts/cards/faq-help-card', null,
			[] ); ?>
	</div>

	<div class="related-opportunities">
		<h3>
			<?= __( 'Related Opportunities', 'ninja' ); ?>
		</h3>
		<?php get_template_part( 'app/Views/template-parts/related-opportunities-slider', null,
			[] ); ?>
	</div>
</main><!-- #main -->

<?php
get_footer();
