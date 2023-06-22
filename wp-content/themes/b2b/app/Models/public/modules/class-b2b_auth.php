<?php
    /**
     * @Filename: class-b2b_auth.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */

    namespace B2B\APP\MODELS\FRONT\MODULES;

    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\HELPERS\B2b_Ajax_Response;
    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Auth
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Auth extends B2b_User
    {

        /**
         * @var object|\B2B\APP\HELPERS\B2b_Hooks
         */
        protected object $hooks;

        public function __construct()
        {
            parent::__construct();
            $this->hooks = new B2b_Hooks;

            $this->shortcodes();
            $this->actions();
            $this->filters();

            $this->hooks->run();
        }

        private function shortcodes(): void
        {
        }

        private function actions(): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('wp_login', $this, 'after_wp_login');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_registration_ajax', $this, 'registration_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_login_ajax', $this, 'login_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_verification_ajax', $this, 'verification_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_resendVerCode_ajax', $this, 'resendVerCode_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_industries_ajax', $this, 'industries_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_forgot_password_ajax', $this, 'forgot_password_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_change_password_ajax', $this, 'change_password_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_logout_ajax', $this, 'logout_ajax');
        }

        private function filters(): void
        {
            // TODO: Implement filters() method.
            $this->hooks->add_filter('template_redirect', $this, 'restrict_redirections');
        }

        public function after_wp_login()
        {

        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         * @throws \Exception
         */
        public function registration_ajax(): void
        {
            $form_data = $_POST['data'];
            //            $profile_picture               = sanitize_text_field($_FILES['data']['profile_picture']);
            $profile_picture               = '';
            $first_name                    = sanitize_text_field($form_data['first_name']);
            $last_name                     = sanitize_text_field($form_data['last_name']);
            $phone_number                  = sanitize_text_field($form_data['phone_number']);
            $user_email                    = sanitize_text_field($form_data['user_email']);
            $user_password                 = sanitize_text_field($form_data['user_password']);
            $confirm_password              = sanitize_text_field($form_data['confirm_password']);
            $user_type                     = sanitize_text_field($form_data['user_type']);
            $verification_type             = sanitize_text_field($form_data['verification_type']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are already logged In!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't register with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['registration_nonce'], B2b::_DOMAIN_NAME . "_registration_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($first_name)) {
                new B2b_Ajax_Response(FALSE, __("The first name field shouldn't be empty!.", 'b2b'));
            }

            if (empty($last_name)) {
                new B2b_Ajax_Response(FALSE, __("The last name field is empty!.", 'b2b'));
            }

            if (empty($phone_number)) {
                new B2b_Ajax_Response(FALSE, __("The phone number field is empty!.", 'b2b'));
            }

            if (empty($user_email)) {
                new B2b_Ajax_Response(FALSE, __("The E-mail field shouldn't be empty!.", 'b2b'));
            }

            if (empty($user_password)) {
                new B2b_Ajax_Response(FALSE, __("The password field is empty!.", 'b2b'));
            }

            if (empty($confirm_password)) {
                new B2b_Ajax_Response(FALSE, __("The confirm password field shouldn't be empty!.", 'b2b'));
            }

            if ($user_password !== $confirm_password) {
                new B2b_Ajax_Response(FALSE, __("The passwords should be identical!.", 'b2b'));
            }

            if (empty($user_type)) {
                new B2b_Ajax_Response(FALSE, __("The user type is empty!.", 'b2b'));
            }

            if (static::INVESTOR !== $user_type && static::OWNER !== $user_type) {
                new B2b_Ajax_Response(FALSE, __("Invalid user type!.", 'b2b'));
            }

            if (empty($verification_type)) {
                new B2b_Ajax_Response(FALSE, __("You should select a verification type.", 'b2b'));
            }

            if (!array_key_exists($verification_type, B2b_User::VERIFICATION_TYPES)) {
                new B2b_Ajax_Response(FALSE, __("Invalid verification type.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_registration');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $this->username     = $phone_number;
            $this->password     = $user_password;
            $this->email        = $user_email;
            $this->display_name = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
            $this->role         = $user_type;
            $this->avatar       = $profile_picture;
            $this->first_name   = ucfirst(strtolower($first_name));
            $this->last_name    = ucfirst(strtolower($last_name));
            $this->nickname     = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));

            $this->set_user_meta('phone_number', $phone_number);
            $this->set_user_meta('verification_type', B2b_User::VERIFICATION_TYPES[$verification_type]);

            $user = $this->insert();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message());
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been created successfully, Please check your E-mail to activate your account', 'b2b'), [
                'redirect_url' => get_permalink(get_page_by_path('my-account/verification'))
            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function login_ajax(): void
        {

            $form_data                     = $_POST['data'];
            $user_login                    = sanitize_text_field($form_data['user_login']);
            $user_password                 = sanitize_text_field($form_data['user_password']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are already logged In!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't login with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['login_nonce'], B2b::_DOMAIN_NAME . "_login_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($user_login)) {
                new B2b_Ajax_Response(FALSE, __("The username field is empty!.", 'b2b'));
            }

            if (empty($user_password)) {
                new B2b_Ajax_Response(FALSE, __("The password field shouldn't be empty!.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_login');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }


            $user            = $this->login();
            $admins          = [
                self::ADMIN,
                self::CMS,
                self::SEO,
                self::WEBMASTER,
                self::REVIEWER
            ];
            $front_dashboard = [
                self::OWNER,
                self::INVESTOR
            ];

            if (is_wp_error($user)) {
                if ($user->get_error_code() === 'account_confirmation') {
                    $redirect_url = get_permalink(get_page_by_path('my-account/verification'));
                    new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                        'redirect_url' => $redirect_url
                    ]);
                } elseif ($user->get_error_code() === 'empty_industry') {
                    $redirect_url = get_permalink(get_page_by_path('my-account/industry'));
                    new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                        'redirect_url' => $redirect_url
                    ]);
                } else {
                    new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
                }
            }

            if (in_array($user->role, $admins)) {
                $redirect_url = get_admin_url();
            } elseif (in_array($user->role, $front_dashboard)) {
                $redirect_url = get_permalink(get_page_by_path('dashboard'));
            } else {
                $redirect_url = home_url();
            }

            new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                'redirect_url' => $redirect_url
            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         * @throws \Exception
         */
        public function verification_ajax(): void
        {
            $form_data                     = $_POST['data'];
            $code1                         = sanitize_text_field($form_data['code1']);
            $code2                         = sanitize_text_field($form_data['code2']);
            $code3                         = sanitize_text_field($form_data['code3']);
            $code4                         = sanitize_text_field($form_data['code4']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (!is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are not allowed to perform this action!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("invalid code.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['verification_nonce'], B2b::_DOMAIN_NAME . "_verification_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if ($code1 === NULL || $code1 === '') {
                new B2b_Ajax_Response(FALSE, __("Please enter the correct code.", 'b2b'));
            }

            if ($code2 === NULL || $code2 === '') {
                new B2b_Ajax_Response(FALSE, __("Please enter the correct code.", 'b2b'));
            }

            if ($code3 === NULL || $code3 === '') {
                new B2b_Ajax_Response(FALSE, __("Please enter the correct code.", 'b2b'));
            }

            if ($code4 === NULL || $code4 === '') {
                new B2b_Ajax_Response(FALSE, __("Please enter the correct code.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_registration');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $user     = self::get_current_user();
            $validate = self::check_verification_code([
                'verification_expire_date' => $user->user_meta['verification_expire_date'],
                'incoming_code'            => $code1 . $code2 . $code3 . $code4,
                'current_code'             => $user->user_meta['verification_key'],
            ]);

            if (!is_wp_error($validate)) {
                if ($user->user_meta['verification_type'] === 'email') {
                    update_user_meta($user->ID, 'email_confirmation_status', 1);
                } else {
                    update_user_meta($user->ID, 'phone_confirmation_status', 1);
                }
                update_user_meta($user->ID, 'account_confirmation_status', 1);
                update_user_meta($user->ID, 'verification_key', '');
                update_user_meta($user->ID, 'verification_expire_date', '');
            } else {
                new B2b_Ajax_Response(FALSE, __($validate->get_error_message(), 'icmtc'));
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been verified successfully!', 'b2b'), [
                'redirect_url' => get_permalink(get_page_by_path('my-account/industry'))
            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         * @throws \Exception
         */
        public function resendVerCode_ajax(): void
        {
            $form_data                     = $_POST['data'];
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (!is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are not allowed to perform this action!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("invalid action.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_registration');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $user = self::get_current_user();
            $user->mobile_verification();

            if ($user->user_meta['verification_type'] === self::VERIFICATION_TYPES['mobile']) {
                $verification = $user->mobile_verification();
                if (is_wp_error($verification)) {
                    new B2b_Ajax_Response(TRUE, __('', 'b2b'), [
                        'e' => ''
                    ]);
                }
            } elseif ($user->user_meta['verification_type'] === self::VERIFICATION_TYPES['whatsapp']) {
                $verification = $user->whatsapp_verification();
                if (is_wp_error($verification)) {
                    new B2b_Ajax_Response(TRUE, __('', 'b2b'), [
                        'e' => ''
                    ]);
                }
            } else {
                $verification = $user->email_verification();
                if (!$verification) {
                    new B2b_Ajax_Response(TRUE, __('', 'b2b'), [
                        'e' => ''
                    ]);
                }
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been verified successfully!', 'b2b'), [

            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function industries_ajax(): void
        {

            $form_data                     = $_POST['data'];
            $industries                    = $form_data['industries'];
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Form submission can't be empty!.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['industries_nonce'], B2b::_DOMAIN_NAME . "_industries_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (!is_array($industries) || empty($industries)) {
                new B2b_Ajax_Response(FALSE, __("You have to select at least one industry.", 'b2b'));
            }

            if (count($industries) < 1) {
                new B2b_Ajax_Response(FALSE, __("You have to select at least one industry.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_industries');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $user                                = B2b_User::get_current_user();
            $user->profile->taxonomy['industry'] = $industries;
            $user->profile->update();


            new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                'redirect_url' => get_permalink(get_page_by_path('dashboard'))
            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         * @throws \Exception
         */
        public function forgot_password_ajax(): void
        {

            $form_data                     = $_POST['data'];
            $user_email                    = sanitize_text_field($form_data['user_email']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are already logged In!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't login with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['forgot_nonce'], B2b::_DOMAIN_NAME . "_forgot_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($user_email)) {
                new B2b_Ajax_Response(FALSE, __("The email field is empty!.", 'b2b'));
            }

            if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $user_email)) {
                new B2b_Ajax_Response(FALSE, __("Your email address is not a valid email!", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_forgot_password');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $user = $this->forgot_password($user_email);

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
            }

            new B2b_Ajax_Response(TRUE, __('Email has been sent successfully!.', 'b2b'), [
                'redirect_url' => home_url()
            ]);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function change_password_ajax(): void
        {

            $form_data                     = $_POST['data'];
            $user_password                 = sanitize_text_field($form_data['user_password']);
            $user_password_confirm         = sanitize_text_field($form_data['user_password_confirm']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't login with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['change_password_nonce'], B2b::_DOMAIN_NAME . "_change_password_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($user_password)) {
                new B2b_Ajax_Response(FALSE, __("The password field is empty!.", 'b2b'));
            }

            if (empty($user_password_confirm)) {
                new B2b_Ajax_Response(FALSE, __("The confirm password field is empty!.", 'b2b'));
            }

            if ($user_password !== $user_password_confirm) {
                new B2b_Ajax_Response(FALSE, __("Your password is not identical!.", 'b2b'));
            }

            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $user_password)) {
                new B2b_Ajax_Response(FALSE, __("Your password is not complex enough!", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_reset_password');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'icmtc'));/* the reCAPTCHA answer  */
            }

            $user = $this->change_password();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
            }

            new B2b_Ajax_Response(TRUE, sprintf(__('Your password has been changed successfully!. you can login with your new password from <a href="%s">here</a>', 'b2b'), get_permalink(get_page_by_path('my-account/login'))));
        }


        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function logout_ajax(): void
        {
            if (is_user_logged_in()) {
                wp_logout();
            }

            new B2b_Ajax_Response(TRUE, '', [
                'redirect_url' => home_url()
            ]);

        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function restrict_redirections(): void
        {
            if ((is_page('my-account/login') || is_page('my-account/registration') || is_page('my-account/reset-password') || is_page('my-account/forgot-password')) && is_user_logged_in()) {
                wp_safe_redirect(get_permalink(get_page_by_path('my-account')));
                exit();
            }

            if ((is_page('my-account') || is_page('my-account/verification') || is_page('my-account/industry') || is_page('dashboard')) && !is_user_logged_in()) {
                //            if ((is_page('my-account') || is_page('my-account/industry') || is_page('dashboard')) && !is_user_logged_in()) {
                wp_safe_redirect(get_permalink(get_page_by_path('my-account/login')));
                exit();
            }

            if ((is_page('my-account/verification')) && is_user_logged_in()) {
                global $user_ID;
                $user_confirmed = get_user_meta($user_ID, 'account_confirmation_status', TRUE);
                if ((int)$user_confirmed | (B2b_User::get_user_role($user_ID) !== B2b_User::INVESTOR && B2b_User::get_user_role($user_ID) !== B2b_User::OWNER)) {
                    wp_safe_redirect(get_permalink(get_page_by_path('my-account')));
                    exit();
                }
            }

            if ((is_page('my-account/industry')) && is_user_logged_in()) {
                global $user_ID;
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new B2b_Profile();
                $profile     = $profile_obj->get_by_id($profile_id);
                if (isset($profile->taxonomy['industry']) && !empty($profile->taxonomy['industry'])) {
                    wp_safe_redirect(get_permalink(get_page_by_path('my-account')));
                    exit();
                }
            }
        }
    }
