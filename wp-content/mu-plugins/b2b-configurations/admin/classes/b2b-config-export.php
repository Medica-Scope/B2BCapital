<?php
    /**
     * Filename: b2b_config_export.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

     use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Config_Export
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author  - Mustafa Shaaban
     */
    class B2b_Config_Export
    {
        protected    $b2b_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->b2b_configuration = B2B_CONFIGURATION;
            $this->pages             = $pages;

            add_action('wp_ajax_b2b_export_ajax', [
                $this,
                'export_ajax'
            ]);
        }

        public function b2b_export_page()
        {
            include_once PLUGIN_PATH . 'admin/partials/page-export.php';
        }

        public function export_ajax()
        {
            $form_data = $_POST['data'];
            $post_type = $form_data['b2b_post_type'];
            $limit     = $form_data['b2b_limit'];
            $file_type = $form_data['b2b_file_type'];
            $application_status = $form_data['b2b_application_status'];
            $args      = [
                'post_type'        => $post_type,
                'post_status'      => [ 'publish' ],
                'posts_per_page'   => $limit,
                'suppress_filters' => TRUE,
                'orderby'          => 'ID',
                'order'            => 'DESC'
            ];
            if($post_type == 'application'){
                $args['post_status'] = $application_status;
            }
            $data = new WP_Query($args);
            switch ($file_type) {
                case "csv" :
                    // Submission from
                    $filename = "b2b_" . $post_type . "_data_export_" . date('Ymdhis') . ".csv";
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Content-type: text/csv");
                    header("Content-Disposition: attachment; filename=\"$filename\"");
                    if(!empty($this->convert($data->get_posts()))){
                        $this->export_CSV_file($this->convert($data->get_posts()), $filename);
                        $result = [
                            'success'   => TRUE,
                            'file'      => plugin_dir_url(__FILE__) . '../exports/' . $filename,
                            'msg'       => __('CSV file has been generated', 'b2b'),
                            'toast_msg' => __('Your CSV file has been generated successfully, Your download should be started now.', 'b2b')
                        ];
                    }else{
                        $result = [
                            'success'   => FALSE,
                            'msg'       => __('No data found. ', 'b2b'),
                            'toast_msg' => __('Failed', 'b2b'),
                        ];
                    }
                    break;
                default :
                    $result = [
                        'success'   => FALSE,
                        'msg'       => __('Please select a valid file type. ', 'b2b'),
                        'toast_msg' => __('Invalid File Type', 'b2b'),
                    ];
                    break;
            }

            wp_send_json($result);
        }

        private function export_CSV_file($records, $filename)
        {
            // create a file pointer connected to the output stream
            //            $fh = fopen( 'php://output', 'w' );
            $fh = fopen(plugin_dir_path(__FILE__) . '../exports/' . $filename, 'wb');
            $heading = FALSE;
            if (!empty($records))
                foreach ($records as $row) {
                    if (!$heading) {
                        // output the column headings
                        fputcsv($fh, array_keys($row));
                        $heading = TRUE;
                    }
                    // loop over the rows, outputting them
                    fputcsv($fh, array_values($row));

                }
            fclose($fh);
        }

        private function convert($data): array
        {
            $arr = [];

            foreach ($data as $row) {
                $r     = [
                    'ID'    => $row->ID,
                    'Title' => $row->post_title,
                    'Date' => date('j F, Y', strtotime($row->post_date))
                ];
                $arr[] = $r;
            }

            return $arr;
        }
    }


    //TODO:: ADD more post types, file types, change cycle of export, add order and order by field, change header names, and split reading data

