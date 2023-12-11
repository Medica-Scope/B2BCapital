/**
 * @Filename: investment-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator   from './helpers/Validator';
import NhUiCtrl      from './inc/UiCtrl';
import NhInvestment from './modules/Investment';

class NhInvestmentFront extends NhInvestment
{
    constructor()
    {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            investment: {
                form: $(`#${KEY}_create_investment_form`),
                parent: $(`#${KEY}_create_investment_form`).parent(),
                investments_numbers: $(`.investments-numbers`),
                modalFormSubmit: $(`#modalFormSubmit`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.CreateInvestmentFront();
    }

    CreateInvestmentFront()
    {
        let that         = this,
            $investment = this.$el.investment,
            createInvestModal  = document.getElementById('createInvestModal'),
            ajaxRequests = this.ajaxRequests;


        $investment.modalFormSubmit.on('click', function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                $target = $this.attr('data-target');

            $('#' + $target).trigger('click');
        })

        if (createInvestModal !== null) {
            createInvestModal.addEventListener('shown.bs.modal', function () {
                that.createNewToken();
            });
        }

        // Handle form submission
        $investment.form.on('submit', $investment.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing forgot password requests
            if (typeof ajaxRequests.createInvestment !== 'undefined') {
                ajaxRequests.createInvestment.abort();
            }

            // Validate the form and perform forgot password request if valid
            if ($this.valid()) {
                that.createInvestment(formData, $investment);
            }
        });

    }
}

new NhInvestmentFront();