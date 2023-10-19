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
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
use NH\APP\MODELS\FRONT\Nh_Public;
use NH\Nh;

get_header();

Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-my-account', Nh_Hooks::PATHS['public']['css'] . '/pages/dashboard/my-account' );

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
						<h2>
							<?= __( "Notification list", "ninja" ) ?>
						</h2>
						<div class="ninja-notification-clear-parent">
							<button class="btn ninja-notification-clear">
								<?= __( 'clear all' ) ?>
							</button>
						</div>
						<div class="ninja-notifications-group accordion accordion-flush" id="accordionFlush">
							<?php
							foreach ( $notifications['notifications'] as $notification ) {
								?>
								<div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?> accordion-item"
									data-id="<?= $notification->ID ?>">

									<div class="accordion-header" id="flush-heading<?= $notification->ID ?>">
										<div class="ninja-notification-image">
											<img src="<?= $notification->thumbnail ?>"
												alt="<?= __( 'Notification Thumbnail', 'ninja' ) ?>" />
										</div>
										<h3 class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#flush<?= $notification->ID ?>" aria-expanded="false"
											aria-controls="flush<?= $notification->ID ?>">
											<?= $notification->title ?>
										</h3>
										<span>
											<?= $notification->date ?>
										</span>
										<div class="ninja-notification-item-clear-parent">
											<?php
											                echo Nh_Forms::get_instance()
															->create_form([
																'post_id'                      => [
																	'type'   => 'hidden',
																	'name'   => 'post_id',
																	'before' => '',
																	'after'  => '',
																	'value'  => $notification->ID,
																	'order'  => 0
																],
																'notification_item_clear_nonce'               => [
																	'class' => '',
																	'type'  => 'nonce',
																	'name'  => 'notification_item_clear_nonce',
																	'value' => Nh::_DOMAIN_NAME . "_notification_item_clear_nonce_form",
																	'order' => 5
																],
																'submit_notification_item_clear_request' => [
																	'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
																	'id'                  => 'submit_notification_item_clear_request',
																	'type'                => 'submit',
																	'value'               => __('Clear', 'ninja'),
																	'recaptcha_form_name' => 'frontend_notification_item_clear',
																	'order'               => 10
																],
															], [
																'class' => Nh::_DOMAIN_NAME . '-notification-item-clear-form',
															]);
														
											?>
										</div>
									</div>
									<div id="flush<?= $notification->ID ?>" class="accordion-collapse collapse"
										aria-labelledby="flush-heading<?= $notification->ID ?>"
										data-bs-parent="#accordionFlush">
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
