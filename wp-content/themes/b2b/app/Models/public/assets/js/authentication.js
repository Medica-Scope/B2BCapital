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


class B2bAuthentication extends B2bAuth
{
    constructor()
    {
        super();
        this.UiCtrl = new B2bUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            login: {
                form: $(`#${KEY}_login_form`),
                parent: $(`#${KEY}_login_form`).parent(),
            },
            registration: {
                form: $(`#${KEY}_registration_form`),
                parent: $(`#${KEY}_registration_form`).parent(),
                user_password: $(`#${KEY}_user_password`),
            },
            verification: {
                form: $(`#${KEY}_verification_form`),
                parent: $(`#${KEY}_verification_form`).parent(),
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
        this.loginFront();
        this.registrationFront();
        this.verificationFront();
        this.forgotPasswordFront();
        this.changePasswordFront();
        this.showPassword();
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

    registrationFront()
    {
        let that          = this,
            $registration = this.$el.registration,
            ajaxRequests  = this.ajaxRequests;

        B2bValidator.initAuthValidation($registration, 'registration');

        $registration.form.on('submit', $registration.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            if (typeof ajaxRequests.registration !== 'undefined') {
                ajaxRequests.registration.abort();
            }

            if ($this.valid()) {
                that.registration(formData, $this);
            }

        });
    }

    verificationFront()
    {
        let that          = this,
            $verification = this.$el.verification,
            ajaxRequests  = this.ajaxRequests;

        B2bValidator.initAuthValidation($verification, 'verification');

        $verification.form.on('submit', $verification.parent, function (e) {
            e.preventDefault();
            let $this           = $(e.currentTarget),
                formData        = $this.serializeObject();

            if (typeof ajaxRequests.verification !== 'undefined') {
                ajaxRequests.verification.abort();
            }

            if ($this.valid()) {
                that.verification(formData, $this);
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
}

new B2bAuthentication();