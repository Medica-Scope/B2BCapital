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
        public function get_all(array $status = [ 'any' ], int $limit = 10, string $order = 'DESC'): array
        {
            $posts     = new \WP_Query([
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                "orderby"        => 'ID',
                "order"          => $order,
            ]);
            $B2b_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $B2b_Posts[] = $this->convert($post, $this->meta_data);
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
         * @return \B2B\APP\CLASSES\B2b_Post
         */
        public function get_by_id(int $post_id = 0): B2b_Post
        {
            $posts = new \WP_Query([
                "p"           => $post_id,
                "post_type"   => $this->module,
                "post_status" => 'any',
            ]);

            $B2b_Posts = new B2b_Post();

            if ($posts->have_posts()) {
                $B2b_Posts = $this->convert($posts->post, $this->meta_data);
            }

            return $B2b_Posts;
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
            $posts     = new \WP_Query([
                "post__in"    => $post_ids,
                "post_type"   => $this->module,
                "post_status" => $status,
            ]);
            $B2b_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $B2b_Posts[] = $this->convert($post, $this->meta_data);
            }

            return $B2b_Posts;
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
            $posts     = new \WP_Query([
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

    }
