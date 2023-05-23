<?php
    /**
     * @Filename: class-b2b_init.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */

    namespace B2B\APP\CLASSES;

    use Exception;
    use stdClass;

    /**
     * Description...
     *
     * @class B2b_Init
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Init
    {
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
            $this->class_name = [
                'core'   => [
                    'Hooks'         => [
                        'type'      => 'helper',
                        'namespace' => 'B2B\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-b2b_hooks.php'
                    ],
                    'Forms'         => [
                        'type'      => 'helper',
                        'namespace' => 'B2B\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-b2b_forms.php'
                    ],
                    'Ajax_Response' => [
                        'type'      => 'helper',
                        'namespace' => 'B2B\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-b2b_ajax_response.php'
                    ],
                    'Mail'          => [
                        'type'      => 'helper',
                        'namespace' => 'B2B\APP\HELPERS',
                        'path'      => THEME_PATH . '/app/helpers/class-b2b_mail.php'
                    ],
                    'Post'          => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-b2b_post.php'
                    ],
                    'User'          => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-b2b_user.php'
                    ],
                    'Module'        => [
                        'type'      => 'abstract',
                        'namespace' => 'B2B\APP\CLASSES',
                        'path'      => THEME_PATH . '/app/Classes/class-b2b_module.php'
                    ]
                ],
                'admin'  => [],
                'public' => [
                    'Auth'    => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-b2b_auth.php'
                    ],
                    'Blog'    => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-b2b_blog.php'
                    ],
                    'Faq' => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-b2b_faq.php'
                    ],
                    'Opportunity' => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-b2b_opportunity.php'
                    ],
                    'Profile' => [
                        'type'      => 'class',
                        'namespace' => 'B2B\APP\MODELS\FRONT\MODULES',
                        'path'      => THEME_PATH . '/app/Models/public/modules/class-b2b_profile.php'
                    ],
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

                    $class_name = $value['namespace'] . "\B2b_" . $class;
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
