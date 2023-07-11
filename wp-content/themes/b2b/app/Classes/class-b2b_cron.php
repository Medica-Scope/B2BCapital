<?php
    /**
     * Filename: class-b2b_cron.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 29/6/2023
     */

    namespace B2B\APP\CLASSES;

    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Notification;
    use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Cron
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author  - Mustafa Shaaban
     */
    class B2b_Cron
    {
        private B2b_Hooks $hooks;

        public function __construct()
        {
            $this->hooks = new B2b_Hooks();
            $this->hooks->add_filter('cron_schedules', $this, 'b2b_schedules');
            $this->hooks->add_action(B2b::_DOMAIN_NAME . '_check_notifications', $this, 'check_notifications');
            $this->hooks->add_action('init', $this, 'init_schedules');
            $this->hooks->run();
        }

        public function b2b_schedules($schedules)
        {
            $schedules['daily'] = [
                'interval' => 86400,
                'display'  => esc_html__('B2B Check Every 24 hours'),
            ];
            return $schedules;
        }


        /**
         * Check user notifications and automatically remove the exceeded limit notifications
         * @throws \Exception
         */
        public function check_notifications()
        {
            $notifications_obj = new B2b_Notification();
            $notifications = $notifications_obj->get_all(['publish'], -1);
        }

        public function init_schedules(): void
        {
            if (!wp_next_scheduled(B2b::_DOMAIN_NAME . '_check_notifications')) {
                wp_schedule_event(time(), 'daily', B2b::_DOMAIN_NAME . '_check_notifications'); //1644876600
            }
        }

    }
