<?php
    /**
     * @Filename: class-b2b_profile.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace B2B\APP\MODELS\FRONT\MODULES;

    use B2B\APP\CLASSES\B2b_Module;
    use B2B\APP\CLASSES\B2b_Post;
    use B2B\APP\CLASSES\B2b_User;
    use WP_Post;


    /**
     * Description...
     *
     * @class B2b_Profile
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Profile extends B2b_Module
    {
        public array $meta_data = [
            'widget_list',
            'preferred_opportunities_cat_list',
            'preferred_articles_cat_list',
        ];
        public array $taxonomy = [
            'industry'
        ];

        public function __construct()
        {
            parent::__construct('profile');
        }

        /**
         * Description...
         *
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_Post
         */
        public function convert(WP_Post $post, array $meta_data = []): B2b_Post
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
            $this->hooks->add_filter('show_admin_bar', $this, 'hide_admin_bar');
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return bool
         */
        public function hide_admin_bar(): bool
        {
            global $user_ID;
            if (!is_user_logged_in() || (B2b_User::get_user_role($user_ID) === B2b_User::INVESTOR || B2b_User::get_user_role($user_ID) === B2b_User::OWNER)) {
                return FALSE;
            }
            return TRUE;
        }
    }
