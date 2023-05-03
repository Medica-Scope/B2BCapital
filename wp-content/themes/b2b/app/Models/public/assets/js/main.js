/**
 * @Filename: main.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import B2bFunctions from './inc/Functions';
import B2bValidator from './helpers/Validator';

class B2bMain {
    constructor() {
        window.KEY = b2bGlobals.domain_key;
        const Functions = new B2bFunctions();
        const Validator = new B2bValidator();
    }
}


(function ($) {
    'use strict';

    $(document).ready( function (e) {

        // IMPORTANT NOTICE

        if (b2bGlobals.environment !== 'development') {
            console.log('%cStop!', 'color: red; font-size: 50px; -webkit-text-stroke: 2px black; font-weight: bold;');
            console.log("%cThis browser feature is intended for developers. If someone told you to copy-paste something here to enable a feature or \"hack\" someone's account, it is a scam and will give them access to your account and personal information.", 'font-size: 18px; font-weight:bold');
        }

        const B2b = new B2bMain();

    });

    $(window).on('load', function () {

    });

})($);
