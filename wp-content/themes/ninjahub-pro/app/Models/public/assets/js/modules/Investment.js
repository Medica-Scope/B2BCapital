/**
 * @Filename: Bidding.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* globals nhGlobals, KEY */
// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';
import _      from 'lodash';

class NhInvestment extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    createInvestment(formData, $el)
    {
        let that = this;

        this.ajaxRequests.createInvestment = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_create_investment_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.form.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.form);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el.form, res.msg, 'success');
                    $el.form.remove();
                    $('body').append(_.template($('#ninja_modal_opp_request_success').html())({
                        msg: res.msg,
                        button_text: res.data.button_text,
                    }));
                    let successModal = new bootstrap.Modal(document.getElementById('opportunitySuccess'), {});
                    successModal.show();
                    $('.btn-dismiss').click();
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                } else {
                    UiCtrl.notices($el.form, res.msg);
                }
                $el.form.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.form, false);
                // window.location.reload();
                that.createNewToken();
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
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

export default NhInvestment;
