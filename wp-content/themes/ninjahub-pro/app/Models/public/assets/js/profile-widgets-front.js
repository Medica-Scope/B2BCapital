/**
 * @Filename: profile-widgets-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator      from './helpers/Validator';
import NhUiCtrl         from './inc/UiCtrl';
import NhProfileWidgets from './modules/ProfileWidgets';
import Chart            from 'chart.js/auto';

class NhProfileWidgetsFront extends NhProfileWidgets
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            widgets: {
                container: $('.forex-canvas'),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.widgets();
    }

    widgets()
    {
        let that         = this,
            $widgets     = this.$el.widgets,
            ajaxRequests = this.ajaxRequests;


        // Abort any ongoing forgot password requests
        if (typeof ajaxRequests.getForexData !== 'undefined') {
            ajaxRequests.getForexData.abort();
        }

        $widgets.container.each(function (i, v) {
            let ajaxData = {
                id: $(v).attr('data-id'),
                recaptcha:  $(v).parent().find('#g-recaptcha-response').val()
            };

            that.getForexData(ajaxData, $widgets);
        }, $widgets.container);



    }
}

new NhProfileWidgetsFront();