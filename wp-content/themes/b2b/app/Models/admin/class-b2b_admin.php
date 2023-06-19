<?php
    /**
     * @Filename: class-b2b_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */


    namespace B2B\APP\MODELS\ADMIN;

    use B2B\APP\CLASSES\B2b_Init;
    use B2B\APP\HELPERS\B2b_Hooks;

    /**
     * Description...
     *
     * @class B2b_Admin
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Admin
    {

        /**
         * @var \B2B\APP\HELPERS\B2b_Hooks
         */
        private B2b_Hooks $hooks;


        /**
         * @param \B2B\APP\HELPERS\B2b_Hooks $hooks
         */
        public function __construct(B2b_Hooks $hooks)
        {
            $this->hooks = $hooks;
            $this->actions();
            $this->filters();
            B2b_Init::get_instance()
                    ->run('admin');
        }

        public function actions(): void
        {
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_styles');
            $this->hooks->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts');
            $this->hooks->run();
        }

        public function filters()
        {
            $this->hooks->add_filter('gglcptch_add_custom_form', $this, 'add_custom_recaptcha_forms', 10, 1);
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {
            //			$this->hooks->add_style( B2b::_DOMAIN_NAME.'-admin-style-main', B2b_Hooks::PATHS['admin']['css'] . '/style' );
        }

        public function enqueue_scripts(): void
        {
            //			$this->hooks->add_script( B2b::_DOMAIN_NAME.'-admin-script-main', B2b_Hooks::PATHS['admin']['js'] . '/main', [ 'jquery' ] );
            //			$this->hooks->add_localization(B2b::_DOMAIN_NAME.'-admin-script-main', 'b2bGlobals', array(
            //				'domain_key'  => B2b::_DOMAIN_NAME,
            //				'ajaxUrl' => admin_url('admin-ajax.php'),
            //			));
            $this->hooks->run();

        }

        /**
         * Description...
         *
         * @param $forms
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        public function add_custom_recaptcha_forms($forms)
        {
            $forms['frontend_login']           = [ "form_name" => "Front End Login" ];
            $forms['frontend_registration']           = [ "form_name" => "Front End Register" ];
            $forms['frontend_reset_password']  = [ "form_name" => "Front End Reset Password" ];
            $forms['frontend_forgot_password'] = [ "form_name" => "Front End Forgot Password" ];
            return $forms;
        }

    }
