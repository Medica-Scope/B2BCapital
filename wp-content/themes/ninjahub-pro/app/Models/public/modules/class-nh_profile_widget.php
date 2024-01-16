<?php
    /**
     * @Filename: class-nh_profile_widget.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 5/10/2023
     */


    namespace NH\APP\MODELS\FRONT\MODULES;

    use NH\APP\CLASSES\Nh_Module;
    use NH\APP\CLASSES\Nh_Post;
    use NH\APP\HELPERS\Nh_Ajax_Response;
    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\Nh;
    use WP_Post;


    /**
     * Description...
     *
     * @class nh_Profile_Widget
     * @version 1.0
     * @since 1.0.0
     * @package NinjaHub
     * @author Mustafa Shaaban
     */
    class Nh_Profile_Widget extends Nh_Module
    {
        public array $meta_data = [
            'widget_active',
            'widget_type',
            'api_auth_type',
            'api_token',
            'api_key',
            'api_secret',
            'api_endpoint',
            'api_method',
            'api_data',
            'api_return_keys'
        ];
        public array $taxonomy  = [];

        public function __construct()
        {
            parent::__construct('profile-widget');
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
            return parent::convert($post, $this->meta_data);
        }

        /**
         * @inheritDoc
         */
        protected function actions($module_name): void
        {
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_get_forex_data_ajax', $this, 'get_fast_forex_ajax');

        }

        /**
         * @inheritDoc
         */
        protected function filters($module_name): void
        {
            // TODO: Implement filters() method.
        }

        /**
         * @throws \Exception
         */
        public function get_fast_forex_ajax()
        {
            $form_data           = $_POST['data'];
            $widget_id           = sanitize_text_field($form_data['id']);
            $widget_id_decrypted = Nh_Cryptor::Decrypt($widget_id);

            if (empty($widget_id)) {
                new Nh_Ajax_Response(FALSE, __('Empty ID', 'ninja'));
            }

            $widgets_obj = new Nh_Profile_Widget();
            $nh_widget   = $widgets_obj->get_by_id((int)$widget_id_decrypted);

            if (is_wp_error($nh_widget)) {
                new Nh_Ajax_Response(FALSE, __($nh_widget->get_error_message(), 'ninja'));
            }

            $forex = empty(get_option('nh_forex_data')) ? [] : get_option('nh_forex_data');

            if (empty($forex) || !is_array($forex) || !isset($forex['canvas-' . $nh_widget->ID]['data'])) {

                $ajax_data = $this->get_forex_response($nh_widget);

                new Nh_Ajax_Response(TRUE, __('Success', 'ninja'), $ajax_data);
            }

            if (!empty($forex) && !empty($forex['canvas-' . $nh_widget->ID]['date'])) {

                $date = $forex['canvas-' . $nh_widget->ID]['date'];
                // The specific datetime to compare with
                $specificDateTime = new \DateTime($date);

                // Add 24 hours to this specific datetime
                $specificDateTime->add(new \DateInterval('P1D'));

                // Get the current datetime
                $currentDateTime = new \DateTime();

                // Compare
                if ($currentDateTime > $specificDateTime) {

                    $ajax_data = $this->get_forex_response($nh_widget);

                    new Nh_Ajax_Response(TRUE, __('Success', 'ninja'), $ajax_data);

                } else {
                    $currency = require_once THEME_PATH . "/inc/currencies.php";
                    $forex_data = $forex['canvas-' . $nh_widget->ID]['data'];
                    $data       = [
                        'labels' => $forex_data['labels'],
                        'values' => $forex_data['values'],
                        'from'   => sprintf(__('1 %s equals', 'ninja'), $currency[$forex_data['from']]),
                        'to'     => sprintf(__('%s %s', 'ninja'), floor((float)$forex_data['to']['value'] * 100) / 100, $currency[$forex_data['to']['currency']])
                    ];
                    new Nh_Ajax_Response(TRUE, __('Success', 'ninja'), [
                        'id'   => $widget_id,
                        'data' => $data
                    ]);
                }
            }

        }

        private function get_forex_response($nh_widget): array
        {
            $forex    = empty(get_option('nh_forex_data')) ? [] : get_option('nh_forex_data');
            $currency = require_once THEME_PATH . "/inc/currencies.php";

            if (str_contains($nh_widget->meta_data['api_data'], 'NOW')) {
                $nh_widget->meta_data['api_data'] = str_replace('NOW', date('Y-m-d'), $nh_widget->meta_data['api_data']);
            }

            parse_str($nh_widget->meta_data['api_data'], $api_data);

            $history_response = $this->makeCurlRequest($nh_widget->meta_data['api_endpoint'], $nh_widget->meta_data['api_method'], $api_data);
            $current_response = $this->makeCurlRequest("https://api.fastforex.io/fetch-one?from=" . $api_data['from'] . "&to=" . $api_data['to'] . "&api_key=" . $api_data['api_key'], $nh_widget->meta_data['api_method'], $api_data);

            if (is_wp_error($history_response)) {
                new Nh_Ajax_Response(FALSE, __($history_response->get_error_message(), 'ninja'));
            }

            if (isset($history_response['error'])) {
                new Nh_Ajax_Response(FALSE, __($history_response['error'], 'ninja'));
            }

            if (is_wp_error($current_response)) {
                new Nh_Ajax_Response(FALSE, __($current_response->get_error_message(), 'ninja'));
            }

            if (isset($current_response['error'])) {
                new Nh_Ajax_Response(FALSE, __($current_response['error'], 'ninja'));
            }

            $keys = get_field('api_return_keys', $nh_widget->ID);
            $data = [];

            foreach ($keys as $key) {
                $data = $this->getValueFromNestedArray($history_response, $key['key_name']);
            }

            if (empty($data)) {
                new Nh_Ajax_Response(FALSE, __('Key is not fount', 'ninja'));
            }

            $labels = [];
            $values = [];
            foreach ($data as $key => $value) {
                $labels[] = date('j M Y', strtotime($key));
                $values[] = $value;
            }


            $forex['canvas-' . $nh_widget->ID] = [
                'date' => date('Y-m-d H:i'),
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'from'   => $api_data['from'],
                    'to'     => [
                        'currency' => $api_data['to'],
                        'value'    => $current_response['result'][$api_data['to']]
                    ],
                ]
            ];

            // TODO:: get back to add to current option..
            update_option('nh_forex_data', $forex);


            $labels = [];
            $values = [];
            foreach ($data as $key => $value) {
                $labels[] = date_i18n('j M Y', strtotime($key));
                $values[] = $value;
            }

            return [
                'id'   => Nh_Cryptor::Encrypt($nh_widget->ID),
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'from'   => sprintf(__('1 %s equals', 'ninja'), $currency[$api_data['from']]),
                    'to'     => sprintf(__('%s %s', 'ninja'), floor((float)$current_response['result'][$api_data['to']] * 100) / 100, $currency[$api_data['to']]),
                ]
            ];
        }

        public function generate_calender(): bool|string
        {
            $year  = date('Y'); // Current Year
            $month = date('m'); // Current Month

            $days_in_month      = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
            $start_day_of_week  = date('w', $first_day_of_month);

            // Adjust for Saturday as the first day of the week
            $start_day_of_week = ((int)$start_day_of_week + 1) % 7;

            // Get the number of days in the previous month
            $last_month = $month - 1;
            $last_year  = $year;
            if ($last_month == 0) {
                $last_month = 12;
                $last_year  = $year - 1;
            }
            $days_in_last_month = cal_days_in_month(CAL_GREGORIAN, $last_month, $last_year);

            ob_start();

            ?>
            <div class="calendar">
                <p class="day-week"><?= date('l') ?></p>
                <p class="month-year pb-2"><?= date('j F Y', $first_day_of_month) ?></p>
                <table>
                    <thead>
                        <tr>
                            <th><?= __('S', 'ninja') ?></th>
                            <th><?= __('S', 'ninja') ?></th>
                            <th><?= __('M', 'ninja') ?></th>
                            <th><?= __('T', 'ninja') ?></th>
                            <th><?= __('W', 'ninja') ?></th>
                            <th><?= __('T', 'ninja') ?></th>
                            <th><?= __('F', 'ninja') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                // Fill the final days of the previous month
                                for ($i = 0; $i < $start_day_of_week; $i++) {
                                    $previous_month_day = $days_in_last_month - ($start_day_of_week - $i - 1);
                                    ?>
                                    <td class='not-current-month'><?= $previous_month_day ?></td><?php
                                }

                                $current_day_of_week = $start_day_of_week;
                                for ($day_num = 1;
                                $day_num <= $days_in_month;
                                $day_num++) {
                                if ($current_day_of_week % 7 == 0) {
                            ?></tr>
                        <tr><?php // Start a new row
                                }

                                $class = ($day_num == date('d') && $month == date('m') && $year == date('Y')) ? 'today' : 'normal-day';
                            ?>
                            <td class='<?= $class ?>'><?= $day_num ?></td><?php // Output the day

                                $current_day_of_week++;
                                }

                                // Finish off the calendar with empty cells if necessary
                                while ($current_day_of_week % 7 != 0) {
                                    ?>
                                    <td class='empty'></td><?php
                                    $current_day_of_week++;
                                }

                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php

            return ob_get_clean();

        }

        public function generate_forex_chart($widget_id): string
        {
            $id = Nh_Cryptor::Encrypt($widget_id);
            ob_start();
            ?>
            <p class="from"></p>
            <p class="to"></p>
            <canvas class="forex-canvas" data-id="<?= $id ?>"></canvas>
            <?php
            return ob_get_clean();
        }

        private function makeCurlRequest($url, $method = 'GET', $data = NULL, $auth = NULL, $sslVerify = FALSE)
        {
            $curl = curl_init();

            // Format the data for GET request as query string
            if (strtoupper($method) === 'GET' && is_array($data)) {
                $url .= '?' . http_build_query($data);
            }

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $sslVerify);

            // Different methods and data handling
            switch (strtoupper($method)) {
                case 'POST':
                    curl_setopt($curl, CURLOPT_POST, TRUE);
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case 'PUT':
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                // Add other cases for different methods if necessary
            }

            // Authentication
            if (isset($auth['token'])) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, [ 'Authorization: Bearer ' . $auth['token'] ]);
            } elseif (isset($auth['username'], $auth['password'])) {
                curl_setopt($curl, CURLOPT_USERPWD, $auth['username'] . ':' . $auth['password']);
            }

            // Execute and handle response
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_message = curl_error($curl);
                curl_close($curl);
                return new \WP_Error('curl_error', $error_message);
            }

            curl_close($curl);

            // Decode JSON response
            $decoded_response = json_decode($response, TRUE);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return new \WP_Error('json_error', 'JSON decoding error');
            }

            return $decoded_response;
        }

        private function getValueFromNestedArray($array, $path)
        {
            $keys = explode('.', $path);
            foreach ($keys as $key) {
                if (!isset($array[$key])) {
                    return NULL; // or any default value you prefer
                }
                $array = $array[$key];
            }
            return $array;
        }

        public function get_widget_html()
        {
            $type   = $this->meta_data['widget_type'];
            $result = '';

            switch ($type) {
                case 'calender':
                    $result = $this->generate_calender();
                    break;
                case 'fastforex':
                    $result = $this->generate_forex_chart($this->ID);
                    break;
                default:
                    $api_auth_type = $this->meta_data['api_auth_type'];
                    $auth          = NULL;

                    parse_str($this->meta_data['api_data'], $data);
                    $data = !empty($data) ? $data : NULL;

                    if ($api_auth_type === 'auth') {
                        $auth = [
                            'username' => $this->meta_data['api_key'],
                            'password' => $this->meta_data['api_secret'],
                        ];
                    }

                    if ($api_auth_type === 'token') {
                        $auth = [
                            'token' => $this->meta_data['api_token']
                        ];
                    }

                    $response = $this->makeCurlRequest($this->meta_data['api_endpoint'], $this->meta_data['api_method'], $data, $auth);

                    $keys = get_field('api_return_keys', $this->ID);
                    $data = [];
                    foreach ($keys as $key) {
                        $data = $this->getValueFromNestedArray($response, $key['key_name']);
                    }


                    if (is_wp_error($response)) {
                        return $response->get_error_message();
                    }

                    break;
            }
            return $result;
        }
    }

