/**
 * @Filename: bidding-front.js
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
import NhAcquisition from './modules/Acquisition';

class NhAcquisitionFront extends NhAcquisition
{
    constructor()
    {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            acquisition: {
                form: $(`#${KEY}_create_acquisition_form`),
                parent: $(`#${KEY}_create_acquisition_form`).parent(),
                acquisitions_numbers: $(`.acquisitions-numbers`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.CreateAcquisitionFront();
    }

    CreateAcquisitionFront()
    {
        let that         = this,
            $acquisition = this.$el.acquisition,
            ajaxRequests = this.ajaxRequests;


        // Handle form submission
        $acquisition.form.on('submit', $acquisition.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing forgot password requests
            if (typeof ajaxRequests.createAcquisition !== 'undefined') {
                ajaxRequests.createAcquisition.abort();
            }

            // Validate the form and perform forgot password request if valid
            if ($this.valid()) {
                that.createAcquisition(formData, $acquisition);
            }
        });

    }
}

new NhAcquisitionFront();