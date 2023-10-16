<?php
    /**
     * @Filename: class-nh_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */


    namespace NH\APP\MODELS\ADMIN;

    use NH\APP\CLASSES\Nh_Init;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Admin
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Admin
    {

        /**
         * @var \NH\APP\HELPERS\Nh_Hooks
         */
        private Nh_Hooks $hooks;


        /**
         * @param \NH\APP\HELPERS\Nh_Hooks $hooks
         */
        public function __construct(Nh_Hooks $hooks)
        {
            $this->hooks = $hooks;
            $this->actions();
            $this->filters();
            Nh_Init::get_instance()
                   ->run('admin');
        }

        public function actions(): void
        {
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_styles');
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts');
            $this->hooks->add_action('admin_init', $this, 'restrict_admin_with_redirect');
            $this->hooks->add_action('manage_post_posts_custom_column', $this, 'populate_columns', 10, 2);
            $this->hooks->run();
        }

        public function filters()
        {
            $this->hooks->add_filter('gglcptch_add_custom_form', $this, 'add_custom_recaptcha_forms', 10, 1);
            $this->hooks->add_filter('manage_post_posts_columns', $this, 'add_new_columns');
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {
            $this->hooks->add_style('admin-style-main', Nh_Hooks::PATHS['admin']['css'] . '/style');
        }

        public function enqueue_scripts(): void
        {
            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-admin-script-main', Nh_Hooks::PATHS['admin']['js'] . '/main', [ 'jquery' ]);
            $this->hooks->add_localization(Nh::_DOMAIN_NAME . '-admin-script-main', 'nhGlobals', [
                'domain_key' => Nh::_DOMAIN_NAME,
                'ajaxUrl'    => admin_url('admin-ajax.php'),
            ]);
            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-opportunity-script-main', Nh_Hooks::PATHS['admin']['js'] . '/opportunity-front', [ 'jquery' ]);

            $this->hooks->run();

        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function restrict_admin_with_redirect(): void
        {
            global $user_ID;
            if ((Nh_User::get_user_role($user_ID) === Nh_User::INVESTOR || Nh_User::get_user_role($user_ID) === Nh_User::OWNER) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF']) {
                wp_redirect(home_url());
                exit;
            }
        }

        /**
         * Description...
         *
         * @param $forms
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function add_custom_recaptcha_forms($forms)
        {
            $forms['frontend_login']               = [ "form_name" => "Front End Login" ];
            $forms['frontend_registration']        = [ "form_name" => "Front End Register" ];
            $forms['frontend_verification']        = [ "form_name" => "Front End Verification" ];
            $forms['frontend_authentication']      = [ "form_name" => "Front End Authentication" ];
            $forms['frontend_industries']          = [ "form_name" => "Front End Industries" ];
            $forms['frontend_reset_password']      = [ "form_name" => "Front End Reset Password" ];
            $forms['frontend_forgot_password']     = [ "form_name" => "Front End Forgot Password" ];
            $forms['frontend_edit_profile']        = [ "form_name" => "Front End Edit Profile" ];
            $forms['frontend_edit_password']       = [ "form_name" => "Front End Edit Password" ];
            $forms['frontend_create_opportunity']  = [ "form_name" => "Front End Create Opportunity" ];
            $forms['frontend_create_appointment']  = [ "form_name" => "Front End Create Appointment" ];
            $forms['frontend_add_bid']             = [ "form_name" => "Front End Add Bid" ];
            $forms['frontend_create_acquisitions'] = [ "form_name" => "Front End Create Acquisitions" ];
            $forms['frontend_create_investments']  = [ "form_name" => "Front End Create Investment" ];
            return $forms;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return string
         */
        public function add_new_columns($columns) {
            $columns['fav_count'] = 'Favorite count';
            $columns['ignore_count'] = 'Ignore count';
            $columns['read_count'] = 'Read count';
            return $columns;
        }
        public function populate_columns($column, $post_id) {
            if ($column == 'fav_count') {
                echo get_post_meta($post_id, 'fav_count', true);
            } elseif ($column == 'ignore_count') {
                echo get_post_meta($post_id, 'ignore_count', true);
            } elseif ($column == 'read_count') {
                echo get_post_meta($post_id, 'read_count', true);
            }
        }

    }
