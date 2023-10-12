/**
 * @Filename: Service.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023

/* globals nhGlobals, KEY */
// import theme 3d party modules
import $ from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh from './Nh';

class NhService extends Nh {
    constructor() {
        super();
        this.ajaxRequests = {};
    }

    service(formData, type, $el) {
        let that = this;

        this.ajaxRequests.search = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_search_ajax`,
                s: formData,
                type: type
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
                $('.search-con').find('.search-body').html(res.data.html);
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

export default NhService;
