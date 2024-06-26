<?php
    /**
     * @Filename: class-nh_init.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */

    namespace NH\APP\CLASSES;

    use Exception;
    use stdClass;

    /**
     * Description...
     *
     * @class Nh_Init
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Init
    {
        /**
         * @var string
         */
        public static string $_NH_lANG;
        /**
         * @var string
         */
        public static string $_THEME_PATH;
        /**
         * @var string
         */
        public static string $_THEME_URI;
        /**
         * @var array|false|mixed
         */
        public static array $_NH_CONFIGURATION;
        /**
         * @var array
         */
        public static array $obj = [];
        /**
         * @var null
         */
        private static $instance = NULL;
        /**
         * @var \string[][][]
         */
        private array $class_name = [];

        public function __construct()
        {

            self::$_NH_lANG          = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en';
            self::$_THEME_PATH       = get_template_directory();
            self::$_THEME_URI        = get_stylesheet_directory_uri();
            self::$_NH_CONFIGURATION = get_option('nh_configurations') ?: [];

            $this->class_name = [
                'core'   => [
                    'Hooks'               => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_hooks.php'
                    ],
                    'Forms'               => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_forms.php'
                    ],
                    'Ajax_Response'       => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_ajax_response.php'
                    ],
                    'Mail'                => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_mail.php'
                    ],
                    'Cryptor'             => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_cryptor.php'
                    ],
                    'Bootstrap_Navwalker' => [
                        'type'      => 'helper',
                        'namespace' => 'NH\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-nh_bootstrap_navwalker.php'
                    ],
                    'Cron'                => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-nh_cron.php'
                    ],
                    'Post'                => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-nh_post.php'
                    ],
                    'Module'              => [
                        'type'      => 'abstract',
                        'namespace' => 'NH\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-nh_module.php'
                    ],
                    'User'                => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-nh_user.php'
                    ],

                ],
                'admin'  => [
                    'Opportunity' => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\ADMIN\MODULES',
                        'path'      => THEME_PATH . '/app/Models/admin/modules/class-nh_opportunity_admin.php'
                    ],
                ],
                'public' => [
                    'Appointment'             => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_appointment.php'
                    ],
                    'Auth'                    => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_auth.php'
                    ],
                    'Blog'                    => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_blog.php'
                    ],
                    'Faq'                     => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_faq.php'
                    ],
                    'Notification'            => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_notification.php'
                    ],
                    'Opportunity'             => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_opportunity.php'
                    ],
                    'Opportunity_Acquisition' => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_opportunity_acquisition.php'
                    ],
                    'Opportunity_Bid'         => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_opportunity_bid.php'
                    ],
                    'Opportunity_Investments' => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_opportunity_investments.php'
                    ],
                    'Profile'                 => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_profile.php'
                    ],
                    'Search'                  => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_search.php'
                    ],
                    'Profile_Widget'          => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_profile_widget.php'
                    ],
                    'Service'                 => [
                        'type'      => 'class',
                        'namespace' => 'NH\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-nh_service.php'
                    ]
                ],
            ];
        }

        /**
         * @return mixed|null
         */
        public static function get_instance()
        {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * @param $type
         * @param $class
         *
         * @return mixed|\stdClass
         */
        public static function get_obj($type, $class)
        {
            return array_key_exists($class, self::$obj[$type]) ? self::$obj[$type][$class] : new stdClass();
        }

        /**
         * @param $type
         *
         * @throws \Exception
         */
        public function run($type): void
        {
            foreach ($this->class_name[$type] as $class => $value) {
                try {
                    if (!file_exists($value['path'])) {
                        throw new Exception("Your class path is invalid.");
                    }

                    require_once $value['path'];

                    if ('abstract' === $value['type'] || 'helper' === $value['type'] || 'widget' === $value['type']) {
                        continue;
                    }

                    $class_name = $value['namespace'] . "\Nh_" . $class;
                    $class_name .= $type === 'admin' ? "_Admin" : "";

                    if (!class_exists("$class_name")) {
                        throw new Exception("Your class is not exists.");
                    }

                    self::$obj[$class] = new $class_name();

                } catch (Exception $e) {
                    echo "<code>" . $e->getMessage() . "</code>";
                }
            }
        }
    }
