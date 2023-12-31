<?php
    /**
     * @Filename: class-nh_appointment.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\HELPERS\Nh_Ajax_Response;
    use NH\Nh;
    use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Appointment
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Appointment extends Nh_Module
    {
        public array $meta_data = [
            'name',
            'email',
            'mobile',
            'appointment_date',
            'appointment_time',
            'appointment_day',
            'service'
        ];
        public array $taxonomy  = [];

        public function __construct()
        {
            parent::__construct('appointment');
        }

        /**
         * Description...
         *
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \NH\APP\CLASSES\Nh_Post
         */
        public function convert(WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data);
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_create_appointment_ajax', $this, 'create_appointment_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_create_appointment_ajax', $this, 'create_appointment_ajax');
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        public function check_appointment_slot($data): bool
        {
            $appointments = new \WP_Query([
                "post_type"   => $this->module,
                "post_status" => [ 'publish' ],
                'meta_query'  => [
                    'relation' => 'AND',
                    [
                        'key'     => 'appointment_date',
                        'value'   => date('Ymd', strtotime($data['date'])),
                        'compare' => '=',
                    ],
                    [
                        'key'     => 'appointment_time',
                        'value'   => date('g:i a', strtotime($data['time'])),
                        'compare' => '=',
                    ],
                    [
                        'key'     => 'appointment_day',
                        'value'   => $data['day'],
                        'compare' => '=',
                    ]
                ]
            ]);

            if ($appointments->have_posts()) {
                return TRUE;
            }
            return FALSE;
        }

        public function create_appointment_ajax()
        {
            $form_data                     = $_POST['data'];
            $name                          = sanitize_text_field($form_data['name']);
            $email                         = sanitize_text_field($form_data['email']);
            $mobile                        = sanitize_text_field($form_data['mobile']);
            $service_id                    = sanitize_text_field($form_data['service_id']);
            $service_title                 = sanitize_text_field($form_data['service_title']);
            $slot_data                     = $form_data['slot_data'];
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (!wp_verify_nonce($form_data['create_appointment_form'], Nh::_DOMAIN_NAME . "_create_appointment_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            if (empty($service_title)) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong.", 'ninja'));
            }

            if (empty($form_data)) {
                new Nh_Ajax_Response(FALSE, __("Form data mustn't be empty!.", 'ninja'));
            }

            if (empty($service_id)) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong.", 'ninja'));
            }

            if (empty($name)) {
                new Nh_Ajax_Response(FALSE, __("The name field is empty!.", 'ninja'));
            }

            if (empty($email)) {
                new Nh_Ajax_Response(FALSE, __("The email field is empty!.", 'ninja'));
            }

            if (empty($mobile)) {
                new Nh_Ajax_Response(FALSE, __("The mobile field is empty!.", 'ninja'));
            }

            if (empty($slot_data)) {
                new Nh_Ajax_Response(FALSE, __("The slot field is empty!.", 'ninja'));
            }

            if (empty($slot_data['date'])) {
                new Nh_Ajax_Response(FALSE, __("The slot date is empty!.", 'ninja'));
            }

            if (empty($slot_data['day'])) {
                new Nh_Ajax_Response(FALSE, __("The slot day is empty!.", 'ninja'));
            }

            if (empty($slot_data['time'])) {
                new Nh_Ajax_Response(FALSE, __("The slot day is empty!.", 'ninja'));
            }

            if ($this->check_appointment_slot($slot_data)) {
                new Nh_Ajax_Response(FALSE, __("This slot is not available!.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_create_appointment');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            $appointment        = new Nh_Appointment();
            $appointment->title = $service_title . ' - ' . $slot_data['date'] . ' - ' . $slot_data['day'] . ' - ' . $slot_data['time'];
            $appointment->set_meta_data('name', $name);
            $appointment->set_meta_data('email', $email);
            $appointment->set_meta_data('mobile', $mobile);
            $appointment->set_meta_data('appointment_date', date('Ymd', strtotime($slot_data['date'])));
            $appointment->set_meta_data('appointment_time', $slot_data['time']);
            $appointment->set_meta_data('appointment_day', $slot_data['day']);
            $appointment->set_meta_data('service', $service_id);
            $insert = $appointment->insert();

            if (is_wp_error($insert)) {
                new Nh_Ajax_Response(FALSE, $insert->get_error_message(), $insert->get_error_data());
            }

            new Nh_Ajax_Response(TRUE, sprintf(__('You have subscribed to <strong>%s</strong> Successfully.', 'ninja'), $service_title), [
                'redirect_url' => "apply_filters('nhml_permalink', home_url())"
            ]);
        }
    }
