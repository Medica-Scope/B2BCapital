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
            'application',
            'mobile_number'
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
        }

        //        public function get_profile_by() {
        //
        //        }
        //
        //
        //        public function get_user_profile($userID = 0): B2b_Post
        //        {
        //
        //            $user_obj = new B2b_User();
        //
        //            if (!$userID) {
        //                global $current_user_id;
        //                $userID = $current_user_id;
        //            }
        ////                $user = $user_obj::get_user_by('ID', $userID);
        //
        //            $wp_profile = new \WP_Query([
        //                'post_type'      => $this->type,
        //                'post_status'    => $this->status,
        //                'author'         => $userID,
        //                'posts_per_page' => 1
        //            ]);
        //
        //            $class   = __CLASS__;
        //            $profile = new $class();
        //
        //            $profile = $this->convert($wp_profile->post, $this->meta_data);
        //
        //            $wp_applications = new \WP_Query([
        //                'post_type'      => 'application',
        //                'post_status'    => [
        //                    'shortlisted',
        //                    'rejected',
        //                    'accepted',
        //                    'pending'
        //                ],
        //                'author'         => $userID,
        //                'posts_per_page' => -1
        //            ]);
        //
        //            $profile->applications = $wp_applications->posts;
        //            $profile->user         = $user;
        //
        //            return $profile;
        //        }
    }
