/**
 * @Filename: Opportunity.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import B2b    from './B2b';

class B2bOpportunity extends B2b
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }
}

export default B2bOpportunity;
