<?php

/**
 * @Filename: template-my-notifications.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 21/2/2023
 *
 * Template Name: My Notifications Page
 * Template Post Type: page
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\CLASSES\Nh_User;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );
Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-notifications', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-notifications' );

global $user_ID;
$notifications_obj = new Nh_Notification();

$notifications = $notifications_obj->get_notifications( -1 );
$count         = $notifications['new_count'];
$found_posts   = $notifications['found_posts'];

?>


<main class="my-notifications">
	<div class="container container-xxl">
		<?php Nh_Public::breadcrumbs(); ?>

		<nav class="dashboard-submenus mt-3 mb-5">
			<?php get_template_part( 'app/Views/template-parts/dashboard-submenus/main-nav', null, [ 'active_link' => 'my_notifications' ] ); ?>
		</nav>

		<div class="notifications-con">
			<div class="ninja-notification-my-account-list container">
				<div class="ninja-notification-group-container">
					<?php
					if ( ! empty( $notifications['notifications'] ) ) {
						?>
						<div class="row justify-content-between p-0">
							<div class="col-8">
								<h3>
									<?= __( "Notification list", "ninja" ) ?>
								</h3>
							</div>
							<div class="col-4 d-flex justify-content-end">
								<div class="ninja-notification-clear-parent">
									<button class="btn btn-outline-secondary ninja-notification-clear text-uppercase">
										<i class="bbc-trash-2"></i>
										<?= __( 'clear all' ) ?>
									</button>
								</div>
							</div>
						</div>
						<div class="ninja-notifications-group accordion accordion-flush mt-4" id="accordionFlush">
							<?php
							foreach ( $notifications['notifications'] as $notification ) {
								?>
								<div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?> accordion-item"
									data-id="<?= $notification->ID ?>">

									<div class="accordion-header" id="flush-heading<?= $notification->ID ?>">
										<div class="ninja-notification-image">
											<img src="<?= $notification->thumbnail ?>" alt="<?= __( 'Notification Thumbnail', 'ninja' ) ?>" />
										</div>
									</div>
									<div id="flush<?= $notification->ID ?>" class="accordion-collapse collapse"
										aria-labelledby="flush-heading<?= $notification->ID ?>" data-bs-parent="#accordionFlush">
										<div class="accordion-body">
											<?= $notification->content ?>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					} else {
						get_template_part( 'app/Views/template-parts/notifications/notification', 'empty' );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</main><!-- #main -->

<?php get_footer();
