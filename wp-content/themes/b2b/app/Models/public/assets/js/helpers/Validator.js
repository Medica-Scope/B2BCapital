/**
 * @Filename: Validator.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $            from 'jquery';
import _            from 'lodash';
import 'jquery-validation';
import intlTelInput from 'intl-tel-input';
import utils        from 'intl-tel-input/build/js/utils';

class B2bValidator
{
    constructor()
    {
        this.phrases = b2bGlobals.phrases;
        this.setDefaults();
        this.addMethods();
    }

    setDefaults()
    {
        $.extend($.validator.messages, {
            required: this.phrases.default,
            email: this.phrases.email,
            number: this.phrases.number,
            equalTo: this.phrases.equalTo,
            maxlength: $.validator.format(this.phrases.maxlength),
            minlength: $.validator.format(this.phrases.minlength),
            max: $.validator.format(this.phrases.max),
            min: $.validator.format(this.phrases.min)
        });

        $.validator.setDefaults({
            errorPlacement: function (label, element) {
                label.addClass(`${KEY}-error`);
                if (element.hasClass('btn-check')) {
                    label.insertBefore(element);
                } else {
                    label.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass(`${KEY}-error-input`);
            },
            unhighlight: function (element) {
                $(element).removeClass(`${KEY}-error-input`);
            },
        });


    }

    addMethods()
    {
        $.validator.addMethod('email_regex', function (value, element, regexp) {
            let re = new RegExp(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            return this.optional(element) || re.test(value);
        }, this.phrases.email_regex);
        $.validator.addMethod('phone_regex', function (value, element, regexp) {
            let re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, this.phrases.phone_regex);
        $.validator.addMethod('password_regex', function (value, element, regexp) {
            let re = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/);
            return this.optional(element) || re.test(value);
        }, this.phrases.pass_regex);
		$.validator.addMethod( "extension", function( value, element, param ) {
            if (typeof param === "string") {
                param = param.replace( /,/g, "|" )
            } else {
                let substr = value.split(".")[1];
                param = substr;
            }
			return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
		}, this.phrases.file_extension);
    }

    static initAuthValidation($el, type)
    {

        let that = this;

        const forms = {
            login: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_login: 'required',
                            user_password: 'required',
                        },
                    });
                }
            },
            register()
            {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            profile_picture: {
                                required: true,
                            },
                            user_role: {
                                required: true,
                            },
                            first_name: {
                                required: true,
                                maxlength: 50,
                            },
                            last_name: {
                                required: true,
                                maxlength: 50,
                            },
                            username: {
                                required: true,
                                maxlength: 50,
                            },
                            phone_number: {
                                required: true, // phone_regex: true,
                            },
                            user_email: {
                                required: true,
                                email_regex: true,
                            },
                            user_password1: {
                                required: true,
                                password_regex: true,
                            },
                            user_password2: {
                                required: true,
                                equalTo: $el.pass1,
                            },
                        },
                    });
                    const input = document.querySelector('#b2b_phone_number');
                    const iti   = intlTelInput(input, {
                        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js',
                        separateDialCode: true,
                        formatOnDisplay: true,
                        autoHideDialCode: true,
                        autoPlaceholder: 'polite', // allowDropdown: false
                        // any initialisation options go here
                    });
                    input.addEventListener('keyup', function () {
                        console.log(iti.get);
                    });
                }
            },
            rp_endEmail()
            {
            },
            rp()
            {
            },
            activateAccount()
            {
            },
            editAccount()
            {
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }
}

export default B2bValidator;
