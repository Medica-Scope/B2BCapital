/**
 * @Filename: notificationFront.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl       from './inc/UiCtrl';
import NhNotification from './modules/Notification';

class NhNotificationFront extends NhNotification
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            notifications: {
                parent: $(`.${KEY}-notifications`),
                bellBtn: $(`.${KEY}-notification-bell`),
                bell_counter: $(`.${KEY}-notification-count`),
                notification_group_container: $(`.${KEY}-notification-group-container`),
                my_notification_group_container: $(`.notifications-con .${KEY}-notifications-group`),
                notification_list: $(`.${KEY}-notification-list`),
                notification_group: $(`.${KEY}-notification-list .${KEY}-notifications-group`),
                clearBtn: $(`.${KEY}-notification-clear`),
                ItemClearBtn: $(`.${KEY}-item-notification-clear`),
                item: $(`.${KEY}-notification-item`),
                newItem: $(`.${KEY}-new-notification`),
                clearForm: $(`.${KEY}-notification-item-clear-form`),
                clearFormParent: $(`.notifications-con`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showNotifications();
        this.clearAll();
        this.loadMore();
        this.itemClear();
    }

    showNotifications()
    {
        let that           = this,
            $notifications = this.$el.notifications,
            ajaxRequests   = this.ajaxRequests;


        $notifications.bellBtn.on('click', $notifications.bellBtn.parent(), function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                newCount = $this.attr('data-count'),
                formData = { IDs: [] };

            $notifications.notification_list.toggle();

            if (parseInt(newCount) > 0) {
                $notifications.newItem.each(function (k, v) {
                    formData.IDs.push($(v).attr('data-id'));
                });

                if (formData.IDs.length > 0) {
                    if (typeof ajaxRequests.notifications !== 'undefined') {
                        ajaxRequests.notifications.abort();
                    }

                    that.read(formData, $notifications.notification_group);
                }
            }
        });

        $(document).on('click', function (e) {
            let $this = $(e.target);
            if ($notifications.notification_list.is(':visible') && $this.parents(".ninja-notifications").length !== 1 ) {
                $notifications.notification_list.hide();
            }
        })
    }

    clearAll()
    {
        let that           = this,
            $notifications = this.$el.notifications,
            ajaxRequests   = this.ajaxRequests;


        $notifications.clearBtn.on('click', $notifications.clearBtn.parent(), function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            if (typeof ajaxRequests.clear_notifications !== 'undefined') {
                ajaxRequests.clear_notifications.abort();
            }

            that.clear($notifications.notification_group_container);
        });
    }

    itemClear()
    {
            let that         = this,
            $notifications   = this.$el.notifications,
            ajaxRequests = this.ajaxRequests;
            
            $notifications.clearForm.on('submit', $notifications.clearFormParent, function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();
        
                // Abort any ongoing registration requests
                if (typeof ajaxRequests.clear_notifications !== 'undefined') {
                    ajaxRequests.clear_notifications.abort();
                }
                    that.item_clear(formData, $notifications.my_notification_group_container);
            });

        // $notifications.ItemClearBtn.on('click', $notifications.ItemClearBtn.parent(), function (e) {
        //     e.preventDefault();
        //     let $this = $(e.currentTarget);

        //     if (typeof ajaxRequests.clear_notifications !== 'undefined') {
        //         ajaxRequests.clear_notifications.abort();
        //     }

        //     that.item_clear($notifications.my_notification_group_container);
        // });
    }

    loadMore()
    {
        let that           = this,
            $notifications = this.$el.notifications,
            ajaxRequests   = this.ajaxRequests;

        var previousScrollPosition = 0;

        $notifications.notification_list.on('scroll', function (e) {
            e.preventDefault();
            let $this                 = $(e.currentTarget),
                formData              = { page: $notifications.notification_list.attr('data-page') },
                last                  = parseInt($notifications.notification_list.attr('data-last')),
                scrollTop             = $this.scrollTop(),
                scrollHeight          = $this.prop('scrollHeight'),
                clientHeight          = $this.prop('clientHeight'),
                currentScrollPosition = $(this).scrollTop();

            if (last === 0) {
                if (currentScrollPosition > previousScrollPosition) {
                    if (scrollTop + clientHeight >= scrollHeight - 2) {

                        if (typeof ajaxRequests.notificationsLoadMore !== 'undefined') {
                            ajaxRequests.notificationsLoadMore.abort();
                        }

                        that.loadMoreNotification(formData, $notifications.notification_group);
                    }
                }
            }

            previousScrollPosition = currentScrollPosition;

        });
    }
}

new NhNotificationFront();