<?php
    /**
     * @Filename: class-nh_opportunity.php
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
     * @class Nh_Opportunity
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Opportunity extends Nh_Module
    {
        public array $meta_data = [
            'cover',
            'short_description',
            'opportunity_type',
            'start_bidding_amount',
            'target_amount',
            'project_phase',
            'project_start_date',
            'project_assets_amount',
            'project_yearly_cashflow_amount',
            'project_yearly_net_profit_amount'
        ];
        public array $taxonomy  = [
            'opportunity-category',
            'opportunity-type',
            'industry'
        ];

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
        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        public static function get_field_groups_by_post_id($post_id): array
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
