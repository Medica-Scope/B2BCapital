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
    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Ajax_Response;
    use NH\APP\HELPERS\Nh_Cryptor;
    use NH\Nh;
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
            // Opportunity Data
            'opportunity_type',
            'start_bidding_amount',
            'target_amount',
            'project_phase',
            'project_start_date',
            'project_assets_amount',
            'project_yearly_cashflow_amount',
            'project_yearly_net_profit_amount',

            //Basic Info
            'short_description',
            'date_founded',
            'asking_price_in_usd',
            'number_of_customers',
            'business_team_size',
            'location',

            // Financial Info
            'net_profit',
            'valuation_in_usd',
            'stake_to_be_sold_percentage',
            'usd_exchange_rate_used_in_conversion',
            'annual_accounting_revenue',
            'annual_growth_rate_percentage',
            'annual_growth_rate',

            // Business Information
            'tech_stack_this_product_is_built_on',
            'product_competitors',
            'extra_details',

            // Status
            'opportunity_stage',

            'step_two',
            'fav_count',
            'ignore_count',
            'opportunity_bids',
            'opportunity_acquisitions',
            'opportunity_investments',
        ];
        public array $taxonomy  = [
            'opportunity-category',
            'opportunity-type',
            'industry',
            'business-type',
            'business-model'
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
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_create_opportunity_ajax', $this, 'create_opportunity');
            $this->hooks->add_action('get_header', $this, 'acf_form_head');
            $this->hooks->add_action('acf/save_post', $this, 'after_acf_form_submission', 20);
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_upload_attachment', $this, 'upload_attachment');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_upload_attachment', $this, 'upload_attachment');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_remove_attachment', $this, 'remove_attachment');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_remove_attachment', $this, 'remove_attachment');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_toggle_favorite_opportunity_ajax', $this, 'toggle_opportunity_favorite');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_toggle_favorite_opportunity_ajax', $this, 'toggle_opportunity_favorite');
            $this->hooks->add_action('wp_ajax_' . Nh::_DOMAIN_NAME . '_ignore_opportunity_ajax', $this, 'ignore_opportunity');
            $this->hooks->add_action('wp_ajax_nopriv_' . Nh::_DOMAIN_NAME . '_ignore_opportunity_ajax', $this, 'ignore_opportunity');
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
        public function create_opportunity(): void
        {
            global $user_ID;

            $form_data                        = $_POST['data'];
            $project_name                     = sanitize_text_field($form_data['project_name']);
            $category                         = (int)sanitize_text_field($form_data['category']);
            $description                      = sanitize_text_field($form_data['description']);
            $short_description                = sanitize_text_field($form_data['short_description']);
            $opportunity_type                 = (int)sanitize_text_field($form_data['opportunity_type']);
            $attachment_id                    = (int)sanitize_text_field(Nh_Cryptor::Decrypt($form_data['media_file_id']));
            $start_bidding_amount             = sanitize_text_field($form_data['start_bidding_amount']);
            $target_amount                    = sanitize_text_field($form_data['target_amount']);
            $project_phase                    = isset($form_data['project_phase']) ? sanitize_text_field($form_data['project_phase']) : '';
            $project_start_date               = sanitize_text_field($form_data['project_start_date']);
            $project_assets_amount            = sanitize_text_field($form_data['project_assets_amount']);
            $project_yearly_cashflow_amount   = sanitize_text_field($form_data['project_yearly_cashflow_amount']);
            $project_yearly_net_profit_amount = sanitize_text_field($form_data['project_yearly_net_profit_amount']);

            $date_founded                         = sanitize_text_field($form_data['date_founded']);
            $asking_price_in_usd                  = sanitize_text_field($form_data['asking_price_in_usd']);
            $number_of_customers                  = sanitize_text_field($form_data['number_of_customers']);
            $business_team_size                   = sanitize_text_field($form_data['business_team_size']);
            $location                             = sanitize_text_field($form_data['location']);
            $net_profit                           = sanitize_text_field($form_data['net_profit']);
            $valuation_in_usd                     = sanitize_text_field($form_data['valuation_in_usd']);
            $stake_to_be_sold_percentage          = sanitize_text_field($form_data['stake_to_be_sold_percentage']);
            $usd_exchange_rate_used_in_conversion = sanitize_text_field($form_data['usd_exchange_rate_used_in_conversion']);
            $annual_accounting_revenue            = sanitize_text_field($form_data['annual_accounting_revenue']);
            $annual_growth_rate_percentage        = sanitize_text_field($form_data['annual_growth_rate_percentage']);
            $annual_growth_rate                   = sanitize_text_field($form_data['annual_growth_rate']);
            $tech_stack_this_product_is_built_on  = sanitize_text_field($form_data['tech_stack_this_product_is_built_on']);
            $product_competitors                  = sanitize_text_field($form_data['product_competitors']);
            $allowed_tags                         = '<p><h1><h2><h3><h4><h5><h6><a><abbr><b><bdi><br><code><em><i><mark><q><s><samp><small><span><strong><sub><sup><u><var><wbr>';
            $extra_details                        = strip_tags($form_data['extra_details'], $allowed_tags);
            $business_type                        = (int)sanitize_text_field($form_data['business_type']);
            $business_model                       = !is_array($form_data['business_model']) ? [ $form_data['business_model'] ] : $form_data['business_model'];

            $recaptcha_response            = sanitize_text_field($form_data['g-recaptcha-response']);
            $_POST["g-recaptcha-response"] = $recaptcha_response;


            if (empty($form_data)) {
                new Nh_Ajax_Response(FALSE, __("Can't register with empty credentials.", 'ninja'));
            }

            if (!wp_verify_nonce($form_data['create_opportunity_nonce'], Nh::_DOMAIN_NAME . "_create_opportunity_form")) {
                new Nh_Ajax_Response(FALSE, __("Something went wrong!.", 'ninja'));
            }

            if (empty($project_name)) {
                new Nh_Ajax_Response(FALSE, __("The project name field shouldn't be empty!.", 'ninja'));
            }
            if (empty($category)) {
                new Nh_Ajax_Response(FALSE, __("The category field shouldn't be empty!.", 'ninja'));
            }
            if (empty($description)) {
                new Nh_Ajax_Response(FALSE, __("The description field shouldn't be empty!.", 'ninja'));
            }
            if (empty($short_description)) {
                new Nh_Ajax_Response(FALSE, __("The short description field shouldn't be empty!.", 'ninja'));
            }
            if (empty($opportunity_type)) {
                new Nh_Ajax_Response(FALSE, __("The opportunity type field shouldn't be empty!.", 'ninja'));
            }

            $unique_type_name = get_term_meta($opportunity_type, 'unique_type_name', TRUE);

            if ($unique_type_name === 'bidding') {
                if (empty($start_bidding_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The start bidding amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($target_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The target amount field shouldn't be empty!.", 'ninja'));
                }
            } elseif ($unique_type_name === 'acquisition') {
                if (empty($project_phase)) {
                    new Nh_Ajax_Response(FALSE, __("The project phase field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_start_date)) {
                    new Nh_Ajax_Response(FALSE, __("The project start date field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_assets_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project assets amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_yearly_cashflow_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project yearly cash flow amount field shouldn't be empty!.", 'ninja'));
                }
                if (empty($project_yearly_net_profit_amount)) {
                    new Nh_Ajax_Response(FALSE, __("The project yearly new profit amount field shouldn't be empty!.", 'ninja'));
                }
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'frontend_create_opportunity');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            if (!$this->can_create_opportunity()) {
                new Nh_Ajax_Response(FALSE, __("You have exceeded your creation limit for this month.", 'ninja'));
            }

            $this->title           = $project_name;
            $this->content         = $description;
            $this->author          = $user_ID;
            $this->thumbnail       = $attachment_id;
            $this->taxonomy        = [
                'opportunity-category' => [ $category ],
                'opportunity-type'     => [ $opportunity_type ],
                'business-type'        => [ $business_type ],
                'business-model'       => array_map(function($ID) {
                    return (int)$ID;
                }, $business_model)
            ];
            $opportunity_type_slug = get_term_meta($opportunity_type, 'unique_type_name', TRUE);


            $this->set_meta_data('short_description', $short_description);
            $this->set_meta_data('opportunity_type', $opportunity_type_slug);
            $this->set_meta_data('start_bidding_amount', $start_bidding_amount);
            $this->set_meta_data('target_amount', $target_amount);
            $this->set_meta_data('project_phase', $project_phase);
            $this->set_meta_data('project_start_date', $project_start_date);
            $this->set_meta_data('project_assets_amount', $project_assets_amount);
            $this->set_meta_data('project_yearly_cashflow_amount', $project_yearly_cashflow_amount);
            $this->set_meta_data('project_yearly_net_profit_amount', $project_yearly_net_profit_amount);
            $this->set_meta_data('date_founded', $date_founded);
            $this->set_meta_data('asking_price_in_usd', $asking_price_in_usd);
            $this->set_meta_data('number_of_customers', $number_of_customers);
            $this->set_meta_data('business_team_size', $business_team_size);
            $this->set_meta_data('location', $location);
            $this->set_meta_data('net_profit', $net_profit);
            $this->set_meta_data('valuation_in_usd', $valuation_in_usd);
            $this->set_meta_data('stake_to_be_sold_percentage', $stake_to_be_sold_percentage);
            $this->set_meta_data('usd_exchange_rate_used_in_conversion', $usd_exchange_rate_used_in_conversion);
            $this->set_meta_data('annual_accounting_revenue', $annual_accounting_revenue);
            $this->set_meta_data('annual_growth_rate_percentage', $annual_growth_rate_percentage);
            $this->set_meta_data('annual_growth_rate', $annual_growth_rate);
            $this->set_meta_data('tech_stack_this_product_is_built_on', $tech_stack_this_product_is_built_on);
            $this->set_meta_data('product_competitors', $product_competitors);
            $this->set_meta_data('extra_details', $extra_details);
            $this->set_meta_data('opportunity_stage', 'new');

            $opportunity = $this->insert();

            if (is_wp_error($opportunity)) {
                new Nh_Ajax_Response(FALSE, $opportunity->get_error_message());
            }

            $form_template = get_term_meta($category, 'form_template', TRUE);

            if (!empty($form_template)) {
                $field_group = self::get_field_groups_by_post_id($form_template);
                if (!empty($field_group)) {
                    $field_group[0]['opp_id'] = $opportunity->ID;

                    if (!session_id()) {
                        session_start();
                    }
                    $_SESSION['step_two'] = [
                        'status' => TRUE,
                        'ID'     => $opportunity->ID
                    ];
                    new Nh_Ajax_Response(TRUE, __('Opportunity has been added successfully', 'ninja'), [
                        'redirect_url' => add_query_arg([ 'q' => Nh_Cryptor::Encrypt(serialize($field_group[0])) ], apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity/create-opportunity-step-2'))))
                    ]);
                }
            }

            new Nh_Ajax_Response(TRUE, __('Opportunity has been added successfully', 'ninja'), [
                'redirect_url' => apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities')))
            ]);
        }

        public function acf_form_head(): void
        {
            if (is_page('create-opportunity-step-2')) {
                acf_form_head();
            }
        }

        public function after_acf_form_submission($post_id): void
        {

            if (is_page('create-opportunity-step-2') && isset($_GET['q']) && !empty(unserialize(Nh_Cryptor::Decrypt($_GET['q'])))) {
                $data = unserialize(Nh_Cryptor::Decrypt($_GET['q']));
                if ($post_id === $data['opp_id']) {
                    if (!session_id()) {
                        session_start();
                    }
                    $_SESSION['step_two'] = [];
                    wp_safe_redirect(apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))));
                    exit();
                }
            }
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

        /**
         * Description...
         *
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return array
         */
        public function get_all_custom(array $status = [ 'any' ], int $limit = 10, string $orderby = 'ID', string $order = 'DESC', array $not_in = [ '0' ], array $tax_query = [ '' ], int $user_id = 0): array
        {
            $args = [
                "post_type"      => $this->module,
                "post_status"    => $status,
                'relation'       => 'AND',
                "posts_per_page" => $limit,
                "author__in"     => ($user_id) ? [ $user_id ] : [],
                "orderby"        => $orderby,
                "not__in"        => $not_in,
                "order"          => $order,
                "tax_query"      => [
                    'relation' => 'AND',
                ]
            ];
            if (!empty($tax_query)) {
                $args['tax_query'][] = $tax_query;
            }
            $posts    = new \WP_Query($args);
            $Nh_Posts = [];

            foreach ($posts->get_posts() as $post) {
                $Nh_Posts[] = $this->convert($post, $this->meta_data);
            }

            return $Nh_Posts;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function upload_attachment(): void
        {
            $file = $_FILES;

            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                new Nh_Ajax_Response(FALSE, __('The reCaptcha verification failed. Please try again.', 'ninja'));/* the reCAPTCHA answer  */
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'submit_application');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            if (!empty($file)) {

                $upload     = wp_upload_bits($file['file']['name'], NULL, file_get_contents($file['file']['tmp_name']));
                $maxsize    = 5242880;
                $acceptable = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ];

                if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
                    new Nh_Ajax_Response(FALSE, __("File too large. File must be less than 2 megabytes.", 'ninja'));
                }

                if ((!in_array($_FILES['file']['type'], $acceptable)) && (!empty($_FILES["file"]["type"]))) {
                    new Nh_Ajax_Response(FALSE, __("Invalid file type. Only JPG, JPEG and PNG types are accepted.", 'ninja'));
                }

                if (!empty($upload['error'])) {
                    new Nh_Ajax_Response(FALSE, __($upload['error'], 'ninja'));
                }

                $wp_filetype = wp_check_filetype(basename($upload['file']), NULL);

                $wp_upload_dir = wp_upload_dir();

                $attachment = [
                    'guid'           => $wp_upload_dir['baseurl'] . _wp_relative_upload_path($upload['file']),
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];

                $attach_id = wp_insert_attachment($attachment, $upload['file']);

                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);

                wp_update_attachment_metadata($attach_id, $attach_data);

                wp_upload_bits($file['file']["name"], NULL, file_get_contents($file['file']["tmp_name"]));

                new Nh_Ajax_Response(TRUE, __('Attachment has been uploaded successfully.', 'ninja'), [
                    'attachment_ID' => Nh_Cryptor::Encrypt($attach_id)
                ]);
            } else {
                new Nh_Ajax_Response(FALSE, __("Can't upload empty file", 'ninja'));
            }
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function remove_attachment(): void
        {
            $attachment_id = Nh_Cryptor::Decrypt(sanitize_text_field($_POST['attachment_id']));

            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                new Nh_Ajax_Response(FALSE, __('The reCaptcha verification failed. Please try again.', 'ninja'));/* the reCAPTCHA answer  */
            }

            $check_result = apply_filters('gglcptch_verify_recaptcha', TRUE, 'string', 'submit_application');

            if ($check_result !== TRUE) {
                new Nh_Ajax_Response(FALSE, __($check_result, 'ninja'));/* the reCAPTCHA answer  */
            }

            $deleted = wp_delete_attachment($attachment_id);

            if (!$deleted) {
                new Nh_Ajax_Response(FALSE, __("Can't remove attachment", 'ninja'));
            } else {
                new Nh_Ajax_Response(TRUE, __("Attachment has been removed successfully", 'ninja'));
            }
        }

        /**
         * Description...toggle fav opportunity and save it to user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         */
        public function toggle_opportunity_favorite(): void
        {

            $post_id     = intval($_POST['post_id']);
            $user_id     = intval($_POST['user_id']);
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $favorites   = [];
            if (!is_wp_error($profile)) {
                $favorites = ($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
                if (in_array($post_id, $favorites)) {
                    $key = array_search($post_id, $favorites);
                    if ($key !== FALSE) {
                        unset($favorites[$key]);
                    }
                    $profile->set_meta_data('favorite_opportunities', $favorites);
                    $profile->update();
                    $fav_count = get_post_meta($post_id, 'fav_count', TRUE);
                    update_post_meta($post_id, 'fav_count', (int)$fav_count - 1);
                    new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                        'fav_active' => 1
                    ]);
                } else {
                    $favorites[] = $post_id;
                    $profile->set_meta_data('favorite_opportunities', $favorites);
                    $profile->update();
                    $fav_count = get_post_meta($post_id, 'fav_count', TRUE);
                    update_post_meta($post_id, 'fav_count', (int)$fav_count + 1);
                    new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                        'fav_active' => 0
                    ]);
                }
            } else {
                new Nh_Ajax_Response(TRUE, __('Something went wrong!', 'ninja'), [
                    'status'     => FALSE,
                    'msg'        => 'Invalid profile ID',
                    'fav_active' => 1
                ]);
            }
        }

        /**
         * Description...get user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         *
         * @param $profile
         *
         * @return array
         */
        public function get_user_favorites($profile): array
        {
            return ($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];
        }

        /**
         * Description...Check if post exists in user's favorite list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_post_in_user_favorites($post_id, $user_id): bool
        {
            $profile_id  = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj = new Nh_Profile();
            $profile     = $profile_obj->get_by_id((int)$profile_id);
            $favorites   = [];
            if (!is_wp_error($profile)) {
                $favorites = $this->get_user_favorites($profile);
                $favorites = array_combine($favorites, $favorites);
            }
            return isset($favorites[$post_id]);
        }

        /**
         * Description...ignore oppertunitie and save it to user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return void
         */
        public function ignore_opportunity(): void
        {
            $post_id               = intval($_POST['post_id']);
            $user_id               = intval($_POST['user_id']);
            $profile_id            = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj           = new Nh_Profile();
            $profile               = $profile_obj->get_by_id((int)$profile_id);
            $ignored_opportunities = [];
            if (!is_wp_error($profile)) {
                $ignored_opportunities = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
                $ignored_opportunities = array_combine($ignored_opportunities, $ignored_opportunities);
                if (isset($ignored_opportunities[$post_id])) {
                    unset($ignored_opportunities[$post_id]);
                    $ignored_opportunities = array_values($ignored_opportunities);
                    $profile->set_meta_data('ignored_opportunities', $ignored_opportunities);
                    $profile->update();
                    $ignore_count = get_post_meta($post_id, 'ignore_count', TRUE);
                    update_post_meta($post_id, 'ignore_count', (int)$ignore_count + 1);
                    ob_start();
                    get_template_part('app/Views/template-parts/opportunities-ajax');
                    $html = ob_get_clean();
                    new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                        'status'        => TRUE,
                        'msg'           => 'post un-ignored',
                        'ignore_active' => 1,
                        'updated'       => $html
                    ]);
                } else {
                    $ignored_opportunities[] = $post_id;
                    $profile->set_meta_data('ignored_opportunities', $ignored_opportunities);
                    $profile->update();
                    $ignore_count = get_post_meta($post_id, 'ignore_count', TRUE);
                    update_post_meta($post_id, 'ignore_count', (int)$ignore_count - 1);
                    ob_start();
                    get_template_part('app/Views/template-parts/opportunities-ajax');
                    $html = ob_get_clean();
                    new Nh_Ajax_Response(TRUE, __('Successful Response!', 'ninja'), [
                        'status'        => TRUE,
                        'msg'           => 'post ignored!',
                        'ignore_active' => 0,
                        'updated'       => $html
                    ]);
                }
            } else {
                new Nh_Ajax_Response(TRUE, __('Error Response!', 'ninja'), [
                    'status'        => FALSE,
                    'msg'           => 'You must have profile',
                    'ignore_active' => 1
                ]);
            }
        }

        public function get_user_ignored_opportunities($profile): array
        {
            return ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
        }

        /**
         * Description...Check if post exists in user's ignored list
         * @version 1.0
         * @since 1.0.0
         * @package NinjaHub
         * @author Ahmed Gamal
         * @return bool
         */
        public function is_post_in_user_ignored_opportunities($post_id, $user_id): bool
        {
            $profile_id            = get_user_meta($user_id, 'profile_id', TRUE);
            $profile_obj           = new Nh_Profile();
            $profile               = $profile_obj->get_by_id((int)$profile_id);
            $ignored_opportunities = [];
            if (!is_wp_error($profile)) {
                $ignored_opportunities = $this->get_user_ignored_opportunities($profile);
                $ignored_opportunities = array_combine($ignored_opportunities, $ignored_opportunities);
            }
            return isset($ignored_opportunities[$post_id]);
        }

        /**
         * Get dashboard opportunities to be displayed in the sidebar
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function get_dashboard_sidebar_opportunities(): array
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'      => $this->module,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'DESC',
                'author'         => $user_ID,
                'posts_per_page' => 6
            ]);

            $Nh_opportunities = [];

            foreach ($opportunities->get_posts() as $opportunity) {
                $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
            }

            return $Nh_opportunities;
        }


        public function get_opportunities()
        {

        }

        public function get_profile_opportunities(): array
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'   => $this->module,
                'post_status' => 'publish',
                'orderby'     => 'ID',
                'order'       => 'DESC',
                'author'      => $user_ID
            ]);

            $Nh_opportunities = [];

            foreach ($opportunities->get_posts() as $opportunity) {
                $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
            }

            return $Nh_opportunities;
        }

        public function get_profile_fav_opportunities(): array
        {
            global $user_ID;

            $profile_id       = get_user_meta($user_ID, 'profile_id', TRUE);
            $profile_obj      = new Nh_Profile();
            $profile          = $profile_obj->get_by_id((int)$profile_id);
            $Nh_opportunities = [];

            if (!is_wp_error($profile)) {
                $fav_ids = is_array($profile->meta_data['favorite_opportunities']) ? $profile->meta_data['favorite_opportunities'] : [];

                if (!empty($fav_ids)) {
                    $opportunities = new \WP_Query([
                        'post_type'   => $this->module,
                        'post_status' => 'publish',
                        'orderby'     => 'ID',
                        'order'       => 'DESC',
                        "post__in"    => $profile->meta_data['favorite_opportunities'],
                    ]);
                    foreach ($opportunities->get_posts() as $opportunity) {
                        $Nh_opportunities[] = $this->convert($opportunity, $this->meta_data);
                    }
                }
            }

            return $Nh_opportunities;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return bool
         * @throws \Exception
         */
        public function can_create_opportunity(): bool
        {
            global $user_ID;

            $opportunities = new \WP_Query([
                'post_type'      => $this->module,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'DESC',
                'author'         => $user_ID,
                'posts_per_page' => 1
            ]);

            if ($opportunities->have_posts()) {
                $now  = new \DateTime();
                $date = new \DateTime($opportunities->post->post_date);

                // Add one month to the current date
                $oneMonthLater = clone $now;
                $oneMonthLater->add(new \DateInterval('P1M'));

                // Check if the input date is more than one month from today
                if ($date > $oneMonthLater) {
                    return TRUE;
                }

                return FALSE;
            } else {
                return TRUE;
            }

        }

        public function get_opportunity_bids(int $opp_id = 0, $count = false): int|array
        {
            $id = $opp_id ? $opp_id : $this->ID;
            $nh_opportunity_bids_obj = new Nh_Opportunity_Bid();
            $nh_opportunity_bids = [];

            $bids = new \WP_Query([
                'post_type' => $nh_opportunity_bids_obj->module,
                'post_status' => 'publish',
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => $id,
                        'compare' => '=',
                    ],
                ],
            ]);

            if ($count) {
                return $bids->found_posts;
            }

            if ($bids->have_posts()) {
                foreach ($bids->posts as $single) {
                    $nh_opportunity_bids[] = $nh_opportunity_bids_obj->convert($single);
                }
            }

            return $nh_opportunity_bids;

        }

        public function get_opportunity_acquisitions(int $opp_id = 0, $count = false): int|array
        {
            $id = $opp_id ? $opp_id : $this->ID;
            $nh_opportunity_acquisitions_obj = new Nh_Opportunity_Acquisition();
            $nh_opportunity_acquisitions = [];

            $acquisitions = new \WP_Query([
                'post_type' => $nh_opportunity_acquisitions_obj->module,
                'post_status' => 'publish',
                'meta_query'  => [
                    [
                        'key'     => 'opportunity',
                        'value'   => $id,
                        'compare' => '=',
                    ],
                ],
            ]);

            if ($count) {
                return $acquisitions->found_posts;
            }

            if ($acquisitions->have_posts()) {
                foreach ($acquisitions->posts as $single) {
                    $nh_opportunity_acquisitions[] = $nh_opportunity_acquisitions_obj->convert($single);
                }
            }

            return $nh_opportunity_acquisitions;

        }
    }
