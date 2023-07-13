/**
 * @Filename: Notification.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import B2b    from './B2b';

class B2bNotification extends B2b
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    read(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.notifications = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_read_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', res.data.count);
                    $(`.${KEY}-notification-count`).html(res.data.count);
                    UiCtrl.blockUI($el, false);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    clear($el)
    {
        let that                      = this;
        this.ajaxRequests.clear_notifications = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_clear_notifications_ajax`
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', 0);
                    $el.html(res.data.html);
                    UiCtrl.blockUI($el, false);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    loadMoreNotification(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.notificationsLoadMore = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_loadmore_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
                let $temp = $(`<div class="${KEY}-notification-item ${KEY}-notification-item-load"> <div class="row"> <div class="col-sm-2"> <div class="${KEY}-notification-image"> <span></span> </div> </div> <div class="col-sm-10"> <div class="${KEY}-notification-content"> <h6></h6> <p></p> <span></span> </div> </div> </div> </div>`)
                $(`.${KEY}-notification-item-load`).remove();
                $el.append($temp);
                $('.b2b-notification-list').animate({ scrollTop: $('.b2b-notification-list')[0].scrollHeight - 450 }, 250);
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-list`).attr('data-page', res.data.page);
                    $(`.${KEY}-notification-list`).attr('data-last', res.data.last);
                    $(`.${KEY}-notification-item-load`).remove();
                    $(`.${KEY}-notifications-group`).append(res.data.html);
                    $('.b2b-notification-list').animate({ scrollTop: $('.b2b-notification-list')[0].scrollHeight - 410 }, 250);

                    if (res.data.newIDs.length > 0) {
                        that.changeNewNotificationsStatus({IDs: res.data.newIDs});
                    }
                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    changeNewNotificationsStatus(formData)
    {
        let that                      = this;
        this.ajaxRequests.notifications = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_read_new_notifications_ajax`,
                data: formData,
            },
            beforeSend: function () {
            },
            success: function (res) {
                if (res.success) {
                    $(`.${KEY}-notification-bell`).attr('data-count', res.data.count);
                    $(`.${KEY}-notification-count`).html(res.data.count);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }
}

export default B2bNotification;
