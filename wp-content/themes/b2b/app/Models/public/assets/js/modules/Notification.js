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
                    UiCtrl.blockUI($el, false);
                }

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            }
        });
    }
}

export default B2bNotification;
