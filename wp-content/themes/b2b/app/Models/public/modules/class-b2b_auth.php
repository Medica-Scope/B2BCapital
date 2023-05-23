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
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_logout_ajax', $this, 'logout_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_login_ajax', $this, 'login_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_forgot_password_ajax', $this, 'forgot_password_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_change_password_ajax', $this, 'change_password_ajax');
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
         */
        public function login_ajax(): void
        {

            $form_data     = $_POST['data'];
            $user_login    = sanitize_text_field($form_data['user_login']);
            $user_password = sanitize_text_field($form_data['user_password']);


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

            $user = $this->login();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message(), $user->get_error_data());
            }

            new B2b_Ajax_Response(TRUE, __('You have been logged in successfully.', 'b2b'), [
                'redirect_url' => self::ADMIN === $user->role || self::CMS === $user->role ? get_admin_url() : home_url()
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

            $form_data  = $_POST['data'];
            $user_email = sanitize_text_field($form_data['user_email']);


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

            $form_data             = $_POST['data'];
            $user_password         = sanitize_text_field($form_data['user_password']);
            $user_password_confirm = sanitize_text_field($form_data['user_password_confirm']);


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
        public function register_ajax(): void
        {
            $form_data       = $_POST['data'];
            $profile_picture = sanitize_text_field($_FILES['data']['profile_picture']);
            $user_role       = sanitize_text_field($form_data['user_role']);
            $first_name      = sanitize_text_field($form_data['first_name']);
            $last_name       = sanitize_text_field($form_data['last_name']);
            $username        = sanitize_text_field($form_data['username']);
            $phone_number    = sanitize_text_field($form_data['phone_number']);
            $user_email      = sanitize_text_field($form_data['user_email']);
            $user_password1  = sanitize_text_field($form_data['user_password1']);
            $user_password2  = sanitize_text_field($form_data['user_password2']);

            if (is_user_logged_in()) {
                new B2b_Ajax_Response(FALSE, __('You are already logged In!.', 'b2b'));
            }

            if (empty($form_data)) {
                new B2b_Ajax_Response(FALSE, __("Can't register with empty credentials.", 'b2b'));
            }

            if (!wp_verify_nonce($form_data['registration_nonce'], B2b::_DOMAIN_NAME . "_registration_form")) {
                new B2b_Ajax_Response(FALSE, __("Something went wrong!.", 'b2b'));
            }

            if (empty($user_role)) {
                new B2b_Ajax_Response(FALSE, __("The role field is empty!.", 'b2b'));
            }

            if (static::SUBSCRIBER !== $user_role) {
                new B2b_Ajax_Response(FALSE, __("Invalid user role!.", 'b2b'));
            }

            if (empty($first_name)) {
                new B2b_Ajax_Response(FALSE, __("The first name field shouldn't be empty!.", 'b2b'));
            }

            if (empty($last_name)) {
                new B2b_Ajax_Response(FALSE, __("The last name field is empty!.", 'b2b'));
            }

            if (empty($username)) {
                new B2b_Ajax_Response(FALSE, __("The username field shouldn't be empty!.", 'b2b'));
            }

            if (empty($phone_number)) {
                new B2b_Ajax_Response(FALSE, __("The phone number field is empty!.", 'b2b'));
            }

            if (empty($user_email)) {
                new B2b_Ajax_Response(FALSE, __("The E-mail field shouldn't be empty!.", 'b2b'));
            }

            if (empty($user_password1)) {
                new B2b_Ajax_Response(FALSE, __("The password field is empty!.", 'b2b'));
            }

            if (empty($user_password2)) {
                new B2b_Ajax_Response(FALSE, __("The confirm password field shouldn't be empty!.", 'b2b'));
            }

            if ($user_password1 !== $user_password2) {
                new B2b_Ajax_Response(FALSE, __("The passwords should be identical!.", 'b2b'));
            }

            $this->username     = $username;
            $this->password     = $user_password1;
            $this->email        = $user_email;
            $this->display_name = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
            $this->role         = $user_role;
            $this->avatar       = $profile_picture;
            $this->first_name   = ucfirst(strtolower($first_name));
            $this->last_name    = ucfirst(strtolower($last_name));
            $this->nickname     = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));

            $this->set_user_meta('phone_number', $phone_number);

            $user = $this->insert();

            if (is_wp_error($user)) {
                new B2b_Ajax_Response(FALSE, $user->get_error_message());
            }

            new B2b_Ajax_Response(TRUE, __('Your account has been created successfully, Please check your E-mail to activate your account', 'b2b'), [
                'redirect_url' => home_url('/')
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
            if ((is_page('my-account/login') || is_page('my-account/registration') || is_page('my-account/reset-password') || is_page('my-account/forgot-password')) &&
                is_user_logged_in()) {
                wp_safe_redirect(get_permalink(get_page_by_path('my-account')));
                exit();
            }

            if (is_page('my-account') && !is_user_logged_in()) {
                wp_safe_redirect(get_permalink(get_page_by_path('my-account/login')));
                exit();
            }
        }
    }
