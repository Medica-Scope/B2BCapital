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
            'short_description',
        ];
        public array $taxonomy  = [
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
            $service                  = parent::convert($post, $this->meta_data);
            $service->available_slots = $this->get_available_slots($service);

            return $service;
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

        /**
         * Description...
         *
         * @param \WP_Term $term
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function get_category_services(\WP_Term $term): array
        {
            $services = new \WP_Query([
                "post_type"   => $this->module,
                "post_status" => 'publish',
                'tax_query'   => [
                    [
                        'taxonomy' => $term->taxonomy,
                        'field'    => 'id',
                        'terms'    => $term->term_id
                    ]
                ]
            ]);

            $Nh_services = [];

            foreach ($services->get_posts() as $service) {
                $Nh_services[] = $this->convert($service, $this->meta_data);
            }

            return $Nh_services;
        }

        public function get_available_slots($service): array
        {
            $working_days = get_field('working_days', $service->ID);
            $excluded     = [];
            $included     = [];

            foreach ($working_days as $day) {
                if (!$day['active']) {
                    $excluded[] = $day['day_name'];
                } else {
                    $included[] = $day['day_name'];
                }
            }

            $slots           = $this->getNextDaysExcluding($excluded, $included);
            $available_slots = [];

            foreach ($working_days as $key => $day) {
                $working_days[$key]['time_slots'] = [];
                $time_starts_from                 = strtotime($day['time_starts_from']);
                $time_ends_at                     = strtotime($day['time_ends_at']);

                $min     = min($time_starts_from, $time_ends_at);
                $max     = max($time_starts_from, $time_ends_at);
                $current = $min;

                $time_increases_by = (int)$day['time_increases_by'];

                while ($max > $current) {
                    $current = $current + (60 * $time_increases_by);
                    if ($current > $min) {
                        $working_days[$key]['time_slots'][] = date('g:i a', $current);;
                    }
                }
            }

            foreach ($slots as $key_slot => $slot) {
                foreach ($working_days as $key => $day) {
                    if ($day['day_name'] === $slot['day_name']) {

                        if ($key_slot === 0 ? __('Today', 'ninja') : $slot['day_name']) {
                            $full_data_format = __('Today', 'ninja');
                        } else {
                            $full_data_format = $slot['day_name_short'] . ' ' . $slot['date'];
                        }
                        $available_slots[] = [
                            'day_name'         => $key_slot === 0 ? __('Today', 'ninja') : $slot['day_name'],
                            'day_name_short'   => $slot['day_name_short'],
                            'date'             => $slot['date'],
                            'full_data_format' => $full_data_format,
                            'slots'            => $day['time_slots']
                        ];
                        break;
                    }
                }
            }

            return $available_slots;
        }

        public function getNextDaysExcluding($excludeDays = [], $included_days = [])
        {
            $days        = [];
            $currentDate = new \DateTime();

            while (count($days) < 30) {
                // Check if the current day is not in the excluded days array
                if (!in_array($currentDate->format('l'), $excludeDays) && in_array($currentDate->format('l'), $included_days)) {
                    $days[] = [ 'date'           => $currentDate->format('d/m'),
                                'day_name'       => $currentDate->format('l'),
                                'day_name_short' => $currentDate->format('D')
                    ];
                }

                // Move to the next day
                $currentDate->modify('+1 day');
            }

            return $days;
        }
    }
