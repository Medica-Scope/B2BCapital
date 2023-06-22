/**
 * @Filename: authentication.js
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
import B2bAuth      from './modules/Auth';
import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/build/js/utils.js';

class B2bAuthentication extends B2bAuth
{
    constructor()
    {
        super();
        this.UiCtrl = new B2bUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            registration: {
                form: $(`#${KEY}_registration_form`),
                parent: $(`#${KEY}_registration_form`).parent(),
                user_password: $(`#${KEY}_user_password`),
            },
            login: {
                form: $(`#${KEY}_login_form`),
                parent: $(`#${KEY}_login_form`).parent(),
            },
            verification: {
                form: $(`#${KEY}_verification_form`),
                parent: $(`#${KEY}_verification_form`).parent(),
                otpDigit: $(`#${KEY}_verification_form`).find('.otp-digit input'),
                resendCode: $(`#${KEY}_verification_form`).find('.b2b-resend-code'),
            },
            industries: {
                form: $(`#${KEY}_industries_form`),
                tags: $(`#${KEY}_industries_form`).find(`.industries-tags`),
                selectedNumbersSpan: $(`#${KEY}_industries_form`).find(`.selected-number`),
                showTags: $(`#${KEY}_industries_form`).find(`.show-tags`),
                parent: $(`#${KEY}_industries_form`).parent(),
            },
            forgot: {
                form: $(`#${KEY}_forgot_form`),
                parent: $(`#${KEY}_forgot_form`).parent(),
            },
            change_password: {
                form: $(`#${KEY}_change_password_form`),
                parent: $(`#${KEY}_change_password_form`).parent(),
                user_password: $(`#${KEY}_user_password`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.registrationFront();
        this.loginFront();
        this.verificationFront();
        this.industriesFront();
        this.forgotPasswordFront();
        this.changePasswordFront();
        this.showPassword();
    }

    registrationFront()
    {
        let that          = this,
            $registration = this.$el.registration,
            ajaxRequests  = this.ajaxRequests;

        if ($("#b2b_phone_number").length > 0) {
            const input = $("#b2b_phone_number")[0];

            window.ITIOBJ.registration = intlTelInput(input, {
                initialCountry: "EG",
                separateDialCode:true,
                autoInsertDialCode:true,
                allowDropdown:true,
                utilsScript: 'node_modules/intl-tel-input/build/js/utils.js'
            });
        }

        B2bValidator.initAuthValidation($registration, 'registration');

        $registration.form.on('submit', $registration.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();
            formData.phone_number = window.ITIOBJ.registration.getNumber().replace("+", "");

            if (typeof ajaxRequests.registration !== 'undefined') {
                ajaxRequests.registration.abort();
            }

            if ($this.valid()) {
                that.registration(formData, $this);
            }

        });
    }

    loginFront()
    {
        let that         = this,
            $login       = this.$el.login,
            ajaxRequests = this.ajaxRequests;

        B2bValidator.initAuthValidation($login, 'login');

        $login.form.on('submit', $login.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.login !== 'undefined') {
                ajaxRequests.login.abort();
            }

            if ($this.valid()) {
                that.login(formData, $this);
            }

        });
    }

    verificationFront()
    {
        let that          = this,
            $verification = this.$el.verification,
            ajaxRequests  = this.ajaxRequests;

        $verification.otpDigit.on('keyup', $verification.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            if ($this.val().length == $this.attr('maxLength')) {
                $this.closest('.otp-digit').next('.otp-digit').find('input').focus();
            }
        });

        B2bValidator.initAuthValidation($verification, 'verification');

        $verification.form.on('submit', $verification.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.verification !== 'undefined') {
                ajaxRequests.verification.abort();
            }

            if ($this.valid()) {
                that.verification(formData, $this);
            }

        });


        $verification.resendCode.on('click', $verification.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formObj = $verification.form.serializeObject(),
                formData = {
                    'g-recaptcha-response': formObj['g-recaptcha-response']
                };

            if (typeof ajaxRequests.resendVerCode !== 'undefined') {
                ajaxRequests.resendVerCode.abort();
            }

            console.log(formData['g-recaptcha-response']);
            that.resendVerCode(formData, $this);


        });
    }

    industriesFront()
    {
        let that         = this,
            $industries  = this.$el.industries,
            $tagsInputs  = $industries.tags.find('input'),
            $showTags    = $industries.showTags,
            ajaxRequests = this.ajaxRequests;

        $tagsInputs.on('change', $industries.form, function (e) {
            let $this        = $(e.currentTarget),
                checkedCount = $industries.tags.find(':checked').length;
            $industries.selectedNumbersSpan.html(checkedCount);
        });

        $showTags.on('click', $industries.form, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $('.hidden-tag').removeClass('hidden-tag');
            $this.remove();

        });
        B2bValidator.initAuthValidation($industries, 'industries');

        $industries.form.on('submit', $industries.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.industries !== 'undefined') {
                ajaxRequests.industries.abort();
            }

            if ($this.valid()) {
                that.industries(formData, $this);
            }

        });
    }

    forgotPasswordFront()
    {
        let that         = this,
            $forgot      = this.$el.forgot,
            ajaxRequests = this.ajaxRequests;

        B2bValidator.initAuthValidation($forgot, 'forgotPassword');

        $forgot.form.on('submit', $forgot.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.forgot !== 'undefined') {
                ajaxRequests.forgot.abort();
            }

            if ($this.valid()) {
                that.forgotPassword(formData, $this);
            }

        });
    }

    changePasswordFront()
    {

        let that             = this,
            $change_password = this.$el.change_password,
            ajaxRequests     = this.ajaxRequests;

        B2bValidator.initAuthValidation($change_password, 'change_password');

        $change_password.form.on('submit', $change_password.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.changePassword !== 'undefined') {
                ajaxRequests.changePassword.abort();
            }

            if ($this.valid()) {
                that.changePassword(formData, $this);
            }

        });
    }

    showPassword()
    {
        $('.showPassIcon').on('click', function (e) {
            let $this           = $(e.currentTarget),
                $target_element = $this.attr('data-target');
            if ($target_element.attr('type') === 'password') {
                $target_element.attr('type', 'text');
            } else {
                $target_element.attr('type', 'password');
            }
        });
    }
}

new B2bAuthentication();