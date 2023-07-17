/**
 * @Filename: opportunity-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import B2bValidator    from './helpers/Validator';
import B2bUiCtrl        from './inc/UiCtrl';
import B2bOpportunity from './modules/Opportunity';

class B2bOpportunityFront extends B2bOpportunity
{
    constructor()
    {
        super();
        this.UiCtrl = new B2bUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            opportunity: {
                form: $(`#${KEY}_create_opportunity_form`),
                parent: $(`#${KEY}_create_opportunity_form`).parent(),
            },
        };

        this.initialization();
    }

    initialization()
    {
    }
}

new B2bOpportunityFront();