/**
 * @Filename: Opportunity.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';

class NhOpportunity extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    // getNhACFCusomForm(formData, $el) {
    //     let that = this;
    //     // Creating an AJAX request for login
    //     this.ajaxRequests.getForm = $.ajax({
    //         url: nhGlobals.ajaxUrl,
    //         type: 'POST',
    //         data: {
    //             action: `${KEY}_acf_custom_form_ajax`,
    //             data: formData,
    //         },
    //         beforeSend: function() {
    //             $el.find('input, button').prop('disabled', true);
    //             UiCtrl.beforeSendPrepare($el);
    //         },
    //         success: function(res) {
    //             $('input').prop('disabled', false);
    //
    //             if (res.success) {
    //                 UiCtrl.notices($el, res.msg, 'success');
    //             } else {
    //                 UiCtrl.notices($el, res.msg);
    //             }
    //
    //             $('.nh-custom-form').show();
    //             $('.nh-acf-form').html(res.data.html);
    //
    //             // $el.find('input, button').prop('disabled', false);
    //
    //             UiCtrl.blockUI($el, false);
    //         },
    //         error: function(xhr) {
    //             let errorMessage = `${xhr.status}: ${xhr.statusText}`;
    //             if (xhr.statusText !== 'abort') {
    //                 console.error(errorMessage);
    //             }
    //         },
    //     });
    // }

    createOpportunity(formData, $el) {
        let that = this;
        // Creating an AJAX request for login
        this.ajaxRequests.getForm = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_create_opportunity_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
                $('input').prop('disabled', false);

                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }

                $el.find('input, button').prop('disabled', false);
                that.createNewToken();
                UiCtrl.blockUI($el, false);
            },
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for creating a new token
    createNewToken() {
        grecaptcha.ready(function() {
            grecaptcha.execute(nhGlobals.publicKey).then(function(token) {
                $('#g-recaptcha-response').val(token);
            });
        });
    }
}

export default NhOpportunity;
