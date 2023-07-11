<?php
    /**
     * @Filename: c1.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;

    global $user_ID;
    $notifications_obj = new B2b_Notification();

    $notifications = $notifications_obj->get_notifications();
    $count         = $notifications['new_count'];
?>

<div class="b2b-notifications">
    <div class="bell">
        <button class="btn b2b-notification-bell">
            <span class="b2b-notification-count"><?= $count ?></span>
            <i class="fa-regular fa-bell"></i>
        </button>
    </div>
    <div class="b2b-notification-list container">
        <?php
            if (!empty($notifications)) {
                ?>
                <div class="notification-clear-parent">
                    <button class="btn b2b-notification-clear">
                        <?= __('clear all') ?>
                    </button>
                </div>
                <?php
            }
        ?>
        <?php
            if (!empty($notifications)) {
                foreach ($notifications['notifications'] as $notification) {
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
                }
            } else {
                ?>
                <div class="b2b-notification-group">
                    <p><?= __('You have no new notifications', 'b2b') ?></p>
                </div>
                <?php
            }


        ?>
    </div>
</div>
