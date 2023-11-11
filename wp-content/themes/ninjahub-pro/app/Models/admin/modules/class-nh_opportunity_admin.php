<?php
    /**
     * @Filename: class-nh_opportunity_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */

    namespace NH\APP\MODELS\ADMIN\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;
    use stdClass;

    /**
     * Description...
     *
     * @class Nh_Profile_Admin
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Opportunity_Admin extends Nh_Module
    {
        public array $meta_data = [];

        public function __construct()
        {
            parent::__construct('opportunity');
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
        public function convert(\WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('restrict_manage_posts', $this, 'my_custom_meta_key_filter_dropdown');
            $this->hooks->add_action('save_post', $this, 'notifications_handler', 10, 3);

        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
            $this->hooks->add_filter('acf/location/rule_match/post', $this, 'acf_location_rules', 10, 4);
            $this->hooks->add_filter('pre_get_posts', $this, 'filter_opportunities_by_user_role_and_opp_stage', 10, 1);
            $this->hooks->add_filter('wp_count_posts', $this, 'custom_post_count', 10, 3);
        }

        public function acf_location_rules($match, $rule, $options, $field_group)
        {

            $post_id = get_the_ID();
            $obj     = $this->get_by_id($post_id);
            if (!empty($obj->taxonomy['opportunity-category'])) {

                $form_template = get_term_meta($obj->taxonomy['opportunity-category'][0]->term_id, 'form_template', TRUE);

                if (!empty($form_template)) {

                    // Your specific field group ID
                    $target_field_group_id = $this->get_field_groups_by_post_id($form_template); // Replace with your field group ID

                    // Array of post IDs where you want to assign the field group
                    $target_post_ids = [ $post_id ]; // Replace with your array of post IDs

                    // Check if we are on the correct field group
                    if (acf_is_screen('opportunity')) {
                        // Check if the current post ID is in the array of target post IDs
                        if (isset($options['post_id']) && in_array($options['post_id'], $target_post_ids) && $field_group['key'] == $target_field_group_id[0]['key']) {
                            $match = TRUE;
                        }
                    }
                }
            }
            return $match;
        }

        public function filter_opportunities_by_user_role_and_opp_stage($query): void
        {
            if (!is_admin() || !$query->is_main_query()) {
                return;
            }

            // Ensure we are in the admin area and working with the main query
            // Get the current screen
            $screen = get_current_screen();

            // Check if we're on the main admin post list page
            if ($screen && $screen->id === 'edit-opportunity') {

                // Check the post type
                if ($query->get('post_type') === 'opportunity') {
                    // Get the current user's role
                    $current_user = wp_get_current_user();
                    $roles        = $current_user->roles;

                    // Check for specific roles and modify the query
                    if (in_array(Nh_User::REVIEWER, $roles)) {
                        $meta_query = [
                            [
                                'key'     => 'opportunity_stage',
                                'value'   => [
                                    'new',
                                    'approved',
                                    'hold',
                                    'cancel',
                                    'content-rejected'
                                ],
                                'compare' => 'IN',
                            ],
                        ];

                        $query->set('meta_query', $meta_query);
                    } elseif (in_array(Nh_User::CMS, $roles)) {
                        $meta_query = [
                            [
                                'key'     => 'opportunity_stage',
                                'value'   => [
                                    'approved',
                                    'content-verified',
                                    'content-rejected',
                                    'translated',
                                    'publish'
                                ],
                                'compare' => 'IN',
                            ],
                        ];

                        $query->set('meta_query', $meta_query);
                    } elseif (in_array(Nh_User::SEO, $roles)) {
                        $meta_query = [
                            [
                                'key'     => 'opportunity_stage',
                                'value'   => [
                                    'content-verified',
                                    'seo-verified'
                                ],
                                'compare' => 'IN',
                            ],
                        ];

                        $query->set('meta_query', $meta_query);
                    } elseif (in_array(Nh_User::TRANSLATOR, $roles)) {
                        $meta_query = [
                            [
                                'key'     => 'opportunity_stage',
                                'value'   => [
                                    'translated',
                                    'seo-verified'
                                ],
                                'compare' => 'IN',
                            ],
                        ];
                        $query->set('meta_query', $meta_query);
                    }
                }

                global $pagenow;
                $post_type = 'opportunity';
                $meta_key  = 'opportunity_stage';
                if (is_admin() && $pagenow == 'edit.php' && $query->is_main_query() && !empty($_GET[$meta_key]) && $query->query['post_type'] == $post_type) {
                    $query->set('meta_key', $meta_key);
                    $query->set('meta_value', $_GET[$meta_key]);
                }
            }
        }

        public function custom_post_count($counts, $type, $perm)
        {
            // Check if we're in the admin interface and if it's the correct post type
            if (is_admin() && $type == 'opportunity') {
                global $wpdb, $sitepress;

                // Get the current language code from WPML
                $current_language = $sitepress->get_current_language();
                // Perform custom query adjustments here
                // For example, modifying the count based on user role conditions
                // $counts->publish = $custom_published_count;
                // $counts->draft = $custom_draft_count;
                // ... and so on for each status you want to adjust
                $languages = apply_filters('wpml_active_languages', NULL);

                // Initialize language-specific counts
                foreach ($languages as $lang_code => $lang) {
                    $counts->{$lang_code} = new stdClass();
                    foreach (get_post_stati() as $status) {
                        $counts->{$lang_code}->{$status} = 0; // Initialize all counts to 0
                    }
                }
                $query        = [
                    "order"          => "asc",
                    "orderby"        => "menu_order title",
                    "fields"         => "ids",
                    "post_status"    => "publish",
                    "post_type"      => "opportunity",
                    "posts_per_page" => -1,
                    'meta_query'     => [
                        'relation' => 'AND',
                    ]
                ];
                $current_user = wp_get_current_user();
                $roles        = $current_user->roles;

                // Check for specific roles and modify the query
                if (in_array(Nh_User::REVIEWER, $roles)) {
                    $meta_query = [
                        'key'     => 'opportunity_stage',
                        'value'   => [
                            'new',
                            'approved',
                            'hold',
                            'cancel',
                            'content-rejected'
                        ],
                        'compare' => 'IN',
                    ];
                    if (!empty($_GET['opportunity_stage'])) {
                        $meta_query['value'] = $_GET['opportunity_stage'];
                    }

                    $query['meta_query'][] = $meta_query;
                } elseif (in_array(Nh_User::CMS, $roles)) {
                    $meta_query = [
                        'key'     => 'opportunity_stage',
                        'value'   => [
                            'approved',
                            'content-verified',
                            'content-rejected',
                            'translated',
                            'publish'
                        ],
                        'compare' => 'IN',
                    ];
                    if (!empty($_GET['opportunity_stage'])) {
                        $meta_query['value'] = $_GET['opportunity_stage'];
                    }
                    $query['meta_query'][] = $meta_query;
                } elseif (in_array(Nh_User::SEO, $roles)) {
                    $meta_query = [
                        'key'     => 'opportunity_stage',
                        'value'   => [
                            'content-verified',
                            'seo-verified'
                        ],
                        'compare' => 'IN',
                    ];
                    if (!empty($_GET['opportunity_stage'])) {
                        $meta_query['value'] = $_GET['opportunity_stage'];
                    }
                    $query['meta_query'][] = $meta_query;
                } elseif (in_array(Nh_User::TRANSLATOR, $roles)) {
                    $meta_query = [
                        'key'     => 'opportunity_stage',
                        'value'   => [
                            'translated',
                            'seo-verified'
                        ],
                        'compare' => 'IN',
                    ];
                    if (!empty($_GET['opportunity_stage'])) {
                        $meta_query['value'] = $_GET['opportunity_stage'];
                    }
                    $query['meta_query'][] = $meta_query;
                }

                $counts->publish = count(get_posts($query));
                // $counts->en->publish = count(get_posts($query));

            }
            // var_dump($counts);
            return $counts;
        }

        public function my_custom_meta_key_filter_dropdown()
        {
            global $pagenow, $post_type;

            $meta_key = 'opportunity_stage';

            if ('opportunity' === $post_type && 'edit.php' === $pagenow) {
                $current_user = wp_get_current_user();
                $roles        = $current_user->roles;

                $options = [];
                if (in_array(Nh_User::REVIEWER, $roles)) {
                    $options = [
                        'new',
                        'approved',
                        'hold',
                        'cancel',
                        'content-rejected'
                    ];
                } elseif (in_array(Nh_User::CMS, $roles)) {
                    $options = [
                        'approved',
                        'content-verified',
                        'content-rejected',
                        'translated',
                        'publish'
                    ];
                } elseif (in_array(Nh_User::SEO, $roles)) {
                    $options = [
                        'content-verified',
                        'seo-verified'
                    ];
                } elseif (in_array(Nh_User::TRANSLATOR, $roles)) {
                    $options = [
                        'translated',
                        'seo-verified'
                    ];
                }

                echo '<select name="' . esc_attr($meta_key) . '">';
                echo '<option value="">All</option>';
                foreach ($options as $option) {
                    $selected = isset($_GET[$meta_key]) && $_GET[$meta_key] == $option ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr($option) . '"' . $selected . '>' . esc_html($option) . '</option>';
                }
                echo '</select>';
            }
        }

        /**
         * Description...
         *
         * @param $post_id
         * @param $post
         * @param $update
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function notifications_handler($post_id, $post, $update): void
        {
            global $pagenow, $user_ID;

            // Check if this is an autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return;

            // Check the user's permissions
            if (!current_user_can('edit_post', $post_id))
                return;

            if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
                if ($update && $post->post_type == 'opportunity') {

                    if (!class_exists('NH\APP\MODELS\FRONT\MODULES\Nh_Notification')) {
                        locate_template("app/Models/public/modules/class-nh_notification.php", TRUE);
                    }

                    $old_stage = get_post_meta($post_id, 'opportunity_stage_old', TRUE);
                    $new_stage = get_field('opportunity_stage', $post_id);

                    update_post_meta($post_id, 'opportunity_stage_old', $new_stage);

                    switch ($new_stage) {
                        //                        case "new":
                        //                            $notifications = new Nh_Notification();
                        //                            $notifications->send($user_ID, $post->post_author, 'opportunity_new', [
                        //                                'opportunity_id' => $post->ID,
                        //                                'opportunity'    => $post
                        //                            ]);
                        //                            break;
                        case "approved":
                            if (in_array($old_stage, [
                                'new',
                                'hold',
                                'cancel'
                            ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_approve', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        case "hold":
                            if (in_array($old_stage, [
                                'new',
                                'cancel'
                            ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_hold', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        case "cancel":
                            if (in_array($old_stage, [
                                'new',
                                'hold'
                            ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_cancel', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        case "content-verified":
                            if (in_array($old_stage, [
                                'approved',
                                'hold',
                                'cancel',
                                'content-rejected'
                            ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_content_verified', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                                break;
                            }
                        case "seo-verified":
                            if (in_array($old_stage, [ 'content-verified' ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_seo_verified', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        case "translated":
                            if (in_array($old_stage, [ 'seo-verified' ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_translated', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        case "publish" :
                            if (in_array($old_stage, [ 'translated' ])) {
                                $notifications = new Nh_Notification();
                                $notifications->send($user_ID, $post->post_author, 'opportunity_published', [
                                    'opportunity_id' => $post->ID,
                                    'opportunity'    => $post
                                ]);
                            }
                            break;
                        default:
                            break;
                    }

                }
            }


            // Perform your actions here
        }

        /**
         * Description...
         *
         * @param $post_id
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        private function get_field_groups_by_post_id($post_id): array
        {
            $matched_groups = [];

            // Get all the field groups
            $field_groups = acf_get_field_groups();

            foreach ($field_groups as $field_group) {

                if (isset($field_group['location']) && is_array($field_group['location'])) {

                    foreach ($field_group['location'] as $group_locations) {
                        foreach ($group_locations as $rule) {

                            if ( // Check if field group is assigned to the specific post ID
                            ($rule['param'] === 'post' && $rule['operator'] === '==' && intval($rule['value']) === (int)$post_id)) {
                                $matched_groups[] = [
                                    'ID'  => $field_group['ID'],
                                    'key' => $field_group['key']
                                ]; // Store the field group key
                                break 2; // exit both foreach loops if match found
                            }
                        }
                    }
                }
            }

            return $matched_groups;
        }
    }
