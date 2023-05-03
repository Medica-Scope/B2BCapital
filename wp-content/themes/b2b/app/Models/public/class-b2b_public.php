<?php
    /**
     * @Filename: class-b2b_public.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 25/10/2021
     */

    namespace B2B\APP\MODELS\FRONT;

    use B2B\APP\CLASSES\B2b_Init;
    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Public
     * @version 1.0
     * @since 1.0.0
     * @package B2B
     * @author APPENZA - Mustafa Shaaban
     */
    class B2b_Public
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
                    ->run('public');

        }

        public function actions(): void
        {
            $this->hooks->add_action('wp_enqueue_scripts', $this, 'enqueue_styles');
            $this->hooks->add_action('wp_enqueue_scripts', $this, 'enqueue_scripts');
            $this->hooks->add_action('init', $this, 'init', 1);
            $this->hooks->run();
        }

        public function filters(): void
        {
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {
            if (B2B_lANG === 'ar') {
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-main', B2b_Hooks::PATHS['root']['css'] . '/style-rtl');
            } else {
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-main', B2b_Hooks::PATHS['root']['css'] . '/style');
            }

            $this->hooks->run();
        }

        public function enqueue_scripts(): void
        {
            $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-main', B2b_Hooks::PATHS['public']['js'] . '/main', [
                'jquery'
            ]);

            $this->hooks->add_localization(B2b::_DOMAIN_NAME . '-public-script-main', 'b2bGlobals', [
                'domain_key'  => B2b::_DOMAIN_NAME,
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'environment' => B2b::_ENVIRONMENT,
                'phrases'     => [
                    'default'           => __("This field is required.", "b2b"),
                    'email'             => __("Please enter a valid email address.", "b2b"),
                    'number'            => __("Please enter a valid number.", "b2b"),
                    'equalTo'           => __("Please enter the same value again.", "b2b"),
                    'maxlength'         => __("Please enter no more than {0} characters.", "b2b"),
                    'minLength'         => __("Please enter at least {0} characters.", "b2b"),
                    'max'               => __("Please enter a value less than or equal to {0}.", "b2b"),
                    'min'               => __("Please enter a value greater than or equal to {0}.", "b2b"),
                    'pass_regex'        => __("Password doesn't complexity.", "b2b"),
                    'phone_regex'       => __("Please enter a valid Phone number.", "b2b"),
                    'email_regex'       => __("Please enter a valid email address.", "b2b"),
                    'file_extension'    => __("Please upload an image with a valid extension.", "b2b")
                ]
            ]);


            $this->hooks->run();
        }

        /**
         * B2B INIT
         */
        public function init(): void
        {
            session_start();
        }
    }
