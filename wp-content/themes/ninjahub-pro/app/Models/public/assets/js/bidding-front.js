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
import NhValidator from './helpers/Validator';
import NhUiCtrl    from './inc/UiCtrl';
import NhBidding   from './modules/Bidding';
import bootstrap   from 'bootstrap';

class NhBiddingFront extends NhBidding
{
    constructor()
    {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            bidding: {
                form: $(`#${KEY}_add_bid_form`),
                parent: $(`#${KEY}_add_bid_form`).parent(),
                start_bid: $(`#${KEY}_start_bid`),
                addBidModalBtn: $(`#addBidModalBtn`),
                bidding_modal: $(`.bidding-modal`),
                bids_numbers: $(`.bids-numbers`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.CreateBidFront();
    }

    CreateBidFront()
    {
        let that         = this,
            $bidding     = this.$el.bidding,
            addBidModal  = document.getElementById('addBidModal'),
            ajaxRequests = this.ajaxRequests;

        if (addBidModal !== null) {
            addBidModal.addEventListener('shown.bs.modal', function () {
                that.createNewToken();
            });
        }

        // Initialize form validation
        NhValidator.initBiddingValidation($bidding, 'createBid');

        // Handle form submission
        $bidding.form.on('submit', $bidding.parent, function (e) {
            e.preventDefault();

            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing forgot password requests
            if (typeof ajaxRequests.createBid !== 'undefined') {
                ajaxRequests.createBid.abort();
            }

            // Validate the form and perform forgot password request if valid
            if ($this.valid()) {
                that.createBid(formData, $bidding);
            }
        });
    }
}

new NhBiddingFront();