/**
 * @Filename: notificationFront.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import B2bValidator    from './helpers/Validator';
import B2bUiCtrl       from './inc/UiCtrl';
import B2bNotification from './modules/Notification';

class B2bNotificationFront extends B2bNotification
{
    constructor()
    {
        super();
        this.UiCtrl = new B2bUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            notifications: {
                parent: $(`.${KEY}-notifications`),
                bellBtn: $(`.${KEY}-notification-bell`),
                bell_counter: $(`.${KEY}-notification-count`),
                notification_group_container: $(`.${KEY}-notification-group-container`),
                notification_list: $(`.${KEY}-notification-list`),
                notification_group: $(`.${KEY}-notifications-group`),
                clearBtn: $(`.${KEY}-notification-clear`),
                item: $(`.${KEY}-notification-item`),
                newItem: $(`.${KEY}-new-notification`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showNotifications();
        this.clearAll();
        this.loadMore();
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

new B2bNotificationFront();