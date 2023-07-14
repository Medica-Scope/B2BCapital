<?php
    /**
     * @Filename: class-b2b_notification.php
     * @Description: This file contains the implementation of the B2b_Notification class,
     * which is a module for handling notifications in the B2B application.
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */

    namespace B2B\APP\MODELS\FRONT\MODULES;

    use B2B\APP\CLASSES\B2b_Module;
    use B2B\APP\CLASSES\B2b_Post;
    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\HELPERS\B2b_Ajax_Response;
    use B2B\B2b;

    /**
     * Class B2b_Notification
     * Handles notifications in the B2B application.
     *
     * @package B2B\APP\MODELS\FRONT\MODULES
     * @version 1.0
     * @since 1.0.0
     */
    class B2b_Notification extends B2b_Module
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
         * B2b_Notification constructor.
         * Initializes the B2b_Notification object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        public function __construct()
        {
            parent::__construct('notification');
        }

        /**
         * Converts a \WP_Post object into a B2b_Post object.
         *
         * @param \WP_Post $post The \WP_Post object to convert.
         * @param array    $meta_data An array of meta data keys associated with notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return B2b_Post The converted B2b_Post object.
         */
        public function convert(\WP_Post $post, array $meta_data = []): B2b_Post
        {
            return parent::convert($post, $this->meta_data);
        }

        /**
         * Performs actions specific to the B2b_Notification module.
         *
         * @param string $module_name The name of the module.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_read_notifications_ajax', $this, 'read_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_read_notifications_ajax', $this, 'read_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_clear_notifications_ajax', $this, 'clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_clear_notifications_ajax', $this, 'clear_notifications_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_loadmore_notifications_ajax', $this, 'loadmore_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_loadmore_notifications_ajax', $this, 'loadmore_notifications_ajax');
            $this->hooks->add_action('wp_ajax_' . B2b::_DOMAIN_NAME . '_read_new_notifications_ajax', $this, 'read_new_notifications_ajax');
            $this->hooks->add_action('wp_ajax_nopriv_' . B2b::_DOMAIN_NAME . '_read_new_notifications_ajax', $this, 'read_new_notifications_ajax');
        }

        /**
         * Performs filters specific to the B2b_Notification module.
         *
         * @param string $module_name The name of the module.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
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
         * @package b2b
         * @author Mustafa Shaaban
         * @throws \Exception
         */
        public function get_notifications(): array
        {
            global $wpdb, $user_ID;

            $all      = $this->get_all_custom([ 'publish' ]);
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
         * @package b2b
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
         * @package b2b
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

            $B2b_Posts = [ 'posts' => [] ];

            foreach ($posts->get_posts() as $post) {
                $class

                                      = __CLASS__;
                $b2b_module           = new $class;
                $B2b_Posts['posts'][] = $b2b_module->assign($this->convert($post, $this->meta_data));
            }

            $B2b_Posts['found_posts'] = $posts->found_posts;

            return $B2b_Posts;
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
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function send(int $from = 0, int $to = 0, string $type = '', array $data = []): void
        {
            $class            = __CLASS__;
            $notification_obj = new $class();
            switch ($type) {
                case 'bidding':
                    $user                                             = B2b_User::get_user_by('ID', $from);
                    $notification_obj->title                          = __("New Bidding", 'b2b');
                    $notification_obj->content                        = __('You have a new bidding from <strong>%s</strong> on your project <strong>%s</strong>', 'b2b');
                    $notification_obj->author                         = $to;
                    $notification_obj->meta_data['notification_data'] = [
                        'type'       => 'bidding',
                        'from'       => $user->display_name,
                        'project_id' => $data['project_id'],
                    ];
                    $notification_obj->meta_data['new']               = 1;
                    $notification_obj->insert();
                    break;
                default:
                    break;
            }
        }

        /**
         * Generates the HTML representation of a notification.
         *
         * @param B2b_Notification $notification The notification object.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \stdClass The formatted notification object.
         * @throws \Exception
         */
        public function notification_html(B2b_Notification $notification): \stdClass
        {
            $type      = $notification->meta_data['notification_data']['type'];
            $formatted = new \stdClass();

            switch ($type) {
                case 'bidding':
                    $opportunity_obj = new B2b_Opportunity();
                    $opportunity_id  = wpml_object_id_filter($notification->meta_data['notification_data']['project_id'], $opportunity_obj->type, FALSE, B2B_lANG);
                    $opportunity     = $opportunity_obj->get_by_id($opportunity_id);

                    $formatted->ID        = $notification->ID;
                    $formatted->title     = __($notification->title, 'b2b');
                    $formatted->content   = sprintf(__($notification->content, 'b2b'), $notification->meta_data['notification_data']['from'], $opportunity->title);
                    $formatted->thumbnail = $opportunity->thumbnail;
                    $formatted->url       = apply_filters('b2bml_permalink', $opportunity->link);
                    $formatted->date      = $this->time_elapsed_string($notification->created_date);
                    $formatted->new       = (int)$notification->meta_data['new'];
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
         * @package b2b
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

                new B2b_Ajax_Response(TRUE, __('Notifications status has been changed successfully', 'b2b'), [
                    'count' => $this->get_new_notifications_count()
                ]);
            }
        }

        /**
         * Handles the AJAX request to clear all notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
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

            new B2b_Ajax_Response(TRUE, __('Successful Response!', 'b2b'), [
                'html' => $html
            ]);

        }

        /**
         * Handles the AJAX request to load more notifications.
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function loadmore_notifications_ajax(): void
        {
            global $user_ID;
            $form_data = $_POST['data'];
            $page      = intval($form_data['page']);

            $notifications = $this->load_more([ 'publish' ], $page, 10, 'DESC', [ $user_ID ]);

            $last = FALSE;

            if ($page * 10 >= $notifications['count']) {
                $last = TRUE;
            }

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

            new B2b_Ajax_Response(TRUE, __('Successful Response!', 'b2b'), [
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
         * @package b2b
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

            new B2b_Ajax_Response(TRUE, __('Successful Response!', 'b2b'), [
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
         * @package b2b
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
                'y' => __('y', 'b2b'),
                'm' => __('m', 'b2b'),


                'w' => __('w', 'b2b'),
                'd' => __('d', 'b2b'),
                'h' => __('h', 'b2b'),
                'i' => __('m', 'b2b'),
                's' => __('s', 'b2b'),
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

            return $string ? implode(', ', $string) . ' ' . __('ago', 'b2b') : __('just now', 'b2b');
        }
    }