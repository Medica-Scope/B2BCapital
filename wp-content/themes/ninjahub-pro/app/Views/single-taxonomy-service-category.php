<?php
/**
 * @Filename: archive-service.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Service;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-services-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/services' );

global $wp_query;

$service_obj = new Nh_Service();
$category    = $service_obj->get_taxonomy_terms( 'service-category' );
?>


<section class="page-content">
	<!-- Services Content -->
	<div class="services-content">
		<!-- Services Categories -->
		<div class="services-categories">
			<h1 class="b2b-title">
				<?= __( 'B2B Services', 'ninja' ) ?>
			</h1>
			<h2 class="services-title">
				<?= __( 'Services', 'ninja' ) ?>
			</h2>
			<p class="services-description">
				<?= __( 'Services of the specialized administrative and technical consulting sector', 'ninja' ) ?>
			</p>
			<ul class="nav nav-tabs services-categories-navigation">
				<?php
				foreach ( $category as $key => $term ) {
					if ( is_tax() ) {
						$term_object = $wp_query->get_queried_object();
						$active      = $term->term_id === $term_object->term_id ? 'active' : '';
					} else {
						$active = $key === 0 ? 'active' : '';
					}
					?>
					<li class="nav-item service-category-link">
						<button type="button" class="nav-link <?= $active ?>" data-bs-toggle="tab"
							data-bs-target="#category-<?= $key ?>">
							<span class="category-number">
								<?= $key + 1 ?>.
							</span>
							<span class="category-name">
								<?= $term->name ?>
							</span>
						</button>
					</li>
					<?php
				}
				?>
			</ul>
		</div>

		<!-- Services Categories Content -->
		<div class="tab-content services-categories-content">
			<?php
			foreach ( $category as $key => $term ) {
				$services = $service_obj->get_category_services( $term );
				if ( is_tax() ) {
					$term_object = $wp_query->get_queried_object();
					$show_active = $term->term_id === $term_object->term_id ? 'show active' : '';
				} else {
					$show_active = $key === 0 ? 'show active' : '';
				}
				?>
				<div id="category-<?= $key ?>" class="services-category-content tab-pane fade <?= $show_active ?>">
					<div class="services-group-wrapper">
						<?php

						if ( count( $services ) > 2 ) {
							$chunk  = array_chunk( $services, 2 );
							$number = 0;
							foreach ( $chunk as $column ) {
								?>
								<div class="services-group">
									<?php
									foreach ( $column as $index => $service ) {
										?>
										<div class="service">
											<span class="service-number">
												<?= str_pad( $number + 1, 2, '0', STR_PAD_LEFT ); ?>.
											</span>
											<h3 class="service-title">
												<?= $service->title ?>
											</h3>
											<p class="service-description">
												<?= $service->meta_data['short_description'] ?>
											</p>
											<a href="<?= $service->link ?>" class="service-link">
												<?= __( 'Read more', 'ninja' ) ?>
												<span class="service-link-icons"><i class="icon bbc-chevrons-right"></i><i
														class="icon bbc-right"></i></span>
											</a>
										</div>
										<?php
										$number++;
									}
									?>
								</div>
								<?php
							}
						} else {
							foreach ( $services as $index => $service ) {
								?>
								<div class="services-group">
									<div class="service">
										<span class="service-number">
											<?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ); ?>.
										</span>
										<h3 class="service-title">
											<?= $service->title ?>
										</h3>
										<p class="service-description">
											<?= $service->meta_data['short_description'] ?>
										</p>
										<a href="<?= $service->link ?>" class="service-link">
											<?= __( 'Read more', 'ninja' ) ?>
											<span class="service-link-icons"><i class="icon bbc-right"></i><i
													class="icon bbc-right"></i></span>
										</a>
									</div>
								</div>
								<?php
							}
						}


						?>
					</div>
				</div>
				<?php
			}
			?>

		</div>
	</div>
</section>
</div> <!-- </layout> -->
</main>
</div> <!-- </landing-page> -->

<?php get_template_part( 'app/Views/js-templates/horizontal-scroll', null,
	[ 'scrollable_container' => '.services-categories-content' ] ); ?>
<?php get_footer();
