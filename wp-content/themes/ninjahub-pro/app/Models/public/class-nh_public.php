<?php
    /**
     * @Filename: class-nh_public.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 25/10/2021
     */

    namespace NH\APP\MODELS\FRONT;

    use NH\APP\CLASSES\Nh_Init;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Public
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Public
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
            $this->hooks->add_filter('nhml_permalink', $this, 'nhml_permalink', 10, 1);
            $this->hooks->run();
        }

        public function enqueue_styles(): void
        {

            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-bbcicons', Nh_Hooks::PATHS['public']['vendors'] . '/css/bbc-icons/style.css', TRUE);
            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-itl', Nh_Hooks::PATHS['public']['vendors'] . '/css/intl-tel-input-18.1.6/css/intlTelInput.min.css', TRUE);
            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-choices', Nh_Hooks::PATHS['public']['vendors'] . '/css/choices/choices.min.css', TRUE);

            // if ( NH_lANG === 'ar' ) {
            // 	$this->hooks->add_style( Nh::_DOMAIN_NAME . '-public-style-bs5', Nh_Hooks::PATHS['public']['vendors'] . '/css/bootstrap5/bootstrap.rtl.min.css', TRUE );
            // } else {
            // 	$this->hooks->add_style( Nh::_DOMAIN_NAME . '-public-style-bs5', Nh_Hooks::PATHS['public']['vendors'] . '/css/bootstrap5/bootstrap.min.css', TRUE );
            // }

            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-main', Nh_Hooks::PATHS['root']['css'] . '/style');
            $this->hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-theme', Nh_Hooks::PATHS['public']['css'] . '/theme');


            $this->hooks->run();
        }

        public function enqueue_scripts(): void
        {
            global $gglcptch_options, $wp;
            $is_single_service = is_single() && 'service' == get_post_type();

            // Vendors
            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-popper', Nh_Hooks::PATHS['public']['vendors'] . '/js/popper.min.js', [
                'jquery'
            ], Nh::_VERSION, NULL, TRUE);
            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-bs5', Nh_Hooks::PATHS['public']['vendors'] . '/js/bootstrap5/bootstrap.min.js', [
                'jquery'
            ], Nh::_VERSION, NULL, TRUE);

            if (is_front_page() || is_page([
                    'login',
                    'registration',
                    'forgot-password'
                ]) || $is_single_service || is_404()) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-landing-main', Nh_Hooks::PATHS['public']['js'] . '/landing-main', [ Nh::_DOMAIN_NAME . '-public-script-dotlottie-player' ]);
            }


            $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-main', Nh_Hooks::PATHS['public']['js'] . '/main', [
                'jquery',
                Nh::_DOMAIN_NAME . '-public-script-bs5'
            ]);

            $this->hooks->add_localization(Nh::_DOMAIN_NAME . '-public-script-main', 'nhGlobals', [
                'domain_key'  => Nh::_DOMAIN_NAME,
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'environment' => Nh::_ENVIRONMENT,
                'publicKey'   => isset($gglcptch_options) ? $gglcptch_options['public_key'] : '',
                'phrases'     => [
                    'default'        => __("This field is required.", "ninja"),
                    'email'          => __("Please enter a valid email address.", "ninja"),
                    'number'         => __("Please enter a valid number.", "ninja"),
                    'equalTo'        => __("Please enter the same value again.", "ninja"),
                    'maxlength'      => __("Please enter no more than {0} characters.", "ninja"),
                    'minlength'      => __("Please enter at least {0} characters.", "ninja"),
                    'max'            => __("Please enter a value less than or equal to {0}.", "ninja"),
                    'min'            => __("Please enter a value greater than or equal to {0}.", "ninja"),
                    'pass_regex'     => __("Your password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character from the following: ! @ # $ % ^ & *.", "ninja"),
                    'phone_regex'    => __("Please enter a valid Phone number.", "ninja"),
                    'intlTelNumber'  => __("Please enter a valid International Telephone Number.", "ninja"),
                    'email_regex'    => __("Please enter a valid email address.", "ninja"),
                    'file_extension' => __("Please upload an image with a valid extension.", "ninja"),
                    'choices_select' => __("Press to select", "ninja"),
                    'noChoicesText'  => __("'No choices to choose from'", "ninja"),
                ]
            ]);

            if (preg_match('#^my-account/my-favorite-articles(/.+)?$#', $wp->request) || preg_match('#^my-account/my-ignored-articles(/.+)?$#', $wp->request) || preg_match('#^blogs(/.+)?$#', $wp->request) || is_post_type_archive('post') || is_singular('post')) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-blog', Nh_Hooks::PATHS['public']['js'] . '/blog-front');
            }

            if (is_page([
                'my-account',
                'change-password',
                'my-opportunities',
                'my-widgets',
                'my-notifications',
                'my-favorite-opportunities',
				'my-ignored-opportunities',
                'dashboard',
                'create-opportunity',
                'blogs'
            ])) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-notifications', Nh_Hooks::PATHS['public']['js'] . '/notification-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-search', Nh_Hooks::PATHS['public']['js'] . '/search-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-opportunity', Nh_Hooks::PATHS['public']['js'] . '/opportunity-front');
            }

			if(is_singular(['opportunity'])){
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-notifications', Nh_Hooks::PATHS['public']['js'] . '/notification-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-search', Nh_Hooks::PATHS['public']['js'] . '/search-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-opportunity', Nh_Hooks::PATHS['public']['js'] . '/opportunity-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-bidding', Nh_Hooks::PATHS['public']['js'] . '/bidding-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-acquisition', Nh_Hooks::PATHS['public']['js'] . '/acquisition-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-investment', Nh_Hooks::PATHS['public']['js'] . '/investment-front');
			}

            if (is_post_type_archive('faq')) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-notifications', Nh_Hooks::PATHS['public']['js'] . '/notification-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-search', Nh_Hooks::PATHS['public']['js'] . '/search-front');
            }

            if (is_page([
                'my-account',
                'change-password',
                'my-opportunities',
                'my-widgets',
                'my-notifications',
                'my-favorite-opportunities',
                'login',
                'industry',
                'reset-password',
                'forgot-password',
                'registration',
                'verification',
                'authentication',
            ])) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-authentication', Nh_Hooks::PATHS['public']['js'] . '/authentication');
            }

            if (is_post_type_archive('service') || is_singular('service') || is_tax('service-category')) {
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-service', Nh_Hooks::PATHS['public']['js'] . '/service-front');
                $this->hooks->add_script(Nh::_DOMAIN_NAME . '-public-script-appointment', Nh_Hooks::PATHS['public']['js'] . '/appointment-front');
            }

            $this->hooks->run();
        }

        /**
         * NH INIT
         */
        public function init(): void
        {
            session_start();
        }

        public function nhml_permalink($url)
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
         * @package NinjaHub
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

        public static function breadcrumbs(): void
        {
            global $post, $wp;

            $separator = Nh_Init::$_NH_lANG === 'ar' ? ' <i class="bbc-chevron-left"></i> ' : ' <i class="bbc-chevron-right"></i> ';

            echo '<div class="breadcrumbs">';
            if (preg_match('#my-account#', $wp->request)) {
                $page_link = get_the_permalink(get_page_by_path('dashboard'));
                echo '<a href="' . apply_filters('nhml_permalink', $page_link) . '">' . __('Dashboard', 'ninja') . '</a>';
            } else {
                echo '<a href="' . apply_filters('nhml_permalink', home_url()) . '">' . __('Home', 'ninja') . '</a>';
            }
            echo $separator;

            if (is_category() || is_single()) {
                if (is_single()) {
                    the_category($separator);
                    echo $separator;
                    the_title();
                } else {
                    single_cat_title();
                }
            } elseif (is_page()) {
                if ($post->post_parent) {
                    $anc    = get_post_ancestors($post->ID);
                    $output = '';
                    foreach ($anc as $ancestor) {
                        $output = '<a href="' . apply_filters('nhml_permalink', get_permalink($ancestor)) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a> ' . $separator;
                    }
                    echo $output;
                }
                the_title();
            } elseif (is_archive()) {
                echo post_type_archive_title();
            }

            echo '</div>'; // End breadcrumbs
        }
    }
