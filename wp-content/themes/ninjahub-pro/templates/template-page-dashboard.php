<?php
/**
 * @Filename: template-page-dashboard.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: Dashboard Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

global $user_ID;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-dashboard', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/home-dashboard' );
?>

<main class="site-dashboard-home">
	<div class="container">
		<div class="dashboard-overview">
			<h3 class="fs-3 text-primary">
				<?= __( 'Overview', 'ninja' ) ?>
			</h3>
			<div class="widget-list">
				<div class="single-widget">
					widget 1
				</div>
			</div>
		</div>


		<section class="dashboard-body">
			<div class="row">
				<div class="col-md-8">
					<div class="dashboard-opportunity-list-container">
						<div class="opportunity-list-header row justify-content-between align-items-center">
							<div class="opportunity-title col-6">
								<h3 class="fs-3 text-primary">
									<?= __( 'Latest Opportunities', 'ninja' ) ?>
								</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores eaque eos
									fuga neque,
									pariatur.</p>
							</div>
							<div class="opportunity-actions col-6">
								<div class="opportunity-list-sort">
									<button class="btn btn-light bg-transparent opportunity-list-style">
										<i class="bbc-th-list"></i>
									</button>
									<button class="btn btn-light bg-transparent opportunity-list-filter">
										<i class="bbc-grid"></i>
									</button>
								</div>
								<button class="btn btn-outline-warning opportunity-adv-filter"
									data-bs-toggle="button"><i class="bbc-sliders"></i> Advanced Filters</button>
							</div>
						</div>
						<div class="opportunity-list">
							<div class="row row-cols-1 row-cols-md-2 g-4 card-group">
								<?php
								$opportunities_obj = new Nh_Opportunity();
								$opportunities     = $opportunities_obj->get_all();

								foreach ( $opportunities as $opportunity ) {
									$args = [ 
										'opportunity_link'         => $opportunity->link,
										'opportunity_title'        => $opportunity->title,
										'opportunity_thumbnail'    => $opportunity->thumbnail,
										'opportunity_created_date' => $opportunity->created_date,
										'is_item_controllers'      => true,
									];
									?>
									<div class="col">
										<?php get_template_part( 'app/Views/template-parts/cards/opportunity-card-vertical', null,
											$args ); ?>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="sidebar-container">
						<div class="sidebar-create-opportunity shadow">
							<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'dashboard/create-opportunity' ) ) ); ?>"
								class="btn-create-opportunity btn btn-success btn-lg shadow text-uppercase">
								<i class="bbc-plus-square"></i>
								<?= __( 'Create New Opportunity', 'ninja' ) ?>
							</a>

							<small class="pt-3"><i class="bbc-lightbulb-o"></i>
								<?= __( 'Please Note You Can Add Only', 'ninja' ); ?> <span class="text-warning">
									<?= __( 'One Opportunity In Month', 'ninja' ) ?>
								</span>
							</small>

						</div>
						<div class="sidebar-my-opportunities shadow">
							<h3 class="text-primary">
								<?= __( 'My Opportunities', 'ninja' ) ?>
							</h3>
						</div>
						<div class="sidebar-latest-acquisitions shadow">
							<div>
								<h3 class="text-primary">
									<?= __( 'Latest acquisitions', 'ninja' ) ?>
								</h3>
								<small class="text-muted">Latest update in June 28th, 2023</small>
							</div>
							<div class="acquisitions-list">

								<div class="row row-cols-1 g-4 card-group">
									<?php
									$opportunities_obj = new Nh_Opportunity();
									$opportunities     = $opportunities_obj->get_all();

									foreach ( $opportunities as $opportunity ) {
										$args = [ 
											'opportunity_link'         => $opportunity->link,
											'opportunity_title'        => $opportunity->title,
											'opportunity_thumbnail'    => $opportunity->thumbnail,
											'opportunity_created_date' => $opportunity->created_date,
											'is_item_controllers'      => false,
										];
										?>
										<div class="col">
											<?php get_template_part( 'app/Views/template-parts/cards/opportunity-card-horizontal', null,
												$args ); ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php get_template_part( 'app/Views/template-parts/cards/faq-help-card', null,
							[] ); ?>
					</div>
				</div>
			</div>
		</section>
	</div>

</main><!-- #main -->

<?php get_footer();
