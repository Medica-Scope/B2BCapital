/**
 * @Filename: Auth.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import B2b    from './B2b';

class B2bAuth extends B2b
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    login(formData, $el)
    {
        let that                = this;
        this.ajaxRequests.login = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_login_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button')
                   .prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input')
                    .prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button')
                   .prop('disabled', false);
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

    registration(formData, $el)
    {
        let that                = this;
        this.ajaxRequests.registration = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_registration_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button')
                   .prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input')
                    .prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button')
                   .prop('disabled', false);
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

    verification(formData, $el)
    {
        let that                = this;
        this.ajaxRequests.verification = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_verification_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button')
                   .prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input')
                    .prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }
                that.createNewToken();
                $el.find('input, button')
                   .prop('disabled', false);
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

    forgotPassword(formData, $el)
    {
        let that                 = this;
        this.ajaxRequests.forgot = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_forgot_password_ajax`,
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
                    $el[0].reset();
                    // window.location.href = res.data.redirect_url;
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

    changePassword(formData, $el)
    {
        let that                         = this;
        this.ajaxRequests.changePassword = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_change_password_ajax`,
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
                    $el[0].reset();
                    // window.location.href = res.data.redirect_url;
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

    createNewToken()
    {
        grecaptcha.ready(function () {
            grecaptcha.execute(b2bGlobals.publicKey).then(function (token) {
                $('#g-recaptcha-response').val(token);
            });
        });
    }

}

export default B2bAuth;
