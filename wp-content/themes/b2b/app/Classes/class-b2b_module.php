<?php
    /**
     * @Filename: class-b2b_Module.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */

    namespace B2B\APP\CLASSES;

    use B2B\APP\HELPERS\B2b_Ajax_Response;
    use B2B\APP\HELPERS\B2b_Hooks;

    /**
     * Description...
     *
     * @class abstract B2b_Module
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    abstract class B2b_Module extends B2b_Post
    {
        /**
         * @var \B2B\APP\CLASSES\B2b_Module|null
         */
        private static ?B2b_Module $instance = NULL;

        /**
         * @var \B2B\APP\HELPERS\B2b_Hooks
         */
        protected B2b_Hooks $hooks;

        /**
         * @var string
         */
        protected string $module = '';

        /**
         * @param $module_name
         */
        public function __construct($module_name)
        {
            parent::__construct();

            $this->module = $this->type = $module_name;
            $this->hooks  = new B2b_Hooks;

            $this->actions($module_name);
            $this->filters($module_name);

            $this->hooks->run();
        }

        public static function get_instance() {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * Description...
         *
         * @param $module_name
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        abstract protected function actions($module_name): void;

        /**
         * Description...
         *
         * @param $module_name
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        abstract protected function filters($module_name): void;

        /**
         * Description...
         *
         * @param array  $status
         * @param int    $limit
         * @param string $order
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function get_all(array $status = [ 'any' ], int $limit = 10, string $orderby = 'ID', string $order = 'DESC', array $not_in = [ '0' ]): array
        {
            $posts     = new \WP_Query([
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                "orderby"        => $orderby,
                "not__in"        => $not_in,
                "order"          => $order,
            ]);
            $B2b_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $B2b_Posts[] =  $this->convert($post, $this->meta_data);
            }

            return $B2b_Posts;
        }

        /**
         * Description...
         *
         * @param int $post_id
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_Post|\WP_Error
         */
        public function get_by_id(int $post_id = 0): B2b_Post|\WP_Error
        {
            $error = new \WP_Error();

            if ($post_id <= 0) {
                $error->add('invalid_id', __("No invalid post id", 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'post_id' => $post_id ]
                ]);
                return $error;
            }

            $posts = new \WP_Query([
                "p"           => $post_id,
                "post_type"   => $this->module,
                "post_status" => 'any',
            ]);

            $posts = get_post($post_id);

            if ($posts) {
                $B2b_Posts = $this->convert($posts, $this->meta_data);
            } else {
                $error->add('invalid_id', __("No posts available.", 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'post_id' => $post_id ]
                ]);
                return $error;
            }

            return $this->assign($B2b_Posts);
        }

        /**
         * Description...
         *
         * @param array $post_ids
         * @param array $status
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function get_by_ids(array $post_ids = [], array $status = [ 'publish' ]): array
        {
            $B2b_Posts = [];

            if (empty($post_ids)) {
                return $B2b_Posts;
            }

            $posts = new \WP_Query([
                "post__in"    => $post_ids,
                "post_type"   => $this->module,
                "post_status" => $status,
            ]);

            foreach ($posts->get_posts() as $post) {
                $B2b_Posts[] = $this->convert($post, $this->meta_data);
            }

            return $B2b_Posts;
        }

        /**
         * Description...
         *
         * @param $tax_name
         *
         * @return int|string|\WP_Error|\WP_Term
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        public function get_taxonomy_terms($tax_name):int|string|array|\WP_Error|\WP_Term
        {
            return get_terms([
                'taxonomy'   => $tax_name,
                'hide_empty' => FALSE, // TODO:: Switch to TRUE on production
            ]);
        }

        public function assign(B2b_Post $obj): B2b_Module
        {
            $this->ID            = $obj->ID;
            $this->author        = $obj->author;
            $this->type          = $obj->type;
            $this->name          = $obj->name;
            $this->title         = $obj->title;
            $this->content       = $obj->content;
            $this->excerpt       = $obj->excerpt;
            $this->status        = $obj->status;
            $this->parent        = $obj->parent;
            $this->created_date  = $obj->created_date;
            $this->modified_date = $obj->modified_date;
            $this->thumbnail     = $obj->thumbnail;
            $this->link          = $obj->link;
            $this->taxonomy      = $obj->taxonomy;

            foreach ($obj->meta_data as $name => $value) {
                $this->set_meta_data($name, $value);
            }

            return $this;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function loadmore_ajax(): void
        {

            $page = intval($_POST['data']);

            $articles = $this->load_more([ 'publish' ], $page);
            $last     = FALSE;

            if ($page * 10 >= $articles['count']) {
                $last = TRUE;
            }

            ob_start();
            foreach ($articles as $key => $article) {
                if ('count' === $key) {
                    continue;
                }
                get_template_part('template-parts/post-ajax/archive', 'loadmore', [ 'data' => $article ]);
            }
            $html = ob_get_clean();

            new B2b_Ajax_Response(TRUE, __('Successful Response!', 'b2b'), [
                'html' => $html,
                'last' => $last
            ]);
        }

        /**
         * Description...
         *
         * @param array  $status
         * @param int    $page
         * @param int    $limit
         * @param string $order
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function load_more(array $status = [ 'any' ], int $page = 1, int $limit = 10, string $order = 'DESC'): array
        {
            $posts     = new WP_Query([
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                "orderby"        => 'ID',
                "order"          => $order,
                "paged"          => $page,
            ]);
            $B2b_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $B2b_Posts[] = $this->convert($post, $this->meta_data);
            }

            $B2b_Posts['count'] = $posts->found_posts;

            return $B2b_Posts;
        }

    }
