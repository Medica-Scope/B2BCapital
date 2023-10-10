<?php
    /**
     * Functions which enhance the theme by hooking into WordPress
     *
     * @package NinjaHub
     */

    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\Nh;

    add_action('tgmpa_register', 'ninja_register_required_plugins');

    /**
     * Register the required plugins for this theme.
     *
     * In this example, we register five plugins:
     * - one included with the TGMPA library
     * - two from an external source, one from an arbitrary source, one from a GitHub repository
     * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
     *
     * The variables passed to the `tgmpa()` function should be:
     * - an array of plugin arrays;
     * - optionally a configuration array.
     * If you are not changing anything in the configuration array, you can remove the array and remove the
     * variable from the function call: `tgmpa( $plugins );`.
     * In that case, the TGMPA default settings will be used.
     *
     * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
     */
    function ninja_register_required_plugins()
    {

        $slugs = [
            [
                'name' => 'advanced-access-manager',
                'slug' => 'advanced-access-manager'
            ],
            //            [
            //                'name' => 'advanced-custom-fields',
            //                'slug' => 'advanced-custom-fields'
            //            ],
            [
                'name' => 'advanced-custom-fields-pro',
                'slug' => 'advanced-custom-fields-pro'
            ],
            [
                'name' => 'google-captcha',
                'slug' => 'google-captcha'
            ],
            [
                'name' => 'wp-optimize',
                'slug' => 'wp-optimize'
            ],
            [
                'name' => 'health-check',
                'slug' => 'health-check'
            ],
            [
                'name' => 'updraftplus',
                'slug' => 'updraftplus'
            ],
            [
                'name' => 'wp-mail-smtp',
                'slug' => 'wp-mail-smtp'
            ],
            [
                'name' => 'wps-hide-login',
                'slug' => 'wps-hide-login'
            ]
        ];

        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = [
            [
                'name'             => 'NinjaHub Configurations',
                // The plugin name.
                'slug'             => 'nh-configurations',
                // The plugin slug (typically the folder name).
                'source'           => 'https://github.com/MustafaShaaban/ninja-hub-theme-settings/archive/refs/heads/main.zip',
                // The plugin source.
                'required'         => TRUE,
                // If false, the plugin is only 'recommended' instead of required.
                'force_activation' => TRUE,
                'external_url'     => 'https://github.com/MustafaShaaban/ninja-hub-theme-settings',
                // If set, overrides default API URL and points to an external URL.
            ]
        ];

        foreach ($slugs as $slug) {
            $plugins[] = [
                'name'     => $slug['name'],
                // The plugin name.
                'slug'     => $slug['slug'],
                // The plugin source.
                'required' => TRUE,
                // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                //				'force_activation' => TRUE,
            ];
        }

        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = [
            'id'           => 'ninja',
            // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',
            // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins',
            // Menu slug.
            'has_notices'  => TRUE,
            // Show admin notices or not.
            'dismissable'  => FALSE,
            // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',
            // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => FALSE,
            // Automatically activate plugins after installation or not.
            'message'      => '',
            // Message to output right before the plugins table.
        ];

        tgmpa($plugins, $config);
    }

    //    $notifications = new \NH\APP\MODELS\FRONT\MODULES\Nh_Notification();
    //    for ($i = 0; $i < 7; $i++) {
    //        $notifications->send(13, 12, 'bidding', [ 'project_id' => '157' ]);
    //    }


    //    $ch = curl_init();
    //
    //    curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/AC6fd8e3d3e4b54dcfbb681ebd0fec3cec/Messages.json');
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //    curl_setopt($ch, CURLOPT_POST, 1);
    //    curl_setopt($ch, CURLOPT_USERPWD, 'AC6fd8e3d3e4b54dcfbb681ebd0fec3cec' . ':' . '859d2d5288fd109930458ae91f2b342f');
    //
    //    // Disabling SSL Certificate verification
    //    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //
    //    $data = [
    //        'To'   => '+2010169997000',
    //        'From' => '+19894738633',
    //        'Body' => 'test'
    //    ];
    //    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //
    //    $result = curl_exec($ch);
    //    if (curl_errno($ch)) {
    //        echo 'Error:' . curl_error($ch);
    //    }
    //    curl_close($ch);


    /**
     * Description...
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Ahmed Gamal
     * @return string
     */
    function add_new_columns($columns) {
        $columns['fav_count'] = 'Favorite count';
        $columns['ignore_count'] = 'Ignore count';
        $columns['read_count'] = 'Read count';
        return $columns;
    }
    add_filter('manage_post_posts_columns', 'add_new_columns');
    
    function populate_columns($column, $post_id) {
        if ($column == 'fav_count') {
            echo get_post_meta($post_id, 'fav_count', true);
        } elseif ($column == 'ignore_count') {
            echo get_post_meta($post_id, 'ignore_count', true);
        } elseif ($column == 'read_count') {
            echo get_post_meta($post_id, 'read_count', true);
        }
    }
    add_action('manage_post_posts_custom_column', 'populate_columns', 10, 2);

    function my_acf_form_head()
    {
        acf_form_head();
    }

    add_action('get_header', 'my_acf_form_head');
//    add_action('pre_get_posts', 'change_archive_posts_per_page');
//    function change_archive_posts_per_page($query)
//    {
//
//        if (!$query->is_main_query()) {
//            return;
//        }
//
//        $posts_per_page = get_option('posts_per_page');
//        if (is_front_page()) {
//            $query->set('posts_per_page', 12);
//            return;
//        }
//
//    }

//    function my_acf_form_head()
//    {
//        acf_form_head();
//    }
//    add_action('get_header', 'my_acf_form_head');

//    function my_after_acf_form_submission($post_id)
//    {
//
//        if (is_page('create-opportunity-step-2') && isset($_GET['q']) && !empty(unserialize(Nh_Cryptor::Decrypt($_GET['q'])))) {
//            $data = unserialize(Nh_Cryptor::Decrypt($_GET['q']));
//            if ($post_id === $data['opp_id']) {
//                if (!session_id()) {
//                    session_start();
//                }
//                $_SESSION['step_two'] = [];
//                wp_safe_redirect(apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))));
//                exit();
//            }
//        }
//    }
//    add_action('acf/save_post', 'my_after_acf_form_submission', 20);
