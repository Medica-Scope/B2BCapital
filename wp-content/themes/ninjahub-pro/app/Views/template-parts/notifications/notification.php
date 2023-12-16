<?php
/**
 * @Filename: notifications.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;

global $user_ID;
$notifications_obj = new Nh_Notification();

$notifications = $notifications_obj->get_notifications( 10 );
$count         = $notifications['new_count'];
$found_posts   = $notifications['found_posts'];

// TODO:: Create cronjob to remove old notifications
?>

<div class="ninja-notifications">
	<div class="bell">
		<a href="#" class="ninja-notification-bell" data-count="<?= $count ?>">
			<span class="ninja-notification-count">
				<?= $count ?>
			</span>
			<i class="bbc-bell2"></i>
		</a>
	</div>
	<div class="ninja-notification-list container" data-page="2" data-last="<?= $found_posts > 10 ? 0 : 1 ?>">
		<div class="ninja-notification-group-container">
			<?php
			if ( ! empty( $notifications['notifications'] ) ) {
				?>
			<div class="ninja-notification-clear-parent">
				<button class="btn btn-sm btn-outline-secondary ninja-notification-clear text-uppercase">
					<i class="bbc-trash-2"></i>
					<?= __( 'clear all' ) ?>
				</button>
			</div>
			<div class="ninja-notifications-group">
				<?php
					foreach ( $notifications['notifications'] as $notification ) {
						?>
				<div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?>"
					data-id="<?= $notification->ID ?>">
					<a href="<?= $notification->url ?>">
						<div class="row">
							<div class="col-sm-2">
								<div class="ninja-notification-image">
									<img src="<?= $notification->thumbnail ?>" alt="<?= __( 'Notification Thumbnail', 'ninja' ) ?>" />
								</div>
							</div>
							<div class="col-sm-10">
								<div class="ninja-notification-content">
									<h6>
										<?= $notification->title ?>
									</h6>
									<p>
										<?= $notification->content ?>
									</p>
									<span>
										<?= $notification->date ?>
									</span>
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php
					}
					?>
			</div>
			<?php
				if ( $found_posts > 20 ) {
					?>
			<div class="ninja-show-more d-none"><a
					href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/my-notifications' ) ) ) ?>">
					<?= __( "Show more", "ninja" ) ?>
				</a></div>
			<?php } ?>
			<?php
			} else {
				get_template_part( 'app/Views/template-parts/notifications/notification', 'empty' );
			}
			?>
		</div>
	</div>
</div>