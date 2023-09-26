/**
 * @Filename: opportunity-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl        from './inc/UiCtrl';
import NhOpportunity from './modules/Opportunity';
import intlTelInput from 'intl-tel-input';

class NhOpportunityFront extends NhOpportunity
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            opportunity: {
                form: $(`#${KEY}_create_opportunity_form`),
                parent: $(`#${KEY}_create_opportunity_form`).parent(),
                category: $(`#${KEY}_category`).parent(),
                opportunity_type: $(`#${KEY}_opportunity_type`).parent(),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.CreateOpportunityFront();
        this.CreateOpportunityFormFieldsFront();
    }

    CreateOpportunityFormFieldsFront() {
        let that          = this,
            $opportunity = this.$el.opportunity;

        $opportunity.category.on('change', $opportunity.parent, function (e) {
            let $this = $(e.currentTarget);

            console.log($this.find(":selected").val());
        });

        $opportunity.opportunity_type.on('change', $opportunity.parent, function (e) {
            let $this = $(e.currentTarget);

            console.log($this.find(":selected").val());
        });
    }

    CreateOpportunityFront() {
        let that          = this,
            $opportunity = this.$el.opportunity,
            ajaxRequests  = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAuthValidation($opportunity, 'createOpportunity');

        // Handle form submission
        $opportunity.form.on('submit', $opportunity.parent, function (e) {
            e.preventDefault();
            let $this             = $(e.currentTarget),
                formData          = $this.serializeObject();

            // Abort any ongoing registration requests
            if (typeof ajaxRequests.createOpportunity !== 'undefined') {
                ajaxRequests.createOpportunity.abort();
            }

            // Validate the form and perform registration if valid
            if ($this.valid()) {
                // that.createOpportunity(formData, $this);
            }
        });
    }
}

new NhOpportunityFront();