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
use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;

get_header();
global $user_ID;
$notifications_obj = new Nh_Notification();

$notifications = $notifications_obj->get_notifications();
$count         = $notifications['new_count'];
$found_posts   = $notifications['found_posts'];
?>

<main id="" class="">
    <div class="container">
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"><?= __('My Account', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja'); ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-widgets'))) ?>"><?= __('Widgets', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"><?= __('Notifications', 'ninja') ?></a>
        </nav>
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"><?= __('My Notifications', 'ninja') ?></a>
        </nav>

        <div class="notifications-con">
            <div class="ninja-notification-list container" data-page="2" data-last="<?= $found_posts > 10 ? 0 : 1 ?>">
                <div class="ninja-notification-group-container">
                    <?php
                    if (!empty($notifications['notifications'])) {
                    ?>
                        <h2><?= _e("Notification list", "ninja") ?></h2>
                        <div class="ninja-notification-clear-parent">
                            <button class="btn ninja-notification-clear">
                                <?= __('clear all') ?>
                            </button>
                        </div>
                        <div class="ninja-notifications-group">
                            <?php
                            foreach ($notifications['notifications'] as $notification) {
                            ?>
                                <div class="ninja-notification-item <?= $notification->new ? 'ninjanew-notification' : '' ?>" data-id="<?= $notification->ID ?>">
                                    <a href="<?= $notification->url ?>">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="ninja-notification-image">
                                                    <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'ninja') ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="ninja-notification-content">
                                                    <h6><?= $notification->title ?></h6>
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

        </div>

</main><!-- #main -->

<?php get_footer();
