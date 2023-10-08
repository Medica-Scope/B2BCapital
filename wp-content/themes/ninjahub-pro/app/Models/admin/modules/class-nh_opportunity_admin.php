<?php
    /**
     * @Filename: class-nh_opportunity_admin.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */

    namespace NH\APP\MODELS\ADMIN\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;


    /**
     * Description...
     *
     * @class Nh_Profile_Admin
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Opportunity_Admin extends Nh_Module
    {
        public array $meta_data = [];

        public function __construct()
        {
            parent::__construct('opportunity');
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
        public function convert(\WP_Post $post, array $meta_data = []): Nh_Post
        {
            return parent::convert($post, $this->meta_data); // TODO: Change the autogenerated stub
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
            $this->hooks->add_filter('acf/location/rule_match/post', $this, 'acf_location_rules', 10, 4);
        }

        public function acf_location_rules($match, $rule, $options, $field_group)
        {

            $post_id = get_the_ID();
            $obj     = $this->get_by_id($post_id);
            if (!empty($obj->taxonomy['opportunity-category'])) {

                $form_template = get_term_meta($obj->taxonomy['opportunity-category'][0]->term_id, 'form_template', TRUE);

                if (!empty($form_template)) {

                    // Your specific field group ID
                    $target_field_group_id = $this->get_field_groups_by_post_id($form_template); // Replace with your field group ID

                    // Array of post IDs where you want to assign the field group
                    $target_post_ids = [ $post_id ]; // Replace with your array of post IDs

                    // Check if we are on the correct field group
                    if (acf_is_screen('opportunity')) {
                        // Check if the current post ID is in the array of target post IDs
                        if (isset($options['post_id']) && in_array($options['post_id'], $target_post_ids) && $field_group['key'] == $target_field_group_id[0]['key']) {
                            $match = TRUE;
                        }
                    }
                }
            }
            return $match;
        }

        private function get_field_groups_by_post_id($post_id): array
        {
            $matched_groups = [];

            // Get all the field groups
            $field_groups = acf_get_field_groups();

            foreach ($field_groups as $field_group) {

                if (isset($field_group['location']) && is_array($field_group['location'])) {

                    foreach ($field_group['location'] as $group_locations) {
                        foreach ($group_locations as $rule) {

                            if (// Check if field group is assigned to the specific post ID
                            ($rule['param'] === 'post' && $rule['operator'] === '==' && intval($rule['value']) === (int)$post_id)) {
                                $matched_groups[] = [
                                    'ID'  => $field_group['ID'],
                                    'key' => $field_group['key']
                                ]; // Store the field group key
                                break 2; // exit both foreach loops if match found
                            }

                        }
                    }
                }
            }

            return $matched_groups;
        }
    }
