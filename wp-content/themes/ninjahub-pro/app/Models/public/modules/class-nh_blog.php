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
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         */
        public function toggle_post_favorite(): void
        {
            $profile_obj = new Nh_Profile();
            $post_id =intval($_POST['post_id']);
            $user_id = intval($_POST['user_id']);
            
            $favorites = $this->get_user_favorites($user_id);
            
            if (in_array($post_id, $favorites)) {
                $key = array_search($post_id, $favorites);
                if ($key !== false) {
                    unset($favorites[$key]);
                }
                update_user_meta($user_id, 'favorite_articles', $favorites);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post removed', 'fav_active' => 1]
                );
            } else {
                $favorites[] = $post_id;
                update_user_meta($user_id, 'favorite_articles', $favorites);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post added', 'fav_active' => 0]
                );
            }
        }
        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return array
         */
        public function get_user_favorites($user_id): array
        {
            $favorites = get_user_meta($user_id, 'favorite_articles', true);
            // $profile_obj = new Nh_Profile();
            // $profile = $profile_obj->get_by_id($user_id);
            // $favorites = $profile->meta_data['preferred_articles_cat_list'];
             // to check with sasaaaaa, edit profile fn not working

            return is_array($favorites) ? $favorites : array();
        }

        /**
         * Description...
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
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function ignore_article(): void 
        {
            $profile_obj = new Nh_Profile();
            $post_id = intval($_POST['post_id']);
            $user_id = intval($_POST['user_id']);
            $profile = $profile_obj->get_by_id($user_id);
            $ignored_articles = get_user_meta($profile->ID, 'ignored_articles', true);
            // var_dump($profile->meta_data['ignored_articles']); // to check with sasaaaaa, edit profile fn not working
            
            $ignored_articles = $this->get_user_ignored_articles($user_id);
            $ignored_articles = array_combine($ignored_articles, $ignored_articles);
            if(isset($ignored_articles[$post_id])){
                unset($ignored_articles[$post_id]);
                $ignored_articles = array_values($ignored_articles);
                update_user_meta($user_id, 'ignored_articles', $ignored_articles);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), 
                ['status' => true, 'msg' => 'post ignored', 'ignore_active' => 1]
                );
            }
            else {
                $ignored_articles[] = $post_id;
                update_user_meta($user_id, 'ignored_articles', $ignored_articles);
                new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'),
                ['status' => true, 'msg' => 'post not found!', 'ignore_active' => 0]
                );
            }
        }

        public function get_user_ignored_articles($user_id): array
        {
            $ignored_articles = get_user_meta($user_id, 'ignored_articles', true);
            // $profile_obj = new Nh_Profile();
            // $profile = $profile_obj->get_by_id($user_id);
            // $ignored_articles = $profile->meta_data['ignored_articles'];
             // to check with sasaaaaa, edit profile fn not working

            return is_array($ignored_articles) ? $ignored_articles : array();
        }

        /**
         * Description...
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
    }
