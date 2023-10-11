/**
 * @Filename: appointment-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl       from './inc/UiCtrl';

class NhAppointmentFront
{
    constructor()
    {
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            appointments: {
                form: $(`.${KEY}_header_search`),
                parent: $(`.${KEY}_header_search`).parent(),
                icon: $(`.${KEY}-header-search-icon`),
                input: $(`#${KEY}_s`),
            },
        };

        this.initialization();
    }

    initialization()
    {
    }
}

new NhAppointmentFront();