<?php
    /**
     * Filename: nh_config_export.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 1/18/2022
     */

    use NH\APP\MODELS\FRONT\MODULES\Nh_Lesson;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Config_Export
     * @version 1.0
     * @since 1.0.0
     * @package nh
     * @author  - Mustafa Shaaban
     */
    class Nh_Config_Export
    {
        protected    $nh_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->nh_configuration = NH_CONFIGURATION;
            $this->pages            = $pages;

            add_action('wp_ajax_ninja_export_ajax', [
                $this,
                'export_ajax'
            ]);

//            $this->append_to_json_file([['dsfs','dsfs','dsfs','dsfs','dsfs','dsfs','dsfs','dsfs','dsfs','dsfs']], 'nh_tmp_7mada_20230905110344.json');
        }

        public function nh_export_page()
        {
            include_once PLUGIN_PATH . 'admin/partials/page-export.php';
        }

        public function export_ajax()
        {
            $form_data   = $_POST['data'];
            $post_type   = $form_data['ninja_post_type'];
            $limit       = $form_data['ninja_limit'];
            $file_type   = $form_data['ninja_file_type'];
            $post_status = $form_data['ninja_post_status'];
            $args        = [
                'post_type'        => $post_type,
                'post_status'      => $post_status,
                'posts_per_page'   => $limit,
                'suppress_filters' => TRUE,
                'orderby'          => 'ID',
                'order'            => 'DESC'
            ];

            $data = new WP_Query($args);

            switch ($file_type) {
                case "csv" :
                    // Submission from
                    $filename = "nh_" . $post_type . "_data_export_" . date('Ymdhis') . ".csv";
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Content-type: text/csv");
                    header("Content-Disposition: attachment; filename=\"$filename\"");
                    if ($data->have_posts()) {
                        $this->export_CSV_file($this->convert($data->get_posts()), $filename);
                        $result = [
                            'success'   => TRUE,
                            'file'      => plugin_dir_url(__FILE__) . '../exports/' . $filename,
                            'msg'       => __('Your CSV file has been generated successfully, Your download should be started now.', 'ninja'),
                            'toast_msg' => __('CSV file has been generated', 'ninja'),
                        ];
                    } else {
                        $result = [
                            'success'   => FALSE,
                            'msg'       => __('No data found. ', 'ninja'),
                            'toast_msg' => __('Failed', 'ninja'),
                        ];
                    }
                    break;
                default :
                    $result = [
                        'success'   => FALSE,
                        'msg'       => __('Please select a valid file type. ', 'ninja'),
                        'toast_msg' => __('Invalid File Type', 'ninja'),
                    ];
                    break;
            }

            wp_send_json($result);
        }

        private function export_CSV_file($records, $filename)
        {
            // create a file pointer connected to the output stream
            //            $fh = fopen( 'php://output', 'w' );
            $fh      = fopen(plugin_dir_path(__FILE__) . '../exports/' . $filename, 'wb');
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
                $lesson  = new Nh_Lesson();
                $convert = $lesson->convert($row, [ 'custom_url' ]);
                $r       = [
                    'grade'        => $convert->taxonomy['grade'][0]->slug,
                    'lesson_term'  => $convert->taxonomy['lesson-term'][0]->slug,
                    'subject'      => $convert->taxonomy['subject'][0]->slug,
                    'unit_order'   => $convert->taxonomy['unit'][0]->slug,
                    'unit_name'    => $convert->taxonomy['unit-name'][0]->name,
                    'lesson_order' => $convert->taxonomy['lesson-order'][0]->slug,
                    'lesson_name'  => $convert->title
                ];
                $arr[]   = $r;
            }

            return $arr;
        }

        private function add_to_json_file($data): bool
        {
            $filename = "nh_tmp_" . $data[0]['post_type'] . "_" . date('Ymdhis') . ".json";
            $path = plugin_dir_path(__FILE__) . '../exports/'.$filename;
            $updatedData = json_encode($data, JSON_PRETTY_PRINT);
            if (file_put_contents($path, $updatedData) === false) {
                return true;
            } else {
                return false;
            }
        }

        private function append_to_json_file($data, $filename): bool
        {
            $path = plugin_dir_path(__FILE__) . '../exports/'.$filename;
            $jsonContent = file_get_contents($path);
            $current_data = json_decode($jsonContent, true);
            $current_data[] = $data;
            $updatedData = json_encode($current_data, JSON_PRETTY_PRINT);
            if (file_put_contents($path, $updatedData) === false) {
                return true;
            } else {
                return false;
            }
        }
    }


    //TODO:: ADD more post types, file types, change cycle of export, add order and order by field, change header names, and split reading data

