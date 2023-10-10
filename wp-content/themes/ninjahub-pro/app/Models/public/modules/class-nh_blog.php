<?php
    /**
     * @Filename: class-nh_blog.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
use NH\APP\HELPERS\Nh_Ajax_Response;
use NH\Nh;
use WP_Post;


    /**
     * Description...
     *
     * @class Nh_Blog
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Blog extends Nh_Module
    {
        public array $meta_data = [
            'cover',
            'opportunity'
        ];
        public array $taxonomy  = [
            'category',
            'post_tag'
        ];

        public function __construct()
        {
            parent::__construct('post');
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
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_toggle_favorite_ajax', $this, 'toggle_post_favorite');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_toggle_favorite_ajax', $this, 'toggle_post_favorite');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_ignore_article_ajax', $this, 'ignore_article');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_ignore_article_ajax', $this, 'ignore_article');
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        /**
         * Description...toggle fav article and save it to user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         */
        public function toggle_post_favorite(): void
        {

            $post_id =intval($_POST['post_id']);
            $user_id = intval($_POST['user_id']);
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            // $favorites = $this->get_user_favorites($user_id);
            $favorites = !empty($profile->meta_data['favorite_articles']) ? $profile->meta_data['favorite_articles'] : array();
            
            if (in_array($post_id, $favorites)) {
                $key = array_search($post_id, $favorites);
                if ($key !== false) {
                    unset($favorites[$key]);
                }
                $profile->set_meta_data('favorite_articles',$favorites);
                $profile->update();
                $fav_count = get_post_meta($post_id, 'fav_count', true);
                update_post_meta($post_id, 'fav_count', (int)$fav_count - 1);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post removed', 'fav_active' => 1]
                );
            } else {
                $favorites[] = $post_id;
                $profile->set_meta_data('favorite_articles',$favorites);
                $profile->update();
                $fav_count = get_post_meta($post_id, 'fav_count', true);
                update_post_meta($post_id, 'fav_count', (int)$fav_count + 1);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post added', 'fav_active' => 0]
                );
            }
        }
        /**
         * Description...get user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return array
         */
        public function get_user_favorites($user_id): array
        {
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $favorites = ($profile->meta_data['favorite_articles']) ? $profile->meta_data['favorite_articles'] : array();

            return $favorites;
        }

        /**
         * Description...Check if post exists in user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_post_in_user_favorites($post_id, $user_id): bool 
        {
            $favorites = $this->get_user_favorites($user_id);
            $favorites = array_combine($favorites, $favorites);
            return isset($favorites[$post_id]);
        }

        /**
         * Description...ignore article and save it to user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function ignore_article(): void 
        {
            $post_id = intval($_POST['post_id']);
            $user_id = intval($_POST['user_id']);
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);              
            $ignored_articles = $this->get_user_ignored_articles($user_id);
            $ignored_articles = array_combine($ignored_articles, $ignored_articles);
            if(isset($ignored_articles[$post_id])){
                unset($ignored_articles[$post_id]);
                $ignored_articles = array_values($ignored_articles);
                $profile->set_meta_data('ignored_articles',$ignored_articles);
                $profile->update();
                $ignore_count = get_post_meta($post_id, 'ignore_count', true);
                update_post_meta($post_id, 'ignore_count', (int)$ignore_count + 1);
                ob_start();
                get_template_part('app/Views/blogs-list');
                $html = ob_get_clean();
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post ignored', 'ignore_active' => 1, 'updated' => $html]
                );
            }
            else {
                $ignored_articles[] = $post_id;
                $profile->set_meta_data('ignored_articles',$ignored_articles);
                $profile->update();
                $ignore_count = get_post_meta($post_id, 'ignore_count', true);
                update_post_meta($post_id, 'ignore_count', (int)$ignore_count - 1);
                ob_start();
                get_template_part('app/Views/blogs-list');
                $html = ob_get_clean();
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'),
                ['status' => true, 'msg' => 'post not found!', 'ignore_active' => 0, 'updated' => $html]
                );
            }
        }

        public function get_user_ignored_articles($user_id): array
        {
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $ignored_articles = ($profile->meta_data['ignored_articles']) ? $profile->meta_data['ignored_articles'] : array();

            return $ignored_articles;
        }

        /**
         * Description...Check if post exists in user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_post_in_user_ignored_articles($post_id, $user_id): bool 
        {
            $ignored_articles = $this->get_user_ignored_articles($user_id);
            $ignored_articles = array_combine($ignored_articles, $ignored_articles);
            return isset($ignored_articles[$post_id]);
        }

        /**
         * Description...increase read count for single viewed post, also set cookie (expires in 30 days) for the viewed posts 
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function increment_read_count($post_id) {

            if (isset($_COOKIE['viewed_posts']) && in_array($post_id, json_decode(stripslashes($_COOKIE['viewed_posts'])), true)) {
                return;
            }
            $current_count = get_post_meta($post_id, 'read_count', true);
            $new_count = empty($current_count) ? 1 : $current_count + 1;
            update_post_meta($post_id, 'read_count', $new_count);

            $viewed_posts = isset($_COOKIE['viewed_posts']) ? json_decode(stripslashes($_COOKIE['viewed_posts']), true) : array();
            $viewed_posts[] = $post_id;
            setcookie('viewed_posts', json_encode($viewed_posts), time() + (30 * DAY_IN_SECONDS), '/');
        }
         /**
         * Description... overriding get_all in nh_post class
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function get_all(array $status = [ 'any' ], int $limit = 10, string $orderby = 'ID', string $order = 'DESC', array $not_in = [ '0' ], int $user_id = 0, int $page = 1): array
        {   
            $args = [
                "post_type"      => $this->module,
                "post_status"    => $status,
                "posts_per_page" => $limit,
                'paged'          => $page,
                "orderby"        => $orderby,
                "post__not_in"        => $not_in,
                "order"          => $order,
            ];
            $posts     = new \WP_Query($args);
            $Nh_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $Nh_Posts['posts'][] = $this->convert($post, $this->meta_data);
            }
            $Nh_Posts['pagination'] = $this->get_pagination($args);
            return $Nh_Posts;
        }

        public function get_pagination(array $args){
            $all_posts = $args;
            $all_posts['posts_per_page'] = -1;
            $all_posts['fields'] = 'ids';
            $all_posts     = new \WP_Query($all_posts);
            $count = $all_posts->found_posts;
            $big = 999999999;
            $pagination = paginate_links(array(
                'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'  => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total'   => ceil($count/$args['posts_per_page']),
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
            ));

            return $pagination;
        }
    }
