<?php
    /**
     * @Filename: notifications.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;

    global $user_ID;
    $notifications_obj = new B2b_Notification();

    $notifications = $notifications_obj->get_notifications();
    $count         = $notifications['new_count'];

    // TODO:: Change object to get found posts
    // TODO:: Create cronjob to remove old notifications
?>

<div class="b2b-notifications">
    <div class="bell">
        <button class="btn b2b-notification-bell" data-count="<?= $count ?>">
            <span class="b2b-notification-count"><?= $count ?></span>
            <i class="fa-regular fa-bell"></i>
        </button>
    </div>
    <div class="b2b-notification-list container" data-page="2" data-last="0">
        <?php
            if (!empty($notifications['notifications'])) {
                ?>
                <div class="b2b-notification-clear-parent">
                    <button class="btn b2b-notification-clear">
                        <?= __('clear all') ?>
                    </button>
                </div>
                <div class="b2b-notifications-group">
                    <?php
                        foreach ($notifications['notifications'] as $notification) {
                            ?>
                            <div class="b2b-notification-item <?= $notification->new ? 'b2b-new-notification' : '' ?>" data-id="<?= $notification->ID ?>">
                                <a href="<?= $notification->url ?>">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="b2b-notification-image">
                                                <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'b2b') ?>"/>
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
                        }
                    ?>
                </div>
                <?php
            } else {
                get_template_part('app/Views/template-parts/notifications/notification', 'empty');
            }


        ?>
    </div>
</div>
