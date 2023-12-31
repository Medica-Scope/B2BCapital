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
import NhUiCtrl        from './inc/UiCtrl';
import NhOpportunity from './modules/Opportunity';

class NhOpportunityFront extends NhOpportunity
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {};
        this.initialization();
    }

    initialization()
    {
        this.adminStatus();
    }

    adminStatus() {
        let that          = this;
        setInterval(function (e) {
            $('input, textarea, button, select, button').attr('disabled', 'disabled');
            $('.acf-button').on('click', function (e) {
                e.preventDefault();
                return false;
            })
        }, 1)
    }

}

new NhOpportunityFront();