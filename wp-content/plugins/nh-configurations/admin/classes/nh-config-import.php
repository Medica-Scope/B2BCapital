<?php
    /**
     * @Filename: nh_config_import.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/18/2022
     */

    use NH\APP\MODELS\FRONT\MODULES\Nh_Lesson;
    use NH\Nh;

    /**
     * Description...
     *
     * @class Nh_Config_Import
     * @version 1.0
     * @since 1.0.0
     * @package nh
     * @author  - Mustafa Shaaban
     */
    class Nh_Config_Import
    {
        protected    $nh_configuration;
        public array $pages;

        public function __construct($pages)
        {
            $this->nh_configuration = NH_CONFIGURATION;
            $this->pages            = $pages;

            add_action('wp_ajax_ninja_import_ajax', [
                $this,
                'import_ajax'
            ]);

            add_action('wp_ajax_ninja_import_repeat_ajax', [
                $this,
                'import_repeat_ajax'
            ]);
        }

        public function nh_import_page(): void
        {
            include_once PLUGIN_PATH . 'admin/partials/page-import.php';
        }

        public function import_ajax(): void
        {
            $file         = $_FILES['file'];
            $bulk_at_once = empty((int)$_POST['batches']) || (int)$_POST['batches'] <= 0 ? 50 : (int)$_POST['batches'];

            // Check the file type
            if ($file && $file['type'] === 'text/csv') {

                $custom_path = plugin_dir_path(__FILE__) . '../imports/';

                // Check if the path is existing
                if (!file_exists($custom_path)) {
                    mkdir($custom_path, 0755, TRUE);
                }

                // Change the file name
                $source       = $file['tmp_name'];
                $file['name'] = 'ninja_data_import_' . date('Ymdhis') . '.csv';
                $destination  = trailingslashit($custom_path) . $file['name'];

                // Upload File Temp
                if (move_uploaded_file($source, $destination)) {

                    // Get batches
                    $batches       = $this->get_patches($destination, $bulk_at_once);
                    $success_count = 0;
                    $failed_count  = 0;

                    foreach ($batches[0] as $key => $row) {
                        if (count($row) < 7) {
                            wp_send_json([
                                'success'   => FALSE,
                                'msg' => __("Your CSV file format is inconsistent with the required specifications. Please refer to the provided sample file and adhere to its structure for a successful import.", 'ninja'),
                                'toast_msg'       => __('Invalid CSV File.', 'ninja')
                            ]);
                        }

                        if ($key === 0 && ($row[0] !== 'grade' || $row[1] !== 'lesson_term' || $row[2] !== 'subject' || $row[3] !== 'unit_order' || $row[4] !== 'unit_name' ||
                                           $row[5] !== 'lesson_order' || $row[6] !== 'lesson_name' || $row[7] !== 'video_id')) {
                            wp_send_json([
                                'success'   => FALSE,
                                'msg' => __("Your CSV file format is inconsistent with the required specifications. Please refer to the provided sample file and adhere to its structure for a successful import.", 'ninja'),
                                'toast_msg'       => __('Invalid CSV File.', 'ninja')
                            ]);
                        }

                        // Skip the headers
                        if ($key === 0) {
                            continue;
                        }

                        // Start CSV Importing to database
                        if ($this->lessons_import($row)) {
                            $success_count++;
                        } else {
                            $failed_count++;
                        }


                    }

                    if (count($batches) > 1) {
                        wp_send_json([
                            'success'     => TRUE,
                            'repeat'      => TRUE,
                            'repeat_data' => [
                                'batches_count' => count($batches),
                                'bulk_at_once'  => $bulk_at_once,
                                'next'          => 1,
                                'file'          => $file['name'],
                                'success_count' => $success_count,
                                'failed_count'  => $failed_count,
                            ],
                            'msg'         => __('First batch has been inserted successfully!', 'ninja'),
                            'toast_msg'   => __('In Process', 'ninja')
                        ]);

                    } else {
                        if (!unlink($destination)) {
                            wp_send_json([
                                'success'   => FALSE,
                                'msg'       => __('Something Went Wrong, Please contact the plugin developer.', 'ninja'),
                                'toast_msg' => __('Something Went Wrong.', 'ninja')
                            ]);
                        }

                        wp_send_json([
                            'success'       => TRUE,
                            'repeat'        => FALSE,
                            'success_count' => $success_count,
                            'failed_count'  => $failed_count,
                            'msg'           => sprintf(__('%s lesson(s) are successfully imported, and %s lesson(s) are filed to be imported', 'ninja'), $success_count, $failed_count),
                            'toast_msg'     => __('Lessons has been imported successfully!', 'ninja')
                        ]);
                    }

                } else {
                    wp_send_json([
                        'success'   => FALSE,
                        'msg'       => __('Something Went Wrong, Please contact the plugin developer.', 'ninja'),
                        'toast_msg' => __('Something Went Wrong.', 'ninja')
                    ]);
                }

            } else {
                wp_send_json([
                    'success'   => FALSE,
                    'msg'       => __("This file is not a valid CSV file, kindly use the sample file and follow the file instructions to complete the importing process successfully.", 'ninja'),
                    'toast_msg' => __("Lessons are not imported!", 'ninja')
                ]);
            }

        }

        public function import_repeat_ajax(): void
        {
            $form_data     = $_POST['data'];
            $batches_count = (int)$form_data['batches_count'];
            $bulk_at_once  = (int)$form_data['bulk_at_once'];
            $next          = (int)$form_data['next'];
            $file          = $form_data['file'];
            $success_count = (int)$form_data['success_count'];
            $failed_count  = (int)$form_data['failed_count'];
            $file_path     = plugin_dir_path(__FILE__) . '../imports/' . $file;

            // Get batches
            $batches = $this->get_patches($file_path, $bulk_at_once);

            if (isset($batches[$next])) {

                // Import Lessons
                foreach ($batches[$next] as $row) {
                    if ($this->lessons_import($row)) {
                        $success_count++;
                    } else {
                        $failed_count++;
                    }
                }

                if ($batches_count - 1 > $next) {
                    wp_send_json([
                        'success'     => TRUE,
                        'repeat'      => TRUE,
                        'repeat_data' => [
                            'batches_count' => count($batches),
                            'bulk_at_once'  => $bulk_at_once,
                            'next'          => $next + 1,
                            'file'          => $file,
                            'success_count' => $success_count,
                            'failed_count'  => $failed_count,
                        ],
                        'msg'         => sprintf(__('%s batch is successfully finished, (%s Success && %s Failed) ', 'ninja'), $next, $success_count, $failed_count),
                        'toast_msg'   => __('Import is still in processing.', 'ninja')
                    ]);

                } else {

                    if (!unlink($file_path)) {
                        wp_send_json([
                            'success'       => FALSE,
                            'success_count' => $success_count,
                            'failed_count'  => $failed_count,
                            'msg'           => __('Something Went Wrong, Please contact the plugin developer.', 'ninja'),
                            'toast_msg'     => __('Something Went Wrong.', 'ninja')
                        ]);
                    }

                    wp_send_json([
                        'success'       => TRUE,
                        'repeat'        => FALSE,
                        'success_count' => $success_count,
                        'failed_count'  => $failed_count,
                        'msg'           => sprintf(__('%s lesson(s) are successfully imported, and %s lesson(s) are filed to be imported', 'ninja'), $success_count, $failed_count),
                        'toast_msg'     => __('Lessons has been imported successfully!', 'ninja')
                    ]);
                }


            } else {
                wp_send_json([
                    'success'       => FALSE,
                    'success_count' => $success_count,
                    'failed_count'  => $failed_count,
                    'msg'           => __('Something Went Wrong, Please contact the plugin developer.', 'ninja'),
                    'toast_msg'     => __('Something Went Wrong.', 'ninja')
                ]);
            }


        }

        /**
         * Read the csv file and divide it to batches and return batches
         *
         * @param string $file_path
         * @param string $bulk_at_once
         *
         * @return array
         * @version 1.0
         * @since 1.0.0
         * @package moe
         * @author Mustafa Shaaban
         */
        private function get_patches(string $file_path, string $bulk_at_once): array
        {

            $csvFile = fopen($file_path, 'r');
            if ($csvFile === FALSE) {
                wp_send_json([
                    'success'   => FALSE,
                    'msg'       => __('Error opening CSV file.', 'ninja'),
                    'toast_msg' => __('Error opening CSV file.', 'ninja')
                ]);
            }

            $data = [];
            while (($row = fgetcsv($csvFile)) !== FALSE) {
                $data[] = $row;
            }
            fclose($csvFile);

            return array_chunk($data, $bulk_at_once);
        }

        private function lessons_import($single): bool
        {
            try {
                $grade        = get_term_by('slug', $single[0], 'grade');
                $lesson_term  = get_term_by('slug', $single[1], 'lesson-term');
                $subject      = get_term_by('slug', $single[2], 'subject');
                $unit         = get_term_by('slug', $single[3], 'unit');
                $lesson_order = get_term_by('slug', $single[5], 'lesson-order');

                if (!empty($grade) && !empty($lesson_term) && !empty($subject) && !empty($unit) && !empty($lesson_order)) {
                    $lesson           = new Nh_Lesson();
                    $lesson->title    = $single[6];
                    $lesson->taxonomy = [
                        'grade'        => [ $grade->term_id ],
                        'lesson-term'  => [ $lesson_term->term_id ],
                        'subject'      => [ $subject->term_id ],
                        'unit'         => [ $unit->term_id ],
                        'unit-name'    => $single[4],
                        'lesson-order' => [ $lesson_order->term_id ]
                    ];
                    $lesson->set_meta_data('video_id', $single[7]);
                    //                $lesson->set_meta_data('custom_url', $single['path']);
                    $lesson->insert();
                    return TRUE;
                }

                return FALSE;
            } catch (Exception $e) {
                return FALSE;
            }
        }
    }
