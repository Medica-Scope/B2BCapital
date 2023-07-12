<?php
    /**
     * @Filename: notifications-ajax.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;

    $notifications_obj = new B2b_Notification();
    $b2b_notification  = $args['data'];
    $notification      = $notifications_obj->notification_html($notifications_obj->assign($b2b_notification));


?>
    <div class="b2b-notification-item <?= $notification->new ? 'b2b-new-notification' : '' ?>" data-id="<?= $notification->ID ?>">
        <a href="<?= $notification->url ?>">
            <div class="row">
                <div class="col-sm-2">
                    <div class="b2b-notification-image">
                        <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail') ?>"/>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="b2b-notification-content">
                        <h6><?= $notification->title ?></h6>
                        <p><?= $notification->content ?></p>
                        <span><?= $notification->date ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php