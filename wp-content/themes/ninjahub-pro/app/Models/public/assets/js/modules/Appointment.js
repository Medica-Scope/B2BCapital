/**
 * @Filename: Appointment.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* globals nhGlobals, KEY */
// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';

class NhAppointment extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    createAppointment(formData, $el)
    {
        let that = this;

        this.ajaxRequests.createAppointment = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_create_appointment_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el, false);
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

export default NhAppointment;
