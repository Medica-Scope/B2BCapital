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
     * @package b2b
     * @author Mustafa Shaaban
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
            $this->hooks->add_filter('b2bml_permalink', $this, 'b2bml_permalink', 10, 1);
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {

            $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-fontawesome', B2b_Hooks::PATHS['public']['vendors'] . '/css/fontawesome/css/all.min', TRUE);
            $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-itl', B2b_Hooks::PATHS['public']['vendors'] . '/css/intl-tel-input-18.1.6/css/intlTelInput.min', TRUE);
            $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-choices', B2b_Hooks::PATHS['public']['vendors'] . '/css/choices/choices.min', TRUE);

            if (B2B_lANG === 'ar') {
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-bs5', B2b_Hooks::PATHS['public']['vendors'] . '/css/bootstrap5/bootstrap.rtl.min', TRUE);
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-main', B2b_Hooks::PATHS['root']['css'] . '/style-rtl');
            } else {
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-bs5', B2b_Hooks::PATHS['public']['vendors'] . '/css/bootstrap5/bootstrap.min', TRUE);
                $this->hooks->add_style(B2b::_DOMAIN_NAME . '-public-style-main', B2b_Hooks::PATHS['root']['css'] . '/style');
            }

            $this->hooks->run();
        }

        public function enqueue_scripts(): void
        {
            global $gglcptch_options;

            $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-bs5', B2b_Hooks::PATHS['public']['vendors'] . '/js/bootstrap5/bootstrap.min', [
                'jquery'
            ], B2b::_VERSION, NULL, TRUE);

            $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-main', B2b_Hooks::PATHS['public']['js'] . '/main', [
                'jquery',
                B2b::_DOMAIN_NAME . '-public-script-bs5'
            ]);

            $this->hooks->add_localization(B2b::_DOMAIN_NAME . '-public-script-main', 'b2bGlobals', [
                'domain_key'  => B2b::_DOMAIN_NAME,
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'environment' => B2b::_ENVIRONMENT,
                'publicKey'   => $gglcptch_options['public_key'],
                'phrases'     => [
                    'default'        => __("This field is required.", "b2b"),
                    'email'          => __("Please enter a valid email address.", "b2b"),
                    'number'         => __("Please enter a valid number.", "b2b"),
                    'equalTo'        => __("Please enter the same value again.", "b2b"),
                    'maxlength'      => __("Please enter no more than {0} characters.", "b2b"),
                    'minlength'      => __("Please enter at least {0} characters.", "b2b"),
                    'max'            => __("Please enter a value less than or equal to {0}.", "b2b"),
                    'min'            => __("Please enter a value greater than or equal to {0}.", "b2b"),
                    'pass_regex'     => __("Password doesn't complexity.", "b2b"),
                    'phone_regex'    => __("Please enter a valid Phone number.", "b2b"),
                    'intlTelNumber'  => __("Please enter a valid International Telephone Number.", "b2b"),
                    'email_regex'    => __("Please enter a valid email address.", "b2b"),
                    'file_extension' => __("Please upload an image with a valid extension.", "b2b"),
                    'choices_select' => __("Press to select", "b2b"),
                    'noChoicesText'  => __("'No choices to choose from'", "b2b"),
                ]
            ]);

            if (is_page([
                'dashboard',
                'create-opportunity'
            ])) {
                $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-notifications', B2b_Hooks::PATHS['public']['js'] . '/notification-front');
                $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-search', B2b_Hooks::PATHS['public']['js'] . '/search-front');
            }

            if (is_page([
                'my-account',
                'login',
                'industry',
                'reset-password',
                'forgot-password',
                'registration',
                'verification',
                'authentication',
            ])) {
                $this->hooks->add_script(B2b::_DOMAIN_NAME . '-public-script-authentication', B2b_Hooks::PATHS['public']['js'] . '/authentication');
            }

            $this->hooks->run();
        }

        /**
         * B2B INIT
         */
        public function init(): void
        {
            session_start();
        }

        public function b2bml_permalink($url)
        {
            global $user_ID, $wp;
            if (is_user_logged_in() && is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
                $user_site_language = get_user_meta($user_ID, 'site_language', TRUE);
                $user_site_language = empty($user_site_language) ? 'en' : $user_site_language;

                // Check if the current URL contains the Arabic slug ("/ar/") or the language parameter ("?lang=ar").
                if (!str_contains($url, "/$user_site_language/") && !str_contains($url, "?lang=$user_site_language")) {
                    $redirect_url = apply_filters('wpml_permalink', $url, $user_site_language); // Get the Arabic version of the current page or post URL.
                    if ($redirect_url) {
                        $url = $redirect_url;
                    }
                }
            }

            return $url;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public static function get_available_languages(): array
        {
            $languages       = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
            $languages_codes = [];

            if (!empty($languages)) {
                foreach ($languages as $l) {
                    $languages_codes[] = [
                        'code' => $l['language_code'],
                        'name' => $l['translated_name']
                    ];
                }
            }
            return $languages_codes;
        }
    }
