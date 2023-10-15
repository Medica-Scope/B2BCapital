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
        // this.adminStatus();
    }

    adminStatus() {
        let that          = this;
        $('select[name="_status"]').append('<option value="new">New</option>');
        $('select[name="_status"]').append('<option value="approved">Approved</option>');
        $('select[name="_status"]').append('<option value="held">Held</option>');
        $('select[name="_status"]').append('<option value="review">Review</option>');
        $('select[name="_status"]').append('<option value="verified">Verified</option>');
        $('select[name="_status"]').append('<option value="seo_verified">SEO Verified</option>');
        $('select[name="_status"]').append('<option value="translated">Translated</option>');
        $('select[name="_status"]').append('<option value="success">Success</option>');
    }

}

new NhOpportunityFront();