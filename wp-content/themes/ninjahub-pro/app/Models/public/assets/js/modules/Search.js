/**
 * Filename: Search.js
 * Description:
 * User: Ahmed Gamal
 * Date: 7/9/2022
 */

/* globals nhGlobals, KEY */
// import theme 3d party modules
import $        from 'jquery';
import NhUiCtrl from '../inc/UiCtrl';
import Nh       from './Nh';

class NhSearch extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    search(formData, type, $el)
    {
        let that = this;

        this.ajaxRequests.search = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_search_ajax`,
                s: formData,
                type: type,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                NhUiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                $el.find('input, button').prop('disabled', false);
                NhUiCtrl.blockUI($el, false);
                $('.search-con').find('.search-body').html(res.data.html);
                $('.search-body').show();
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            },
        });
    }

    loadmore(formData, $el)
    {
        let that       = this,
            loopParent = $(`.search-success`);

        this.ajaxRequests.searchLoadmore = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_search_loadmore_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.parent.find('input, button').prop('disabled', true);
                NhUiCtrl.beforeSendPrepare($(`.search-success`));
            },
            success: function (res) {

                $('input').prop('disabled', false);
                $el.parent.find('input, button').prop('disabled', false);

                NhUiCtrl.blockUI(loopParent, false);
                if (res.data.last) {
                    loopParent.attr('data-last', 'true');
                }
                loopParent.append(res.data.html);
                loopParent.attr('data-page', Number(loopParent.attr('data-page')) + 1);

            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            },
        });
    }

    // Method for creating a new token
    createNewToken()
    {
        grecaptcha.ready(function () {
            grecaptcha.execute(nhGlobals.publicKey).then(function (token) {
                $('input[name="g-recaptcha-response"]').val(token);
            });
        });
    }
}

export default NhSearch;
