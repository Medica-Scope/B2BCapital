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
import B2bValidator from './helpers/Validator';
import B2bUiCtrl    from './inc/UiCtrl';
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
                notification_list: $(`.${KEY}-notification-list`),
                clearBtn: $(`.${KEY}-notification-clear`),
                item: $(`.${KEY}-notification-item`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showNotifications();

    }

    showNotifications()
    {
        let that          = this,
            $notifications = this.$el.notifications,
            ajaxRequests    = this.ajaxRequests,
            formData = {IDs: []};





        $notifications.bellBtn.on('click', $notifications.bellBtn.parent(), function (e) {
            e.preventDefault();
            let $this             = $(e.currentTarget);

            $notifications.notification_list.toggle();

            if (typeof ajaxRequests.notifications !== 'undefined') {
                ajaxRequests.notifications.abort();
            }

            if ($this.valid()) {
                that.notifications(formData, $this);
            }
        });
    }
}

new B2bNotificationFront();