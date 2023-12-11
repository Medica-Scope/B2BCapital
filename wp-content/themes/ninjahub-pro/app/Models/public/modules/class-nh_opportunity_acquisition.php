<?php
    /**
     * @Filename: class-nh_opportunity_acquisition.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Ajax_Response;
    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\Nh;
    use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Opportunity_Acquisition
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Opportunity_Acquisition extends Nh_Module
    {
        public array $meta_data = [
            'opportunity',
            'acquisitions_stage',
            'show_in_dashboard',
        ];
        public array $taxonomy  = [];

        public function __construct()
        {
            parent::__construct('opp-acquisition');
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
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_create_acquisition_ajax', $this, 'create_acquisition_ajax');
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        public function create_acquisition_ajax()
        {
            $form_data                     = $_POST['data'];
            $opp_id                        = (int)sanitize_text_field($form_data['opp_id']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (!wp_verify_nonce($form_data['create_acquisitions_nonce'], Nh::_DOMAIN_NAME . "_create_acquisitions_nonce_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            if (empty($form_data)) {
                new Nh_Ajax_Response(FALSE, __("Form data mustn't be empty!.", 'ninja'));
            }

            if (empty($opp_id)) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_create_acquisitions');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            $opportunity_obj = new Nh_Opportunity();
            $opportunity     = $opportunity_obj->get_by_id($opp_id);

            if (is_wp_error($opportunity)) {
                new Nh_Ajax_Response(FALSE, $opportunity->get_error_message(), $opportunity->get_error_data());
            }

            if ($opportunity->meta_data['opportunity_stage'] !== 'publish') {
                new Nh_Ajax_Response(FALSE, __("You can't send an acquisitions request.", 'ninja'));
            }

            $current_user = Nh_User::get_current_user();

            if ($current_user->profile->ID === 0) {
                new Nh_Ajax_Response(FALSE, __("Invalid Profile ID.", 'ninja'));
            }

            if ($current_user->role !== Nh_User::INVESTOR) {
                new Nh_Ajax_Response(FALSE, __("You can't send an acquisitions request.", 'ninja'));
            }

            if (!$this->user_can_acquire($current_user->ID, $opp_id)) {
                new Nh_Ajax_Response(FALSE, __("You can't send an acquisition request twice for the same opportunity.", 'ninja'));
            }


            // get relative opp ID's
            $relative_opportunities = [ $opp_id ];
            foreach (Nh_Public::get_available_languages() as $lang) {
                if ($lang['code'] !== NH_lANG) {
                    // Get the term's ID in the French language
                    $translated_opp_id = wpml_object_id_filter($opp_id, 'post', FALSE, $lang['code']);
                    if ($translated_opp_id) {
                        $relative_opportunities[] = $translated_opp_id;
                    }
                }

            }

            $acquisition_obj         = new Nh_Opportunity_Acquisition();
            $acquisition_obj->title  = 'New Request From - ' . $current_user->profile->title . ' - ON - ' . $opportunity->title;
            $acquisition_obj->author = $current_user->ID;
            $acquisition_obj->set_meta_data('opportunity', $relative_opportunities);

            // TODO:: RECAP
            $acquisition_obj->set_meta_data('acquisitions_stage', 'pending');
            $insert = $acquisition_obj->insert();

            if (is_wp_error($insert)) {
                new Nh_Ajax_Response(FALSE, $insert->get_error_message(), $insert->get_error_data());
            }

            $opportunity_acquisitions   = empty($opportunity->meta_data['opportunity_acquisitions']) ? [] : $opportunity->meta_data['opportunity_acquisitions'];
            $opportunity_acquisitions[] = $insert->ID;
            $opportunity->set_meta_data('opportunity_acquisitions', $opportunity_acquisitions);
            // $opportunity->set_meta_data('opportunity_stage', 'acquisition-start');
            $update = $opportunity->update();

            if (is_wp_error($update)) {
                new Nh_Ajax_Response(FALSE, $update->get_error_message(), $update->get_error_data());
            }

            $notifications = new Nh_Notification();
            $notifications->send($current_user->ID, $opportunity->author, 'acquisition', [ 'opportunity_id' => $opportunity->ID ]);

            //TODO:: SEND EMAILS

            new Nh_Ajax_Response(TRUE, sprintf(__('Your request for <strong>%s</strong> has been sent successfully, Page will be reloaded after 5 seconds...', 'ninja'), $opportunity->title), [
                'button_text' => __('Done', 'ninja')
            ]);
        }

        public function user_can_acquire($user_ID, $opp_ID): bool
        {
            $acquisitions = new \WP_Query([
                'post_type'   => $this->module,
                'post_status' => 'publish',
                'author'      => $user_ID,
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => serialize($opp_ID),
                        'compare' => 'LIKE',
                    ],
                ],
            ]);

            if (!$acquisitions->have_posts()) {
                return TRUE;
            }

            return FALSE;
        }

        public function get_dashboard_sidebar_acquisitions(bool $current = FALSE): array
        {
            global $user_ID;

            if ($user_ID) {
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!is_wp_error($profile)) {
                    $not_in = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];  // for ignored opportunities
                }
            }
            $args = [
                'post_type'    => $this->module,
                'post_status'  => 'publish',
                'orderby'      => 'ID',
                'order'        => 'DESC',
                "post__not_in" => $not_in,
                'meta_query'   => [
                    'relation' => 'AND',
                    [
                        'key'     => 'acquisitions_stage',
                        'value'   => 'accepted',
                        'compare' => '=',
                    ],
                    [
                        'key'     => 'show_in_dashboard',
                        'value'   => '1',
                        'compare' => '=',
                    ],
                ],
            ];
            if ($current) {
                $args['author'] = $user_ID;
                unset($args['meta_query']);
            }

            $acquisitions = new \WP_Query($args);

            $Nh_acquisitions = [];

            foreach ($acquisitions->get_posts() as $acquisition) {
                $single_acquisition = $this->convert($acquisition, $this->meta_data);
                $opportunity_obj    = new Nh_Opportunity();
                foreach ($single_acquisition->meta_data['opportunity'] as $opp_id) {
                    $translated_opp_id               = wpml_object_id_filter($opp_id, 'post', FALSE, NH_lANG);
                    $single_acquisition->opportunity = $opportunity_obj->get_by_id((int)$translated_opp_id);
                }
                $Nh_acquisitions[] = $single_acquisition;
            }

            return $Nh_acquisitions;
        }

        public function get_profile_acquisitions(bool $current = FALSE): array
        {
            global $user_ID;

            if ($user_ID) {
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new Nh_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!is_wp_error($profile)) {
                    $not_in = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];  // for ignored opportunities
                }
            }
            $args = [
                'post_type'    => $this->module,
                'post_status'  => 'publish',
                'orderby'      => 'ID',
                'order'        => 'DESC',
                "post__not_in" => $not_in
            ];

            if ($current) {
                $args['author'] = $user_ID;
                unset($args['meta_query']);
            }

            $acquisitions = new \WP_Query($args);

            $Nh_acquisitions = [];

            foreach ($acquisitions->get_posts() as $acquisition) {
                $single_acquisition = $this->convert($acquisition, $this->meta_data);
                $opportunity_obj    = new Nh_Opportunity();
                foreach ($single_acquisition->meta_data['opportunity'] as $opp_id) {
                    $translated_opp_id               = wpml_object_id_filter($opp_id, 'post', FALSE, NH_lANG);
                    $single_acquisition->opportunity = $opportunity_obj->get_by_id((int)$translated_opp_id);
                }
                $Nh_acquisitions[] = $single_acquisition;
            }

            return $Nh_acquisitions;
        }

    }
