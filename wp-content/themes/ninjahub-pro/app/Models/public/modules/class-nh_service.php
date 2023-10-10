<?php
    /**
     * @Filename: class-nh_service.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Service
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Service extends Nh_Module
    {
        public array $meta_data = [
            'service_price',
            'features',
            'service_icon',
            'working_days',
        ];
        public array $taxonomy = [
            'service-category'
        ];

        public function __construct()
        {
            parent::__construct('service');
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
        public function convert(WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data);
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }
    }
