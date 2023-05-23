<?php
    /**
     * @Filename: class-b2b_profile_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    use B2B\APP\CLASSES\B2b_Module;
    use B2B\APP\CLASSES\B2b_Post;


    /**
     * Description...
     *
     * @class B2b_Profile_Admin
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Profile_Admin extends B2b_Module
    {
        public array $meta_data = [
            'application',
            'mobile_number',
            'user_id',
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
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
        }

        public function post_meta_box()
        {

            add_meta_box('profile_post_meta_box', 'Applications Assigned', [
                    $this,
                    'post_meta_box_content'
                ], // Callback function
                'profile', // Post type
                'normal', // Context (e.g., 'normal', 'side', 'advanced')
                'default' // Priority (e.g., 'high', 'core', 'default', 'low')
            );
        }

        public function post_meta_box_content($post)
        {
            if (!empty($post->meta_data['user_id'])) {
                $args = [
                    "post_type"      => 'application',
                    "post_status"    => 'any',
                    'relation'       => 'AND',
                    "fields"         => 'ids',
                    "posts_per_page" => -1,
                    'author'         => $post->meta_data['user_id'],
                ];
            } else {
                return;
            }
            $applications = new WP_Query($args);

            if ($applications->have_posts()) {
                ?>
                <div class="applications-con">
                    <?php
                        foreach ($applications->posts as $single) {
                            ?>
                            <div class="single-application">
                                <h4><a href="<?php echo get_edit_post_link($single); ?>"><?php echo get_the_title($single); ?></a></h4>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <?php
            }


        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            // TODO: Implement actions() method.
            $this->hooks->add_action('add_meta_boxes', $this, 'post_meta_box');
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }
    }