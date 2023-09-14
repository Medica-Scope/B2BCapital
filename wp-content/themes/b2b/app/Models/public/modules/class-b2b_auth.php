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
    use B2B\APP\MODELS\FRONT\B2b_Public;
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
            $this->hooks->add_action('wp_body_close', $this, 'wp_body_close');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_registration_ajax', $this, 'registration_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_login_ajax', $this, 'login_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_verification_ajax', $this, 'verification_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_resendVerCode_ajax', $this, 'resendVerCode_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_authentication_ajax', $this, 'authentication_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_resendAuthCode_ajax', $this, 'resendAuthCode_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_industries_ajax', $this, 'industries_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_forgot_password_ajax', $this, 'forgot_password_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_change_password_ajax', $this, 'change_password_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_edit_profile_ajax', $this, 'edit_profile_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_edit_password_ajax', $this, 'edit_password_ajax');
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

        public function wp_body_close(): void
        {
            if (is_page([
                'verification',
                'authentication',
            ])) {
                require_once B2b_Hooks::PATHS['views'] . '/js-templates/modals/auth-verif.php';
            }
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
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
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

            $this->set_user_meta('nickname', ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name)));
            $this->set_user_meta('phone_number', $phone_number);
            $this->set_user_meta('verification_type', B2b_User::VERIFICATION_TYPES[$verification_type]);

            $user = $this->insert();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message());
            }

            if ($user->user_meta['verification_type'] === B2b_User::VERIFICATION_TYPES['mobile']) {
                $msg = __('Mobile', 'b2b');
            } elseif ($user->user_meta['verification_type'] === B2b_User::VERIFICATION_TYPES['whatsapp']) {
                $msg = __('WhatsApp', 'b2b');
            } else {
                $msg = __('E-mail', 'b2b');
            }

            new B2b_Ajax_Response(TRUE, sprintf(__('Your account has been created successfully, Please check your %s to activate your account', 'b2b'), $msg), [
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/verification')))
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
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
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
                if ($user->get_error_code() === 'account_verification') {
                    $redirect_url = get_permalink(get_page_by_path('my-account/verification'));
                    new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                        'redirect_url' => apply_filters('b2bml_permalink', $redirect_url)
                    ]);
                } else {
                    new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
                }
            }

            if (in_array($user->role, $admins)) {
                $redirect_url = get_admin_url();
            } elseif (in_array($user->role, $front_dashboard)) {
                $redirect_url = get_permalink(get_page_by_path('my-account/authentication'));
            } else {
                $redirect_url = home_url();
            }

            new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', $redirect_url)
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

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_verification');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user     = self::get_current_user();
            $validate = self::check_otp_code([
                'verification_expire_date' => $user->user_meta['verification_expire_date'],
                'incoming_code'            => $code1 . $code2 . $code3 . $code4,
                'current_code'             => $user->user_meta['verification_key']
            ], 'verification');

            if (!is_wp_error($validate)) {
                if ($user->user_meta['verification_type'] === 'email') {
                    $user->set_user_meta('email_verification_status', 1, TRUE);
                } else {
                    $user->set_user_meta('phone_verification_status', 1, TRUE);
                }
                // if user is verified then he is successfully authenticated
                $user->set_user_meta('account_authentication_status', 1, TRUE);
                $user->set_user_meta('account_verification_status', 1, TRUE);
                $user->set_user_meta('verification_key', '', TRUE);
                $user->set_user_meta('verification_expire_date', '', TRUE);
            } else {
                new B2b_Ajax_Response(FALSE, __($validate->get_error_message(), 'b2b'));
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been verified successfully!', 'b2b'), [
                'redirect_text' => __('GO TO DASHBOARD'),
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/industry')))
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

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_verification');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user = self::get_current_user();

            if ($user->user_meta['verification_expire_date'] <= time()) {
                $user->setup_verification('verification');
            } else {
                new B2b_Ajax_Response(FALSE, __("Your code didn't expire yet!", 'b2b'));
            }

            new B2b_Ajax_Response(TRUE, __('Your code has been sent successfully!', 'b2b'), [
                'expire' => $user->user_meta['verification_expire_date']
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
        public function authentication_ajax(): void
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

            if (!wp_verify_nonce($form_data['authentication_nonce'], B2b::_DOMAIN_NAME . "_authentication_form")) {
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

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_authentication');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user     = self::get_current_user();
            $validate = self::check_otp_code([
                'authentication_expire_date' => $user->user_meta['authentication_expire_date'],
                'incoming_code'              => $code1 . $code2 . $code3 . $code4,
                'current_code'               => $user->user_meta['authentication_key']
            ], 'authentication');

            if (!is_wp_error($validate)) {
                update_user_meta($user->ID, 'account_authentication_status', 1);
                update_user_meta($user->ID, 'authentication_key', '');
                update_user_meta($user->ID, 'authentication_expire_date', '');
            } else {
                new B2b_Ajax_Response(FALSE, __($validate->get_error_message(), 'b2b'));
            }

            $redirect_page_slug = 'dashboard';
            if (isset($user->profile->taxonomy['industry']) && !empty($profile->taxonomy['industry'])) {
                $redirect_page_slug = 'my-account/industry';
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been authenticated successfully!', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path($redirect_page_slug))),
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
        public function resendAuthCode_ajax(): void
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

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_authentication');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user = self::get_current_user();

            if ($user->user_meta['authentication_expire_date'] <= time()) {
                $user->setup_verification('authentication');
            } else {
                new B2b_Ajax_Response(FALSE, __("Your code didn't expire yet!", 'b2b'));
            }

            new B2b_Ajax_Response(TRUE, __('Your code has been sent successfully!', 'b2b'), [
                'expire' => $user->user_meta['authentication_expire_date']
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
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user                                = B2b_User::get_current_user();
            $user->profile->taxonomy['industry'] = $industries;
            $user->profile->update();


            new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('dashboard')))
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
            $user_email_phone              = sanitize_text_field($form_data['user_email_phone']);
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

            if (empty($user_email_phone)) {
                new B2b_Ajax_Response(FALSE, __("The email field is empty!.", 'b2b'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_forgot_password');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            $user = $this->forgot_password($user_email_phone);

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
            }

            new B2b_Ajax_Response(TRUE, __('Please check your stored email or phone number to get your reset code.', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', home_url())
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
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
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
         * @throws \Exception
         */
        public function edit_profile_ajax(): void
        {
            global $current_user;

            $form_data                        = $_POST['data'];
            $first_name                       = sanitize_text_field($form_data['first_name']);
            $last_name                        = sanitize_text_field($form_data['last_name']);
            $phone_number                     = sanitize_text_field($form_data['phone_number']);
            $user_email                       = sanitize_text_field($form_data['user_email']);
            $site_language                    = sanitize_text_field($form_data['site_language']);
            $widget_list                      = !is_array($form_data['widget_list']) ? [] : $form_data['widget_list'];
            $preferred_opportunities_cat_list = !is_array($form_data['preferred_opportunities_cat_list']) ? [] : $form_data['preferred_opportunities_cat_list'];
            $preferred_articles_cat_list      = !is_array($form_data['preferred_articles_cat_list']) ? [] : $form_data['preferred_opportunities_cat_list'];
            $recaptcha_response               = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"]    = $recaptcha_response;

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Profile data can't be empty.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['edit_profile_nonce'], B2b::_DOMAIN_NAME . "_edit_profile_form")) {
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

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_edit_profile');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }


            $relative_preferred_opportunities_cat_list = $preferred_opportunities_cat_list;
            foreach ($preferred_opportunities_cat_list as $term) {
                foreach (B2b_Public::get_available_languages() as $lang) {
                    if ($lang['code'] !== B2B_lANG) {
                        // Get the term's ID in the French language
                        $translated_term_id = wpml_object_id_filter($term, 'opportunity-category', FALSE, $lang['code']);
                        if ($translated_term_id) {
                            $relative_preferred_opportunities_cat_list[] = $translated_term_id;
                        }
                    }

                }

            }


            $relative_preferred_articles_cat_list = $preferred_articles_cat_list;
            foreach ($preferred_articles_cat_list as $term) {
                foreach (B2b_Public::get_available_languages() as $lang) {
                    if ($lang['code'] !== B2B_lANG) {
                        // Get the term's ID in the French language
                        $translated_term_id = wpml_object_id_filter($term, 'category', FALSE, $lang['code']);
                        if ($translated_term_id) {
                            $relative_preferred_articles_cat_list[] = $translated_term_id;
                        }
                    }

                }

            }

            // TODO:: Widget Lists


            $current_user_obj               = B2b_User::get_current_user();
            $current_user_obj->username     = $phone_number;
            $current_user_obj->email        = $user_email;
            $current_user_obj->display_name = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
            $current_user_obj->first_name   = ucfirst(strtolower($first_name));
            $current_user_obj->last_name    = ucfirst(strtolower($last_name));

            $current_user_obj->set_user_meta('first_name', ucfirst(strtolower($first_name)));
            $current_user_obj->set_user_meta('last_name', ucfirst(strtolower($last_name)));
            $current_user_obj->set_user_meta('nickname', ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name)));
            $current_user_obj->set_user_meta('phone_number', $phone_number);
            $current_user_obj->set_user_meta('site_language', $site_language);
            $current_user_obj->profile->set_meta_data('widget_list', $widget_list);
            $current_user_obj->profile->set_meta_data('preferred_opportunities_cat_list', $relative_preferred_opportunities_cat_list);
            $current_user_obj->profile->set_meta_data('preferred_articles_cat_list', $relative_preferred_articles_cat_list);

            $user = $current_user_obj->update();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message());
            }

            if ($current_user->data->user_login !== $current_user_obj->username) {
                new B2b_Ajax_Response(TRUE, __('Your profile has been updated successfully, But you need to re-login again.', 'b2b'), [
                    'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/login'))),
                    'redirect'     => TRUE
                ]);
            }

            new B2b_Ajax_Response(TRUE, __('Your profile has been updated successfully', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')))
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
        public function edit_password_ajax(): void
        {
            global $current_user;

            $form_data                     = $_POST['data'];
            $current_password              = sanitize_text_field($form_data['current_password']);
            $new_password                  = sanitize_text_field($form_data['new_password']);
            $confirm_new_password          = sanitize_text_field($form_data['confirm_new_password']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't login with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['edit_password_nonce'], B2b::_DOMAIN_NAME . "_edit_password_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($current_password)) {
                new B2b_Ajax_Response(FALSE, __("The current password field is empty!.", 'b2b'));
            }

            if (empty($new_password)) {
                new B2b_Ajax_Response(FALSE, __("The new password field is empty!.", 'b2b'));
            }

            if (empty($confirm_new_password)) {
                new B2b_Ajax_Response(FALSE, __("The confirm new password field is empty!.", 'b2b'));
            }

            if ($new_password !== $confirm_new_password) {
                new B2b_Ajax_Response(FALSE, __("Your password is not identical!.", 'b2b'));
            }

            if (!wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)) {
                new B2b_Ajax_Response(FALSE, __("Your current password is incorrect!.", 'b2b'));
            }

            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $new_password)) {
                new B2b_Ajax_Response(FALSE, __("Your password is not complex enough!", 'b2b'));
            }

            // TODO:: Change it to frontend_edit_password after design
            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_edit_profile');

            if ($check_result !== TRUE) {
                new B2b_Ajax_Response(FALSE, __($check_result, 'b2b'));/* the reCAPTCHA answer  */
            }

            wp_set_password($new_password, $current_user->ID);

            new B2b_Ajax_Response(TRUE, __('Your password has been changed successfully, But you need to re-login again.', 'b2b'), [
                'redirect_url' => apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/login')))
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
        public function logout_ajax(): void
        {
            // TODO:: set account_authentication_status to 0
            if (is_user_logged_in()) {
                wp_logout();
            }

            new B2b_Ajax_Response(TRUE, '', [
                'redirect_url' => apply_filters('b2bml_permalink', home_url())
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
            global $user_ID, $wp;

            // restrict user from accessing the crud pages
            if (is_page([
                    'login',
                    'registration',
                    'reset-password',
                    'forgot-password'
                ]) && is_user_logged_in()) {
                $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')));
                wp_safe_redirect($url);
                exit();
            }

            // prevent accessing the sensitive pages
            if (is_page([
                    'my-account',
                    'verification',
                    'authentication',
                    'industry',
                    'dashboard'
                ]) && !is_user_logged_in()) {
                $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/login')));
                wp_safe_redirect($url);
                exit();
            }

            if (is_page([
                    'industry',
                    'verification',
                    'authentication'
                ]) && is_user_logged_in() && (B2b_User::get_user_role($user_ID) !== B2b_User::INVESTOR && B2b_User::get_user_role($user_ID) !== B2b_User::OWNER)) {
                $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')));
                wp_safe_redirect($url);
                exit();
            }

            // prevent access if is not owner or investor and if is not verified and authenticated
            if (is_page([
                    'dashboard',
                    'my-account',
                    'industry'
                ]) && is_user_logged_in()) {
                $user_verified      = get_user_meta($user_ID, 'account_verification_status', TRUE);
                $user_authenticated = get_user_meta($user_ID, 'account_authentication_status', TRUE);
                if (!(int)$user_verified && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/verification')));
                    wp_safe_redirect($url);
                    exit();
                }
                if (!(int)$user_authenticated && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/authentication')));
                    wp_safe_redirect($url);
                    exit();
                }
            }

            if ((is_page('verification')) && is_user_logged_in()) {
                $user_confirmed = get_user_meta($user_ID, 'account_verification_status', TRUE);
                if ((int)$user_confirmed && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')));
                    wp_safe_redirect($url);
                    exit();
                }
            }

            if ((is_page('authentication')) && is_user_logged_in()) {
                $user_confirmed = get_user_meta($user_ID, 'account_authentication_status', TRUE);
                if ((int)$user_confirmed && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')));
                    wp_safe_redirect($url);
                    exit();
                }
            }

            if (is_page('industry') && is_user_logged_in()) {
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new B2b_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (isset($profile->taxonomy['industry']) && !empty($profile->taxonomy['industry']) && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account')));
                    wp_safe_redirect($url);
                    exit();
                }
            }

            if (is_page([
                    'dashboard',
                    'my-account'
                ]) && is_user_logged_in() && (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                $profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
                $profile_obj = new B2b_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!isset($profile->taxonomy['industry']) || empty($profile->taxonomy['industry'])) {
                    $url = apply_filters('b2bml_permalink', get_permalink(get_page_by_path('my-account/industry')));
                    wp_safe_redirect($url);
                    exit();
                }
            }


            /**
             * Temp if there is an error wit redirections
             */ //            if (is_user_logged_in()) {
            //                $site_language = get_user_meta($user_ID, 'site_language', TRUE);
            //                $current_url = home_url(add_query_arg([], $wp->request)); // Get the current URL
            //
            //                // Check if the current URL contains the Arabic slug ("/ar/") or the language parameter ("?lang=ar").
            //                if (!str_contains($current_url, "/$site_language/") && !str_contains($current_url, "?lang=$site_language")) {
            //                    $current_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            //                    $full_url  = $current_protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            //                    $redirect_url = apply_filters('wpml_permalink', $full_url, $site_language); // Get the Arabic version of the current page or post URL.
            //                    if ($redirect_url) {
            //                        wp_redirect($redirect_url);
            //                        exit;
            //                    }
            //                }
            //            }

        }
    }
