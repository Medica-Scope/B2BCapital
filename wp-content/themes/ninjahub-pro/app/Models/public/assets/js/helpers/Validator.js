/**
 * @Filename: Validator.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $            from 'jquery';
import _            from 'lodash';
import 'jquery-validation';
import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/build/js/utils.js';

class NhValidator
{
    constructor()
    {
        this.phrases = nhGlobals.phrases;
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
            min: $.validator.format(this.phrases.min),
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
            success: function (label, element) {
                // Add a class to the valid input element
                $(element).addClass(`${KEY}-valid-input`);
            }
        });


    }

    addMethods()
    {
        $.validator.addMethod('email_regex', function (value, element, regexp) {
            let re = new RegExp(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            // let re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, this.phrases.email_regex);
        $.validator.addMethod('phone_regex', function (value, element, regexp) {
            let re = new RegExp(/^\+?\d{7,16}$/);
            // let re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, this.phrases.phone_regex);
        $.validator.addMethod('intlTelNumber', function (value, element, param) {
            let iti = window.ITIOBJ[param.itiObj];
            return this.optional(element) || iti.isValidNumber();
        }, this.phrases.intlTelNumber);
        $.validator.addMethod('password_regex', function (value, element, regexp) {
            let re = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/);
            return this.optional(element) || re.test(value);
        }, this.phrases.pass_regex);
        $.validator.addMethod('extension', function (value, element, param) {
            if (typeof param === 'string') {
                param = param.replace(/,/g, '|');
            } else {
                let substr = value.split('.')[1];
                param      = substr;
            }
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
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
                            user_password: {
                                required: true,
                                maxlength: 26,
                            },
                        },
                    });
                }
            },
            industries: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            'industries': {
                                required: true,
                                minlength: 1,
                            },
                            'expected_value': {
                                required: true
                            },
                            'entity_legal_type': {
                                required: true
                            },
                        },
                    });
                }
            },
            registration: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            first_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150,
                            },
                            last_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150,
                            },
                            phone_number: {
                                required: true,
                                intlTelNumber: { itiObj: 'registration' },
                                maxlength: 50,
                            },
                            user_email: {
                                required: true,
                                email_regex: true,
                                minlength: 10,
                                maxlength: 125,
                            },
                            user_password: {
                                required: true,
                                password_regex: true,
                            },
                            confirm_password: {
                                required: true,
                                equalTo: $el.user_password,
                            },
                            user_type: {
                                required: true,
                            },
                            verification_type: {
                                required: true,
                            },
                        },
                    });
                }
            },
            verification: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            code1: {
                                required: true,
                                maxlength: 1,
                            },
                            code2: {
                                required: true,
                                maxlength: 1,
                            },
                            code3: {
                                required: true,
                                maxlength: 1,
                            },
                            code4: {
                                required: true,
                                maxlength: 1,
                            },
                        },
                    });
                }
            },
            forgotPassword: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_email_phone: {
                                required: true,
                                email_regex: true,
                            },
                        },
                    });
                }
            },
            change_password: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            user_password: {
                                required: true,
                                password_regex: true,
                            },
                            user_password_confirm: {
                                required: true,
                                equalTo: $el.user_password,
                            },
                        },
                    });
                }
            },
            editProfile: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        ignore: ':hidden:not(select)',
                        rules: {
                            first_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150,
                            },
                            last_name: {
                                required: true,
                                minlength: 2,
                                maxlength: 150,
                            },
                            phone_number: {
                                required: true,
                                intlTelNumber: { itiObj: 'editProfile' },
                                maxlength: 50,
                            },
                            user_email: {
                                required: true,
                                email_regex: true,
                                minlength: 10,
                                maxlength: 125,
                            },
                            site_language: {
                                required: true,
                            },
                            widget_list: {
                                required: true,
                            },
                            preferred_opportunities_cat_list: {
                                required: true,
                            },
                            preferred_articles_cat_list: {
                                required: true,
                            },
                            verification_type: {
                                required: true,
                            },
                        },
                    });
                }
            },
            editPassword: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            current_password: {
                                required: true,
                            },
                            new_password: {
                                required: true,
                                password_regex: true,
                            },
                            confirm_new_password: {
                                required: true,
                                equalTo: $el.new_password,
                            },
                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }

    static initOpportunityValidation($el, type)
    {

        let that = this;

        const forms = {
            createOpportunity: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            project_name: {
                                required: true,
                                maxlength: 150,
                                minlength: 5,
                            },
                            category: {
                                required: true,
                            },
                            description: {
                                required: true,
                                maxlength: 1500,
                                minlength: 50,
                            },
                            short_description: {
                                required: true,
                                maxlength: 100,
                                minlength: 30,
                            },
                            opportunity_type: {
                                required: true,
                            },
                            start_bidding_amount: {
                                required: true,
                            },
                            target_amount: {
                                required: true,
                            },
                            project_phase: {
                                required: true,
                            },
                            project_start_date: {
                                required: true,
                            },
                            project_assets_amount: {
                                required: true,
                            },
                            project_yearly_cashflow_amount: {
                                required: true,
                            },
                            project_yearly_net_profit_amount: {
                                required: true,
                            },
                            media_file: {
                                required: true,
                            },
                            date_founded: {
                                required: true,
                            },
                            asking_price_in_usd: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            number_of_customers: {
                                required: true,
                                number: true,
                                step: 1,
                                min: 0,
                            },
                            business_team_size: {
                                required: true,
                                number: true,
                                step: 1,
                                min: 0,
                            },
                            location: {
                                required: true,
                            },
                            net_profit: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            valuation_in_usd: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            shares_to_be_sold_percentage: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                                max: 100,
                            },
                            usd_exchange_rate_used_in_conversion: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            annual_accounting_revenue: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            annual_growth_rate_percentage: {
                                required: true,
                                max: 100,
                            },
                            annual_growth_rate: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            required_investment_amount: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            currency: {
                                required: true,
                            },
                            investment_term: {
                                required: true,
                            },
                            expected_returns: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: 0,
                            },
                            risk_level: {
                                required: true,
                            },
                            legal_structure: {
                                required: true,
                            },
                            regulatory_compliance: {
                                required: true,
                            },
                            tech_stack_this_product_is_built_on: {
                                required: true,
                            },
                            product_competitors: {
                                required: true,
                            },
                            sectors: {
                                required: true,
                            },
                            type_of_company: {
                                required: true,
                            },
                            business_model: {
                                required: true,
                            },
                        },
                    });
                }
            },
            filterOpportunity: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            opportunity_type: {
                                required: false,
                            },
                            opportunity_status: {
                                required: false,
                            },

                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }

    static initAppointmentsValidation($el, type)
    {

        let that = this;

        const forms = {
            createAppointment: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            name: {
                                required: true,
                                maxlength: 150,
                                minlength: 2,
                            },
                            email: {
                                required: true,
                                email_regex: true,
                                minlength: 10,
                                maxlength: 125,
                            },
                            mobile: {
                                required: true,
                                phone_regex: true,
                            },
                            timeslot: {
                                required: true,
                            },
                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }

    static initBiddingValidation($el, type)
    {

        let that = this;

        const forms = {
            createBid: function () {
                if ($el.form.length > 0) {
                    $el.form.validate({
                        normalizer: function (value) {
                            return $.trim(value);
                        },
                        rules: {
                            bid_amount: {
                                required: true,
                                number: true,
                                step: 0.1,
                                min: parseFloat($el.start_bid.val())
                            }
                        },
                    });
                }
            },
        };

        if (_.has(forms, type)) {
            _.invoke(forms, type);
        }
    }


}

export default NhValidator;
