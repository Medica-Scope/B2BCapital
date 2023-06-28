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
import Choices      from 'choices.js';

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
                resendCodeParent: $(`#${KEY}_verification_form`).find('.b2b-resend-code-patent'),
                resendCode: $(`#${KEY}_verification_form`).find('.b2b-resend-code'),
                CodeCountDown: $(`#${KEY}_verification_form`).find('.b2b-code-count-down'),
                verificationSubmit: $(`#${KEY}_verification_form`).find('#verificationSubmit'),
            },
            authentication: {
                form: $(`#${KEY}_authentication_form`),
                parent: $(`#${KEY}_authentication_form`).parent(),
                otpDigit: $(`#${KEY}_authentication_form`).find('.otp-digit input'),
                resendCodeParent: $(`#${KEY}_authentication_form`).find('.b2b-resend-code-patent'),
                resendCode: $(`#${KEY}_authentication_form`).find('.b2b-resend-code'),
                CodeCountDown: $(`#${KEY}_authentication_form`).find('.b2b-code-count-down'),
                authenticationSubmit: $(`#${KEY}_authentication_form`).find('#authenticationSubmit'),
            },
            codeForm: {
                resendCode: $('.b2b-resend-code'),
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
            editProfile: {
                form: $(`#${KEY}_edit_profile_form`),
                parent: $(`#${KEY}_edit_profile_form`).parent(),
                selectBoxes: $('select'),
            },
            editPassword: {
                form: $(`#${KEY}_edit_password_form`),
                parent: $(`#${KEY}_edit_password_form`).parent(),
                new_password: $(`#${KEY}_new_password`),
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
        this.authenticationFront();
        this.industriesFront();
        this.forgotPasswordFront();
        this.changePasswordFront();
        this.editProfileFront();
        this.editPasswordFront();
        this.showPassword();
        this.codeCountDown();

    }

    registrationFront()
    {
        let that          = this,
            $registration = this.$el.registration,
            ajaxRequests  = this.ajaxRequests;

        if ($('#b2b_phone_number').length > 0) {
            const input = $('#b2b_phone_number')[0];

            window.ITIOBJ.registration = intlTelInput(input, {
                initialCountry: 'EG',
                separateDialCode: true,
                autoInsertDialCode: true,
                allowDropdown: true,
                utilsScript: 'node_modules/intl-tel-input/build/js/utils.js',
            });
        }

        B2bValidator.initAuthValidation($registration, 'registration');

        $registration.form.on('submit', $registration.parent, function (e) {
            e.preventDefault();
            let $this             = $(e.currentTarget),
                formData          = $this.serializeObject();
            formData.phone_number = window.ITIOBJ.registration.getNumber().replace('+', '');

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

        $verification.otpDigit.on('click', $verification.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $this.select();
        });
        $verification.otpDigit.on('keyup', $verification.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            if ($this.val().length == $this.attr('maxlength')) {
                if ($this.closest('.otp-digit').next('.otp-digit').find('input').length > 0) {
                    $this.closest('.otp-digit').next('.otp-digit').find('input').focus().select();
                } else {
                    $verification.verificationSubmit.trigger('click');
                }
            } else {
                $this.closest('.otp-digit').prev('.otp-digit').find('input').focus().select();
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
                formObj  = $verification.form.serializeObject(),
                formData = {
                    'g-recaptcha-response': formObj['g-recaptcha-response'],
                };

            if (typeof ajaxRequests.resendVerCode !== 'undefined') {
                ajaxRequests.resendVerCode.abort();
            }

            that.resendVerCode(formData, $this);


        });
    }

    authenticationFront()
    {
        let that            = this,
            $authentication = this.$el.authentication,
            ajaxRequests    = this.ajaxRequests;

        $authentication.otpDigit.on('click', $authentication.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $this.select();
        });
        $authentication.otpDigit.on('keyup', $authentication.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            if ($this.val().length == $this.attr('maxlength')) {
                if ($this.closest('.otp-digit').next('.otp-digit').find('input').length > 0) {
                    $this.closest('.otp-digit').next('.otp-digit').find('input').focus().select();
                } else {
                    $authentication.authenticationSubmit.trigger('click');
                }
            } else {
                $this.closest('.otp-digit').prev('.otp-digit').find('input').focus().select();
            }

        });

        B2bValidator.initAuthValidation($authentication, 'authentication');

        $authentication.form.on('submit', $authentication.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.authentication !== 'undefined') {
                ajaxRequests.authentication.abort();
            }

            if ($this.valid()) {
                that.authentication(formData, $this);
            }

        });

        $authentication.resendCode.on('click', $authentication.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formObj  = $authentication.form.serializeObject(),
                formData = {
                    'g-recaptcha-response': formObj['g-recaptcha-response'],
                };

            if (typeof ajaxRequests.resendAuthCode !== 'undefined') {
                ajaxRequests.resendAuthCode.abort();
            }

            that.resendAuthCode(formData, $this);
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

    editProfileFront()
    {
        let that         = this,
            $editProfile = this.$el.editProfile,
            $selectBoxes = $editProfile.selectBoxes,
            ajaxRequests = this.ajaxRequests;

        // TODO:: Implement after design
        // $selectBoxes.each(function (i, v) {
        //     new Choices(v, {
        //         itemSelectText: b2bGlobals.phrases.choices_select,
        //         noChoicesText: b2bGlobals.phrases.noChoicesText,
        //         removeItemButton: true,
        //         allowHTML: true,
        //     });
        // });

        if ($('#b2b_phone_number').length > 0) {
            const input = $('#b2b_phone_number')[0];

            window.ITIOBJ.editProfile = intlTelInput(input, {
                initialCountry: 'EG',
                separateDialCode: true,
                autoInsertDialCode: true,
                allowDropdown: true,
                utilsScript: 'node_modules/intl-tel-input/build/js/utils.js',
            });
        }

        B2bValidator.initAuthValidation($editProfile, 'editProfile');

        $editProfile.form.on('submit', $editProfile.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();
            formData.phone_number = window.ITIOBJ.registration.getNumber().replace('+', '');

            if (typeof ajaxRequests.editProfile !== 'undefined') {
                ajaxRequests.editProfile.abort();
            }

            if ($this.valid()) {
                that.editProfile(formData, $this);
            }

        });
    }

    editPasswordFront()
    {
        let that          = this,
            $editPassword = this.$el.editPassword,
            ajaxRequests  = this.ajaxRequests;

        B2bValidator.initAuthValidation($editPassword, 'editPassword');

        $editPassword.form.on('submit', $editPassword.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.editPassword !== 'undefined') {
                ajaxRequests.editPassword.abort();
            }

            if ($this.valid()) {
                that.editPassword(formData, $this);
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
            $this.removeClass('fa-solid fa-eye');
            $this.addClass('fa-sharp fa-solid fa-eye-slash');
            if ($($target_element).attr('type') === 'password') {
                $($target_element).attr('type', 'text');
                $this.removeClass('fa-sharp fa-solid fa-eye-slash');
                $this.addClass('fa-solid fa-eye');
            } else {
                $($target_element).attr('type', 'password');
                $this.removeClass('fa-solid fa-eye');
                $this.addClass('fa-sharp fa-solid fa-eye-slash');
            }
        });
    }
}

new B2bAuthentication();