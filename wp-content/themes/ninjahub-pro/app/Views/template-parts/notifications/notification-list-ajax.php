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
$nh_notification  = $args['data'];
$notification      = $notifications_obj->notification_html($notifications_obj->assign($nh_notification));

// if ((int)$notification->meta_data['new'] > 0) {
//     $notification->set_meta_data('new', 0);
//     $notification->update();
// }

?>
<div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?> accordion-item" data-id="<?= $notification->ID ?>">

    <div class="accordion-header" id="flush-heading<?= $notification->ID ?>">
        <div class="ninja-notification-image">
            <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'ninja') ?>" />
        </div>
        <h3 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush<?= $notification->ID ?>" aria-expanded="false" aria-controls="flush<?= $notification->ID ?>">
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
    <div id="flush<?= $notification->ID ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $notification->ID ?>" data-bs-parent="#accordionFlush">
        <div class="accordion-body">
            <?= $notification->content ?>
        </div>
    </div>
</div>