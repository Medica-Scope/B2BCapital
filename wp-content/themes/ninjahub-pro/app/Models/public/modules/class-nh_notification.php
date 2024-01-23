<?php
    /**
     * @Filename: class-nh_notification.php
     * @Description: This file contains the implementation of the Nh_Notification class,
     * which is a module for handling notifications in the NH application.
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */

    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Ajax_Response;
use NH\APP\HELPERS\Nh_Forms;
use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\HELPERS\Nh_Mail;
    use NH\Nh;

    /**
     * Class Nh_Notification
     * Handles notifications in the NH application.
     *
     * @package NH\APP\MODELS\FRONT\MODULES
     * @version 1.0
     * @since 1.0.0
     */
    class Nh_Notification extends Nh_Module
    {
        /**
         * @var array An array of metadata keys associated with notifications.
         */
        public array $meta_data = [
            'notification_data',
            'new',
        ];

        /**
         * @var array An array of taxonomy names associated with notifications.
         */
        public array $taxonomy = [];

        /**
         * Nh_Notification constructor.
         * Initializes the Nh_Notification object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         */
        public function __construct()
        {
            parent::__construct('notification');
        }

        /**
         * Converts a \WP_Post object into a Nh_Post object.
         *
         * @param \WP_Post $post The \WP_Post object to convert.
         * @param array    $meta_data An array of meta data keys associated with notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return Nh_Post The converted Nh_Post object.
         */
        public function convert(\WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data);
        }

        /**
         * Performs actions specific to the Nh_Notification module.
         *
         * @param string $module_name The name of the module.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_read_notifications_ajax', $this, 'read_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_read_notifications_ajax', $this, 'read_ajax');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_clear_notifications_ajax', $this, 'clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_clear_notifications_ajax', $this, 'clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_item_clear_notifications_ajax', $this, 'item_clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_item_clear_notifications_ajax', $this, 'item_clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_loadmore_notifications_ajax', $this, 'loadmore_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_loadmore_notifications_ajax', $this, 'loadmore_notifications_ajax');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_read_new_notifications_ajax', $this, 'read_new_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_read_new_notifications_ajax', $this, 'read_new_notifications_ajax');
        }

        /**
         * Performs filters specific to the Nh_Notification module.
         *
         * @param string $module_name The name of the module.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        /**
         * Retrieves all notifications for the current user.
         *
         * @return array An array of notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @throws \Exception
         */
        public function get_notifications(int $limit = 10): array
        {
            global $wpdb, $user_ID;

            $all      = $this->get_all_custom([ 'publish' ], $limit);
            $html_obj = [
                'notifications' => []
            ];
            foreach ($all['posts'] as $single) {
                $html_obj['notifications'][] = $this->notification_html($single);
            }
            $html_obj['new_count']   = $this->get_new_notifications_count();
            $html_obj['found_posts'] = $all['found_posts'];

            return $html_obj;
        }

        /**
         * Retrieves the count of new notifications for the current user.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return string The count of new notifications.
         */
        public function get_new_notifications_count(): string
        {
            global $wpdb, $user_ID;

            $new_count = $wpdb->get_var("
                SELECT COUNT(*) 
                FROM `" . $wpdb->prefix . "posts`
                INNER JOIN `" . $wpdb->prefix . "postmeta` ON (`" . $wpdb->prefix . "posts`.ID = `" . $wpdb->prefix . "postmeta`.post_id) 
                WHERE `" . $wpdb->prefix . "posts`.post_status = 'publish'
                AND `" . $wpdb->prefix . "posts`.post_type = '$this->type'
                AND `" . $wpdb->prefix . "posts`.post_author = '$user_ID'
                AND `" . $wpdb->prefix . "postmeta`.meta_key = 'new'
                AND `" . $wpdb->prefix . "postmeta`.meta_value = '1'
            ");
            return $new_count > 20 ? '+20' : $new_count;
        }

        /**
         * Retrieves all notifications for the current user with custom parameters.
         *
         * @param array $status An array of post statuses.
         * @param int   $limit The number of notifications to retrieve.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return array An array of notifications.
         */
        public function get_all_custom(array $status = [ 'any' ], int $limit = 10, $author = 0): array
        {
            global $user_ID;

            if (!$author) {
                $author = $user_ID;
            }

            $posts = new \WP_Query([
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                "author"         => $author,
                "orderby"        => 'ID',
                "order"          => 'DESC',
            ]);

            $Nh_Posts = [ 'posts' => [] ];

            foreach ($posts->get_posts() as $post) {
                $class

                                     = __CLASS__;
                $nh_module           = new $class;
                $Nh_Posts['posts'][] = $nh_module->assign($this->convert($post, $this->meta_data));
            }

            $Nh_Posts['found_posts'] = $posts->found_posts;

            return $Nh_Posts;
        }

        /**
         * Sends a notification.
         *
         * @param int    $from The ID of the sender.
         * @param int    $to The ID of the recipient.
         * @param string $type The type of the notification.
         * @param array  $data Additional data for the notification.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function send(int $from = 0, int $to = 0, string $type = '', array $data = []): void
        {
            $class            = __CLASS__;
            $notification_obj = new $class();
            switch ($type) {
                case 'opportunity_new':
                    $users = Nh_User::get_users_by_role([ Nh_User::REVIEWER ]);
                    foreach ($users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity - <strong>%s</strong> Issued", 'ninja');
                        $notification_obj->content                        = __('A new opportunity <strong>%s</strong> from <strong>%s</strong> has been issued and it is waiting for reviewing.', 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_new',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_new', [
                            'to_email'          => $user->email,
                            'role'              => Nh_User::REVIEWER,
                            'user'              => $user,
                            'opportunity_id'    => $data['opportunity_id'],
                            'opportunity_title' => $data['opportunity_title'],
                        ]);
                    }

                    $admin_users = Nh_User::get_users_by_role([ Nh_User::ADMIN ]);
                    foreach ($admin_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity - <strong>%s</strong>", 'ninja');
                        $notification_obj->content                        = __("New opportunity assigned to reviewers and it's waiting for reviewing.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_new',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_new', [
                            'to_email'          => $user->email,
                            'role'              => Nh_User::ADMIN,
                            'user'              => $user,
                            'opportunity_id'    => $data['opportunity_id'],
                            'opportunity_title' => $data['opportunity_title'],
                        ]);
                    }
                    break;

                case 'opportunity_approve':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj                                 = new $class();
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> Approved", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> has been approved and waiting for the verification.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_approve',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_approve', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);


                    $cms_users = Nh_User::get_users_by_role([ Nh_User::CMS ]);
                    foreach ($cms_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity <strong>%s</strong> is waiting for your verification", 'ninja');
                        $notification_obj->content                        = __("New opportunity assigned to you to be verified.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_approve',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_approve', [
                            'to_email'    => $user->email,
                            'role'        => Nh_User::ADMIN,
                            'user'        => $user,
                            'opportunity' => $data['opportunity'],
                        ]);
                    }
                    break;
                case 'opportunity_hold':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> is on hold", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> is on hold.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_hold',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_hold', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);


                    break;
                case 'opportunity_cancel':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> is canceled", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> is canceled.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_cancel',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_cancel', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);

                    break;
                case 'opportunity_content_verified':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj                                 = new $class();
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> Content Verified", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> has been verified and waiting for the seo verification.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_content_verified',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_content_verified', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);


                    $seo_users = Nh_User::get_users_by_role([ Nh_User::SEO ]);
                    foreach ($seo_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity <strong>%s</strong> is waiting for your verification", 'ninja');
                        $notification_obj->content                        = __("New opportunity assigned to you to be verified.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_content_verified',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_content_verified', [
                            'to_email'    => $user->email,
                            'role'        => Nh_User::ADMIN,
                            'user'        => $user,
                            'opportunity' => $data['opportunity'],
                        ]);
                    }
                    break;
                case 'opportunity_seo_verified':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj                                 = new $class();
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> SEO Verified", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> has been verified as SEO and waiting for being translated.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_seo_verified',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_seo_verified', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);


                    $translators_users = Nh_User::get_users_by_role([ Nh_User::TRANSLATOR ]);
                    foreach ($translators_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity <strong>%s</strong> is waiting for your translation", 'ninja');
                        $notification_obj->content                        = __("New opportunity assigned to you to be translated.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_seo_verified',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_seo_verified', [
                            'to_email'    => $user->email,
                            'role'        => Nh_User::ADMIN,
                            'user'        => $user,
                            'opportunity' => $data['opportunity'],
                        ]);
                    }
                    break;
                case 'opportunity_translated':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj                                 = new $class();
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> Translated", 'ninja');
                    $notification_obj->content                        = __('Your opportunity <strong>%s</strong> has been translated and waiting for the final review to be published.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_translated',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_translated', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);


                    $cms_users = Nh_User::get_users_by_role([ Nh_User::CMS ]);
                    foreach ($cms_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Opportunity - <strong>%s</strong> is waiting for your action", 'ninja');
                        $notification_obj->content                        = __("New opportunity assigned to you to be published.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_translated',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_translated', [
                            'to_email'    => $user->email,
                            'role'        => Nh_User::ADMIN,
                            'user'        => $user,
                            'opportunity' => $data['opportunity'],
                        ]);
                    }
                    break;
                case 'opportunity_published':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj                                 = new $class();
                    $notification_obj->title                          = __("Opportunity <strong>%s</strong> is Published", 'ninja');
                    $notification_obj->content                        = __('Congrats!, Your opportunity <strong>%s</strong> has been published now.', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'opportunity_published',
                        'from'           => __('B2B', "ninja"),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('opportunity_published', [
                        'to_email'    => $user->email,
                        'role'        => Nh_User::ADMIN,
                        'user'        => $user,
                        'opportunity' => $data['opportunity'],
                    ]);

                    $admin_users = Nh_User::get_users_by_role([ Nh_User::ADMIN ]);
                    foreach ($admin_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("Opportunity Published", 'ninja');
                        $notification_obj->content                        = __("The opportunity <strong>%s</strong> is published and ready.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_published',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('opportunity_published', [
                            'to_email'    => $user->email,
                            'role'        => Nh_User::ADMIN,
                            'user'        => $user,
                            'opportunity' => $data['opportunity'],
                        ]);
                    }


                    $investor_users = Nh_User::get_users_by_role([ Nh_User::INVESTOR ]);
                    foreach ($investor_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("A New Opportunity <strong>%s</strong> is published!", 'ninja');
                        $notification_obj->content                        = __("opportunity <strong>%s</strong> is published check it now!.", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'opportunity_published',
                            'from'           => __('B2B', "ninja"),
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();
                    }
                    break;
                case 'bidding':
                    $user                                             = Nh_User::get_user_by('ID', $from);
                    $notification_obj->title                          = __("New Bidding", 'ninja');
                    $notification_obj->content                        = __('You have a new bidding on your project <strong>%s</strong>', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'bidding',
                        'from'           => $user->display_name,
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('bidding', [
                        'to_email'       => $user->email,
                        'role'           => Nh_User::ADMIN,
                        'user'           => $user,
                        'opportunity_id' => $data['opportunity_id'],
                    ]);


                    $admin_users = Nh_User::get_users_by_role([ Nh_User::ADMIN ]);
                    foreach ($admin_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New bid for <strong>%s</strong>", 'ninja');
                        $notification_obj->content                        = __("<strong>%s</strong> bid on <strong>%s</strong>", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'bidding',
                            'from'           => $from,
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('bidding', [
                            'to_email'       => $user->email,
                            'role'           => Nh_User::ADMIN,
                            'user'           => $user,
                            'opportunity_id' => $data['opportunity_id'],
                        ]);
                    }

                    break;
                case 'acquisition':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj->title                          = __("New Acquisition Request", 'ninja');
                    $notification_obj->content                        = __('You have a new acquisition request on your project <strong>%s</strong>', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'acquisition',
                        'from'           => __('B2B', 'ninja'),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('acquisition', [
                        'to_email'       => $user->email,
                        'role'           => Nh_User::ADMIN,
                        'user'           => $user,
                        'opportunity_id' => $data['opportunity_id'],
                    ]);


                    $admin_users = Nh_User::get_users_by_role([ Nh_User::ADMIN ]);
                    foreach ($admin_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Acquisition Request", 'ninja');
                        $notification_obj->content                        = __("New acquisition request from <strong>%s</strong> on <strong>%s</strong>", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'acquisition',
                            'from'           => $from,
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('acquisition', [
                            'to_email'       => $user->email,
                            'role'           => Nh_User::ADMIN,
                            'user'           => $user,
                            'opportunity_id' => $data['opportunity_id'],
                        ]);

                    }

                    break;
                case 'investment':
                    $user                                             = Nh_User::get_user_by('ID', $to);
                    $notification_obj->title                          = __("New Investment Request", 'ninja');
                    $notification_obj->content                        = __('You have a new investment request on your project <strong>%s</strong>', 'ninja');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'           => 'investment',
                        'from'           => __('B2B', 'ninja'),
                        'opportunity_id' => $data['opportunity_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();

                    // SEND EMAIL
                    $this->send_email('investment', [
                        'to_email'       => $user->email,
                        'role'           => Nh_User::ADMIN,
                        'user'           => $user,
                        'opportunity_id' => $data['opportunity_id'],
                    ]);


                    $admin_users = Nh_User::get_users_by_role([ Nh_User::ADMIN ]);

                    foreach ($admin_users as $user) {
                        $notification_obj                                 = new $class();
                        $notification_obj->title                          = __("New Investment Request", 'ninja');
                        $notification_obj->content                        = __("New investment request from <strong>%s</strong> on <strong>%s</strong>", 'ninja');
                        $notification_obj->author                         = $user->ID;
                        $notification_obj->meta_data['notification_data'] = [
                            'type'           => 'investment',
                            'from'           => $from,
                            'opportunity_id' => $data['opportunity_id'],
                        ];
                        $notification_obj->meta_data['new']               = 1;
                        $notification_obj->insert();

                        // SEND EMAIL
                        $this->send_email('investment', [
                            'to_email'       => $user->email,
                            'role'           => Nh_User::ADMIN,
                            'user'           => $user,
                            'opportunity_id' => $data['opportunity_id'],
                        ]);
                    }
                    break;
                default:
                    break;
            }
        }

        /**
         * Generates the HTML representation of a notification.
         *
         * @param Nh_Notification $notification The notification object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return \stdClass The formatted notification object.
         * @throws \Exception
         */
        public function notification_html(Nh_Notification $notification): \stdClass
        {
            $type      = $notification->meta_data['notification_data']['type'];
            $formatted = new \stdClass();

            switch ($type) {
                case 'opportunity_new':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);
                    $from = Nh_User::get_user_by('ID', (int)$notification->meta_data['notification_data']['from']);

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }


                    if (Nh_User::get_user_role() === Nh_User::REVIEWER) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title, $from);
                    } elseif (Nh_User::get_user_role() === Nh_User::ADMIN) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = __($notification->content, 'ninja');
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
                    break;

                case 'opportunity_translated':
                case 'opportunity_approve':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }


                    if (Nh_User::get_user_role() === Nh_User::OWNER) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    } elseif (Nh_User::get_user_role() === Nh_User::CMS) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = __($notification->content, 'ninja');
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
                    break;

                case 'opportunity_hold':
                case 'opportunity_cancel':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->title     = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                    $formatted->content   = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];

                    break;

                case 'opportunity_content_verified':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }


                    if (Nh_User::get_user_role() === Nh_User::OWNER) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    } elseif (Nh_User::get_user_role() === Nh_User::SEO) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = __($notification->content, 'ninja');
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
                    break;

                case 'opportunity_seo_verified':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }


                    if (Nh_User::get_user_role() === Nh_User::OWNER) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    } elseif (Nh_User::get_user_role() === Nh_User::TRANSLATOR) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = __($notification->content, 'ninja');
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
                    break;

                case 'opportunity_published':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $opportunity     = $opportunity_obj->get_by_id((int)$opportunity_id);
                    $user_obj = Nh_User::get_user_by('ID', (int)$notification->meta_data['notification_data']['from']);
                    $from = is_wp_error($user_obj) ? 'B2B' : $user_obj->first_name;

                    if (is_wp_error($opportunity)) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }


                    if (Nh_User::get_user_role() === Nh_User::OWNER) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    } elseif (Nh_User::get_user_role() === Nh_User::ADMIN) {
                        $formatted->title   = __($notification->title, 'ninja');
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $from, $opportunity->title  );
                    } elseif (Nh_User::get_user_role() === Nh_User::INVESTOR) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    }

                    $formatted->ID        = $notification->ID;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->thumbnail = Nh_Hooks::PATHS['public']['img'] . "/brand/b2b-capital-dark-logo.webp";
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
                    break;

                case 'bidding':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $from = Nh_User::get_user_by('ID', (int)$notification->meta_data['notification_data']['from']);

                    if (!$opportunity_id) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }

                    $opportunity          = $opportunity_obj->get_by_id($opportunity_id);
                    $formatted->ID        = $notification->ID;
                    $formatted->title     = __($notification->title, 'ninja');
                    $formatted->content   = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    $formatted->thumbnail = $opportunity->thumbnail;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];

                    if (Nh_User::get_user_role() === Nh_User::ADMIN) {
                        $formatted->title   = sprintf(__($notification->title, 'ninja'), $opportunity->title);
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $from, $opportunity->title);
                    }

                    break;
                case 'investment':
                case 'acquisition':
                    $opportunity_obj = new Nh_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['opportunity_id'], $opportunity_obj->type, FALSE, NH_lANG);
                    $from = Nh_User::get_user_by('ID', (int)$notification->meta_data['notification_data']['from']);

                    if (!$opportunity_id) {
                        $notification->delete();
                        $formatted->ID        = 0;
                        $formatted->title     = __('Unavailable', 'ninja');
                        $formatted->content   = __('Content is Unavailable', 'ninja');
                        $formatted->thumbnail = '#';
                        $formatted->url       = 'javascript(0);';
                        $formatted->date      = '';
                        $formatted->new       = 0;
                        break;
                    }

                    $opportunity          = $opportunity_obj->get_by_id($opportunity_id);
                    $formatted->ID        = $notification->ID;
                    $formatted->title     = __($notification->title, 'ninja');
                    $formatted->content   = sprintf(__($notification->content, 'ninja'), $opportunity->title);
                    $formatted->thumbnail = $opportunity->thumbnail;
                    $formatted->url       = apply_filters('nhml_permalink', $opportunity->link);
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];

                    if (Nh_User::get_user_role() === Nh_User::ADMIN) {
                        $formatted->title   = __($notification->title, 'ninja');
                        $formatted->content = sprintf(__($notification->content, 'ninja'), $from, $opportunity->title);
                    }

                    break;
                default:
                    break;
            }

            return $formatted;
        }

        /**
         * Handles the AJAX request to mark notifications as read.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function read_ajax(): void
        {
            $form_data = $_POST['data'];

            if (!empty($form_data)) {
                $IDs = $form_data['IDs'];

                $notifications = $this->get_by_ids($IDs);
                foreach ($notifications as $notification) {
                    $notification->set_meta_data('new', 0);
                    $notification->update();
                }

                new Nh_Ajax_Response(TRUE, __('Notifications status has been changed successfully', 'ninja'), [
                    'count' => $this->get_new_notifications_count()
                ]);
            }
        }

        /**
         * Handles the AJAX request to clear all notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function clear_notifications_ajax(): void
        {
            global $user_ID;

            $posts = new \WP_Query([
                "post_type"      => $this->module,
                "post_status"    => 'any',
                "posts_per_page" => -1,
                'author'         => $user_ID
            ]);

            foreach ($posts->get_posts() as $post) {
                wp_delete_post($post->ID, TRUE);
            }

            ob_start();
            get_template_part('app/Views/template-parts/notifications/notification', 'empty');
            $html = ob_get_clean();

            new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                'html' => $html
            ]);

        }

        /**
         * Handles the AJAX request to load more notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function loadmore_notifications_ajax(): void
        {
            global $user_ID;
            $form_data = $_POST['data'];
            $page      = intval($form_data['page']);

            $notifications = $this->load_more([ 'publish' ], $page, 10, 'DESC', [ $user_ID ]);

            // if ($page * 10 >= $notifications['count']) {
            $last = TRUE;
            // }

            ob_start();
            foreach ($notifications as $key => $notification) {
                if ('count' === $key) {
                    continue;
                }

                get_template_part('app/Views/template-parts/notifications/notification', 'ajax', [ 'data' => $notification ]);

                if ((int)$notification->meta_data['new'] > 0) {
                    $notification->set_meta_data('new', 0);
                    $notification->update();
                }
            }

            $html = ob_get_clean();

            new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                'html'  => $html,
                'page'  => $page + 1,
                'count' => $this->get_new_notifications_count(),
                'last'  => (int)$last
            ]);
        }

        /**
         * Handles the AJAX request to mark new notifications as read.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return void
         */
        public function read_new_notifications_ajax(): void
        {
            $form_data = $_POST['data'];
            $IDs       = $form_data['IDs'];

            $notifications = $this->get_by_ids($IDs);
            foreach ($notifications as $notification) {
                $notification->set_meta_data('new', 0);
                $notification->update();
            }

            new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                'count' => $this->get_new_notifications_count()
            ]);
        }

        /**
         * Converts a datetime string to a human-readable time elapsed string.
         *
         * @param string $datetime The datetime string.
         * @param bool   $full True to show the full time elapsed string, False to show the most significant part only.
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Mustafa Shaaban
         * @return string The time elapsed string.
         * @throws \Exception
         */
        public function time_elapsed_string(string $datetime, $full = FALSE): string
        {
            date_default_timezone_set('Africa/Cairo');
            $now  = new \DateTime;
            $ago  = new \DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = [
                'y' => __('y', 'ninja'),
                'm' => __('m', 'ninja'),


                'w' => __('w', 'ninja'),
                'd' => __('d', 'ninja'),
                'h' => __('h', 'ninja'),
                'i' => __('m', 'ninja'),
                's' => __('s', 'ninja'),
            ];

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . $v;
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full)
                $string = array_slice($string, 0, 1);

            return $string ? implode(', ', $string) . ' ' . __('ago', 'ninja') : __('just now', 'ninja');
        }

        public function item_clear_notifications_ajax(): void
        {
            global $user_ID;
            $form_data                     = $_POST['data'];
            $post_id                       = (int)sanitize_text_field($form_data['post_id']);
            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;

            if (!wp_verify_nonce($form_data['notification_item_clear_nonce'], Nh::_DOMAIN_NAME . "_notification_item_clear_nonce_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_notification_item_clear');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            wp_delete_post($post_id, TRUE);

            $posts = new \WP_Query([
                "post_type"      => $this->module,
                "post_status"    => 'any',
                "posts_per_page" => -1,
                'author'         => $user_ID
            ]);

            ob_start();
            if (!empty($posts->get_posts())) {
                foreach ($posts->get_posts() as $notification) {
                    $data = [];
                    $data['notification'] = $this->convert($notification);
                }
            //         $data['item_clear_form'] = Nh_Forms::get_instance()
            //         ->create_form([
            //             'post_id'                      => [
            //                 'type'   => 'hidden',
            //                 'name'   => 'post_id',
            //                 'before' => '',
            //                 'after'  => '',
            //                 'value'  => $notification->ID,
            //                 'order'  => 0
            //             ],
            //             'notification_item_clear_nonce'               => [
            //                 'class' => '',
            //                 'type'  => 'nonce',
            //                 'name'  => 'notification_item_clear_nonce',
            //                 'value' => Nh::_DOMAIN_NAME . "_notification_item_clear_nonce_form",
            //                 'order' => 5
            //             ],
            //             'submit_notification_item_clear_request' => [
            //                 'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
            //                 'id'                  => 'submit_notification_item_clear_request',
            //                 'type'                => 'submit',
            //                 'value'               => __('Clear', 'ninja'),
            //                 'recaptcha_form_name' => 'frontend_notification_item_clear',
            //                 'order'               => 10
            //             ],
            //         ], [
            //             'class' => Nh::_DOMAIN_NAME . '-notification-item-clear-form',
            //         ]);
            //         get_template_part('app/Views/template-parts/notifications/notification', 'list-ajax', [ 'data' => $data ]);

            //     }
            } else {
                get_template_part('app/Views/template-parts/notifications/notification', 'empty');
            }

            $html = ob_get_clean();

            new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                'html' => $html,
            ]);
        }

        public function send_email(string $type = '', array $data = []): void
        {
            switch ($type) {
                case 'opportunity_new':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('New Opportunity')
                                    ->template('opportunity-new/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_approve':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-approve/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_hold':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-hold/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_cancel':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-cancel/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_content_verified':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-content-verified/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_seo_verified':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-seo-verified/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_translated':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Status')
                                    ->template('opportunity-translated/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'opportunity_published':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject('Opportunity Published')
                                    ->template('opportunity-published/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'bidding':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject(sprintf('New Bidding - %s', $data['opportunity']->title))
                                    ->template('opportunity-bidding/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();

                    break;
                case 'acquisition':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject(sprintf('New Acquisition - %s', $data['opportunity']->title))
                                    ->template('opportunity-acquisition/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                case 'investment':
                    $email = Nh_Mail::init()
                                    ->to($data['to_email'])
                                    ->subject(sprintf('New Investment - %s', $data['opportunity']->title))
                                    ->template('opportunity-investment/body', [
                                        'data' => [
                                            'role'        => $data['role'],
                                            'user'        => $data['user'],
                                            'opportunity' => $data['opportunity']
                                        ]
                                    ])
                                    ->send();
                    break;
                default:
                    break;
            }
        }
    }