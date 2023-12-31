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
import NhValidator   from './helpers/Validator';
import NhUiCtrl      from './inc/UiCtrl';
import NhAppointment from './modules/Appointment';

class NhAppointmentFront extends NhAppointment
{
    constructor()
    {
        // Call the constructor of the parent class (NhAuth)
        super();

        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            appointments: {
                form: $(`#${KEY}_appointment_form`),
                parent: $(`#${KEY}_appointment_form`).parent(),
                slotTime: $(`.${KEY}-single-time`),
                checkoutPrice: $(`.checkout-price`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.selectSlots();
        this.createAppointmentFront();
    }

    selectSlots()
    {
        let that          = this,
            $appointments = this.$el.appointments;

        $appointments.slotTime.on('click', $appointments.parent, function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);

            $('.active-slot-time').removeClass('active-slot-time');
            $this.addClass('active-slot-time');
            $this.closest('.time-slot').find('input').prop('checked', true);
            $appointments.checkoutPrice.show();
        });
    }

    createAppointmentFront()
    {
        let that          = this,
            $appointments = this.$el.appointments,
            ajaxRequests  = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initAppointmentsValidation($appointments, 'createAppointment');

        // Handle form submission
        $appointments.form.on('submit', $appointments.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                $slot    = $('.active-slot-time'),
                formData = $this.serializeObject();

            formData.slot_data = {};
            if ($slot.length > 0) {
                formData.slot_data.day  = $slot.attr('data-day');
                formData.slot_data.date = $slot.attr('data-date');
                formData.slot_data.time = $slot.attr('data-time');
            }

            // Abort any ongoing forgot password requests
            if (typeof ajaxRequests.createAppointment !== 'undefined') {
                ajaxRequests.createAppointment.abort();
            }

            // Validate the form and perform forgot password request if valid
            if ($this.valid()) {
                that.createAppointment(formData, $this);
            }
        });
    }
}

new NhAppointmentFront();