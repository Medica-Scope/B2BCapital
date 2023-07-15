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
import _      from 'lodash';

class B2bAuth extends B2b
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    registration(formData, $el)
    {
        let that                       = this;
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

    verification(formData, $el)
    {
        let that                       = this;
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
                $('input').prop('disabled', false);
                if (res.success) {
                    $($el).append(_.template($('#b2b_modal_auth_verif').html())({
                        msg: res.msg,
                        redirect_text: res.data.redirect_text,
                        redirect_url: res.data.redirect_url,
                    }));
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

    authentication(formData, $el)
    {
        let that                         = this;
        this.ajaxRequests.authentication = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_authentication_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.find('input, button')
                   .prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
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

    resendVerCode(formData, $el)
    {
        let that                        = this;
        this.ajaxRequests.resendVerCode = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_resendVerCode_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.closest('form').find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.closest('form'));
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el.closest('form'), res.msg, 'success');
                    $el.closest('form').find('.b2b-resend-code-patent').attr('data-expire', res.data.expire);
                    that.codeCountDown();
                } else {
                    $el.closest('form').find('.otp-digit').first().focus().select();
                    UiCtrl.notices($el.closest('form'), res.msg);
                }
                $el.hide();
                that.createNewToken();
                $el.closest('form').find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.closest('form'), false);
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

    resendAuthCode(formData, $el)
    {
        let that                         = this;
        this.ajaxRequests.resendAuthCode = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_resendAuthCode_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.closest('form').find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.closest('form'));
            },
            success: function (res) {
                $('input').prop('disabled', false);
                if (res.success) {
                    UiCtrl.notices($el.closest('form'), res.msg, 'success');
                    $el.closest('form').find('.b2b-resend-code-patent').attr('data-expire', res.data.expire);
                    that.codeCountDown();
                } else {
                    $el.closest('form').find('.otp-digit').first().focus().select();
                    UiCtrl.notices($el.closest('form'), res.msg);
                }
                $el.hide();
                that.createNewToken();
                $el.closest('form').find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.closest('form'), false);
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

    industries(formData, $el)
    {
        let that                     = this;
        this.ajaxRequests.industries = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_industries_ajax`,
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

    editProfile(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.editProfile = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_edit_profile_ajax`,
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
                    if (res.data.redirect) {
                        window.location.href = res.data.redirect_url;
                    }
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

    editPassword(formData, $el)
    {
        let that                       = this;
        this.ajaxRequests.editPassword = $.ajax({
            url: b2bGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_edit_password_ajax`,
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
                    window.location.href = res.data.redirect_url;
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

    codeCountDown()
    {
        let that              = this,
            $codeForm         = this.$el.codeForm,
            $resendCodeParent = $('.b2b-resend-code-patent'),
            $CodeCountDown    = $('<span class="b2b-code-count-down"></span>');

        $('.b2b-code-count-down').remove();
        $resendCodeParent.append($CodeCountDown);

        if ($CodeCountDown.length > 0) {
            // Given timestamp
            let givenTimestamp   = $resendCodeParent.attr('data-expire'),

                // Get the current timestamp
                currentTimestamp = Math.floor(Date.now() / 1000),

                // Calculate the difference in seconds
                difference       = givenTimestamp - currentTimestamp;

            if (difference <= 0) {
                $codeForm.resendCode.show();
                $CodeCountDown.hide();
            }

            // Update the countdown timer every second
            let countdownInterval = setInterval(function () {
                // Calculate minutes and seconds
                let minutes = Math.floor(difference / 60),
                    seconds = difference % 60;

                // Display the countdown
                $CodeCountDown.text(`${minutes}:${seconds}`);

                // Decrease the difference by 1 second
                difference--;

                // If the countdown is finished, clear the interval
                if (difference < 0) {
                    clearInterval(countdownInterval);
                    $codeForm.resendCode.show();
                    $CodeCountDown.hide();
                }
            }, 1000);
        }
    }
}

export default B2bAuth;
