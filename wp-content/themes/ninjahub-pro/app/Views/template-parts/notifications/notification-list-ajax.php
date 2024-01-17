<?php

/**
 * @Filename: notifications-ajax.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
use NH\Nh;

$notifications_obj = new Nh_Notification();
$nh_notification  = $args['data']['notification'];
$notification      = $notifications_obj->notification_html($notifications_obj->assign($nh_notification));

// if ((int)$notification->meta_data['new'] > 0) {
//     $notification->set_meta_data('new', 0);
//     $notification->update();
// }

?>
<div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?> accordion-item" data-id="<?= $notification->ID ?>">

    <div class="accordion-header d-flex align-items-center" id="flush-heading<?= $notification->ID ?>">
        <div class="ninja-notification-image col-1">
            <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'ninja') ?>" />
        </div>
        <div class="ninja-notification-content col-11">
            <h3 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush<?= $notification->ID ?>" aria-expanded="false" aria-controls="flush<?= $notification->ID ?>">
                <?= $notification->title ?>
            </h3>
            <span>
                <?= $notification->date ?>
            </span>

            <div class="ninja-notification-item-clear-parent">
                <?php
                $args['data']['item_clear_form'];
                 ?>
            </div>

            <div id="flush<?= $notification->ID ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $notification->ID ?>" data-bs-parent="#accordionFlush">
                <div class="accordion-body">
                    <?= $notification->content ?>
                </div>
            </div>
        </div>
    </div>
</div>