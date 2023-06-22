<?php
    /**
     * @Filename: class-b2b_user.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */


    namespace B2B\APP\CLASSES;

    use B2B\APP\HELPERS\B2b_Cryptor;
    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\APP\HELPERS\B2b_Mail;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Profile;
    use B2B\B2b;
    use WP_Error;
    use WP_User;

    /**
     * Description...
     *
     * @class B2b_User
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_User
    {
        /**
         * Default Meta
         */
        const USER_DEFAULTS = [
            'profile_id'                  => 0,
            'avatar_id'                   => 0,
            'email_confirmation_status'   => 0,
            'phone_confirmation_status'   => 0,
            'account_confirmation_status' => 0,
            'default_language'            => 'en'
        ];
        /**
         * USER ROLES
         */
        const ADMIN     = 'administrator';
        const CMS       = 'cmsmanager';
        const OWNER     = 'owner';
        const INVESTOR  = 'investor';
        const SEO       = 'seomanager';
        const WEBMASTER = 'webmaster';
        const REVIEWER  = 'reviewer';
        /**
         * Verification Types
         */
        const VERIFICATION_TYPES = [
            'email'    => 'email',
            'mobile'   => 'mobile',
            'whatsapp' => 'whatsapp',
        ];
        /**
         * B2B USER INSTANCE
         *
         * @var object|null
         */
        private static ?object $instance = NULL;
        /**
         * The User ID
         *
         * @since 1.0.0
         * @var int
         */
        public int $ID = 0;
        /**
         * The User Username
         *
         * @since 1.0.0
         * @var string
         */
        public string $username = '';
        /**
         * The User Password
         *
         * @since 1.0.0
         * @var string
         */
        public string $password = '';
        /**
         * The User Email
         *
         * @since 1.0.0
         * @var string
         */
        public string $email = '';
        /**
         * The User First name
         *
         * @since 1.0.0
         * @var string
         */
        public string $first_name = '';
        /**
         * The User Last name
         *
         * @since 1.0.0
         * @var string
         */
        public string $last_name = '';
        /**
         * The User Nickname
         *
         * @since 1.0.0
         * @var string
         */
        public string $nickname = '';
        /**
         * The User Displayed name
         *
         * @since 1.0.0
         * @var string
         */
        public string $display_name = '';
        /**
         * The User Avatar url
         *
         * @since 1.0.0
         * @var array|null|string
         */
        public string|array|null $avatar;
        /**
         * The User single role as
         *
         * @since 1.0.0
         * @var string
         */
        public string $role = '';
        /**
         * The User Status (Active or Not)
         *
         * @since 1.0.0
         * @var int
         */
        public int $status = 0;
        /**
         * The User Registered date
         *
         * @since 1.0.0
         * @var string
         */
        public string $registered = '0000-00-00 00:00:00';
        /**
         * The User Activation key
         *
         * @since 1.0.0
         * @var string
         */
        public string $activation_key = '';

        /**
         * @var \B2B\APP\MODELS\FRONT\MODULES\B2b_Profile
         */
        public B2b_Profile $profile;

        /**
         * The User Meta data
         *
         * @since 1.0.0
         * @var array|string[]
         */
        public array $user_meta = [
            'first_name',
            'last_name',
            'nickname',
            'phone_number',
            'verification_type',
            'reset_password_key',
            'verification_key',
            'verification_expire_date',
        ];

        public function __construct()
        {
            global $pagenow;

            // Reformat class metadata
            foreach ($this->user_meta as $k => $meta) {
                $this->user_meta[$meta] = '';
                unset($this->user_meta[$k]);
            }

            // Add filter to override user avatar in users table
            if (is_admin() && ('users.php' == $pagenow || 'profile.php' == $pagenow)) {
                $hooks = new B2b_Hooks();
                $hooks->add_filter('get_avatar_data', $this, 'override_user_table_avatar', 1, 2);
                $hooks->run();
            }

        }

        /**
         * Description...
         *
         * @param $name
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return false
         */
        public function __get($name)
        {
            return property_exists($this, $name) ? $this->{$name} : FALSE;
        }

        /**
         * Description...
         *
         * @param $name
         * @param $value
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function __set($name, $value)
        {
            $this->{$name} = sanitize_text_field($value);
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User
         */
        public static function get_instance(): B2b_User
        {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * Checking user role
         *
         * @param string $role_name
         * @param int    $id
         *
         * @return bool
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public static function is_role(string $role_name, int $id = 0): bool
        {
            return in_array($role_name, self::get_user_role($id, FALSE));
        }

        /**
         * Function to get the user role by ID
         *
         * @param int  $id : The User ID
         * @param bool $single true to get the first rule, False to get all Roles
         *
         * @return string|array of rules if $single : return the first role only
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public static function get_user_role(int $id = 0, bool $single = TRUE): string|array
        {
            global $user_ID;
            $ID   = ($id !== 0 && is_numeric($id)) ? $id : $user_ID;
            $role = [];
            if (!empty($ID) && is_numeric($ID)) {
                $user_meta = get_userdata($ID);
                return $role = ($single) ? $user_meta->roles[0] : $user_meta->roles;
            }
            return $role;
        }

        /**
         * Get current user as a B2b User object
         *
         * @return \B2B\APP\CLASSES\B2b_User
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public static function get_current_user(): B2b_User
        {
            global $current_user;

            return self::get_user($current_user);
        }

        /**
         * @return int|\WP_Error|\static
         * @throws \Exception
         */
        public function insert(): B2b_User|int|WP_Error
        {
            $error = new WP_Error();

            if (username_exists($this->username)) {
                $error->add('username_exists', __('Sorry, this phone number is already exists!', 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'username' => $this->username ]
                ]);
                return $error;
            }

            if (email_exists($this->email)) {
                $error->add('email_exists', __('Sorry, that email already exists!', 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'email' => $this->email ]
                ]);
                return $error;
            }

            $user_id = wp_insert_user([
                'user_login'   => $this->username,
                'user_pass'    => $this->password,
                'user_email'   => $this->email,
                'first_name'   => $this->first_name,
                'last_name'    => $this->last_name,
                'display_name' => $this->display_name,
                'role'         => $this->role
            ]);

            if (is_wp_error($user_id)) {
                return $user_id;
            }

            $this->ID = $user_id;

            $avatar = $this->set_avatar();

            if ($avatar->has_errors()) {
                return $avatar;
            }

            $user_meta = array_merge($this->user_meta, self::USER_DEFAULTS);

            foreach ($user_meta as $key => $value) {
                $value = property_exists($this, $key) ? $this->{$key} : $value;
                add_user_meta($this->ID, $key, $value);
            }

            $profile         = new B2b_Profile();
            $profile->title  = $this->display_name;
            $profile->author = $this->ID;
            $profile->insert();

            update_user_meta($this->ID, 'profile_id', $profile->ID);

            if ($this->user_meta['verification_type'] === self::VERIFICATION_TYPES['mobile']) {
                $verification = $this->mobile_verification();
                if (is_wp_error($verification)) {
                    $error->add('whatsapp_error', __($verification->get_error_message(), 'b2b'), [
                        'status'  => FALSE,
                        'details' => [
                            'e' => '',
                        ]
                    ]);
                    return $error;
                }
            } elseif ($this->user_meta['verification_type'] === self::VERIFICATION_TYPES['whatsapp']) {
                $verification = $this->whatsapp_verification();
                if (is_wp_error($verification)) {
                    $error->add('whatsapp_error', __($verification->get_error_message(), 'b2b'), [
                        'status'  => FALSE,
                        'details' => [
                            'e' => '',
                        ]
                    ]);
                    return $error;
                }
            } else {
                $verification = $this->email_verification();
                if (!$verification) {
                    $error->add('whatsapp_error', __("The verification code didn't send!", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [
                            'email_error' => 'email error',
                        ]
                    ]);
                    return $error;
                }
            }

            $cred = [
                'user_login'    => $this->username,
                'user_password' => $this->password
            ];

            $login = wp_signon($cred);

            if (is_wp_error($login)) {
                $error->add('invalid_register_signOn', __($login->get_error_message(), 'b2b'), [
                    'status'  => FALSE,
                    'details' => [
                        'user_login' => $this->username,
                        'password'   => $this->password
                    ]
                ]);
                return $error;
            }

            do_action(B2b::_DOMAIN_NAME . "_after_create_user", $this);

            return $this;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User|\WP_Error
         */
        public function update(): B2b_User|WP_Error
        {
            $user_id = wp_update_user([
                'first_name'   => ucfirst(strtolower($this->first_name)),
                'last_name'    => ucfirst(strtolower($this->last_name)),
                'display_name' => ucfirst(strtolower($this->first_name)) . ucfirst(strtolower($this->last_name)),
                'role'         => $this->role
            ]);

            if (is_wp_error($user_id)) {
                return $user_id;
            }

            if (is_array($this->avatar) && !empty($this->avatar)) {
                $avatar = $this->set_avatar();

                if ($avatar->has_errors()) {
                    return $avatar;
                }
            }

            $user_meta = array_merge($this->user_meta, self::USER_DEFAULTS);

            foreach ($user_meta as $key => $value) {
                update_user_meta($this->ID, $key, $value);
            }

            return $this;
        }

        /**
         * Uploading user profile picture and set it as a metadata
         *
         * @return \WP_Error
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        private function set_avatar(): WP_Error
        {
            $error = new WP_Error();

            if (is_array($this->avatar) && !empty($this->avatar)) {

                $mimes = [
                    'jpe'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg'  => 'image/jpeg',
                    'png'  => 'image/png'
                ];

                $overrides = [
                    'mimes'     => $mimes,
                    'test_form' => FALSE
                ];

                $upload = wp_handle_upload($this->avatar, $overrides);

                if (isset($upload['error'])) {
                    $error->add('invalid_image', __($upload['error'], 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'file' => $this->avatar ]
                    ]);
                    return $error;
                }

                $image_url  = $upload['url'];
                $upload_dir = wp_upload_dir();
                $image_data = file_get_contents($image_url);
                $filename   = basename($image_url);

                if (wp_mkdir_p($upload_dir['path'])) {
                    $file = $upload_dir['path'] . '/' . $filename;
                } else {
                    $file = $upload_dir['basedir'] . '/' . $filename;
                }

                file_put_contents($file, $image_data);

                $wp_filetype = wp_check_filetype($filename, NULL);
                $attachment  = [
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => sanitize_file_name($filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];

                $attachment_id = wp_insert_attachment($attachment, $file);

                if (is_wp_error($attachment_id)) {
                    return $attachment_id;
                }

                $attach_data = wp_generate_attachment_metadata($attachment_id, $file);
                wp_update_attachment_metadata($attachment_id, $attach_data);

                $this->set_user_meta('avatar_id', $attachment_id);

                $this->avatar = wp_get_attachment_image_url($attachment_id, 'thumbnail');

            } else {
                $this->avatar = B2b_Hooks::PATHS['public']['img'] . '/default-profile.png';
            }

            return $error;
        }

        /**
         * @param string $name
         * @param string $value
         *
         * @return bool
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function set_user_meta(string $name, string $value): bool
        {
            if (array_key_exists($name, $this->user_meta)) {
                $this->user_meta[$name] = $value;

                return TRUE;
            }

            return FALSE;
        }


        /**
         * Description...
         *
         * @param $user_email
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User|\WP_Error|$this
         * @throws \Exception
         */
        public function forgot_password($user_email): B2b_User|WP_Error
        {
            $error = new WP_Error();
            $user  = get_user_by('email', $user_email);

            if ($user) {
                $generate_forgot_data = $this->generate_forgot_password_data($user);

                $email = B2b_Mail::init()
                                 ->to($user->user_email)
                                 ->subject('Forgot Password')
                                 ->template('forgot-password/body', [
                                     'data' => [
                                         'user'      => $user,
                                         'url_query' => $generate_forgot_data['reset_link']
                                     ]
                                 ])
                                 ->send();
            }
            return $this;
        }

        /**
         * Description...
         *
         * @param $user
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        public function generate_forgot_password_data($user): array
        {
            $reset_key = wp_generate_password(20, FALSE);

            $reset_data = [
                'user_id'         => $user->ID,
                'reset_key'       => $reset_key,
                'expiration_time' => current_time('timestamp') + 3600
                // 1 hour
            ];

            $encrypted_data = B2b_Cryptor::Encrypt(serialize($reset_data));


            $reset_link = add_query_arg([
                'user' => $user,
                'key'  => $encrypted_data
            ], site_url('my-account/reset-password'));

            update_user_meta($user->ID, 'reset_password_key', $reset_data);

            return [
                'reset_data' => $reset_data,
                'reset_link' => $reset_link
            ];
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return bool|\WP_Error
         */
        public function change_password(): bool|WP_Error
        {
            $error         = new WP_Error();
            $form_data     = $_POST['data'];
            $user_password = sanitize_text_field($form_data['user_password']);
            $key           = sanitize_text_field($form_data['user_key']);

            if (!is_wp_error(self::check_reset_code($key))) {
                $decrypt_data = B2b_Cryptor::Decrypt($key);
                if ($decrypt_data) {

                    $reset_data = unserialize($decrypt_data);

                    // Change user password
                    wp_set_password($user_password, $reset_data['user_id']);

                    // Remove reset key
                    update_user_meta($reset_data['user_id'], 'reset_password_key', '');

                    return TRUE;

                } else {
                    $error->add('failed_decryption', __("Your reset key is invalid!.", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'key' => $key ]
                    ]);
                    return $error;
                }
            } else {
                $error->add('invalid_key', __("Your reset key is invalid!.", 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'key' => $key ]
                ]);
                return $error;
            }

        }

        /**
         * Description...
         *
         * @param $key
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return bool|\WP_Error
         */
        public static function check_reset_code($key): bool|WP_Error
        {
            $error        = new WP_Error();
            $decrypt_data = B2b_Cryptor::Decrypt($key);

            if ($decrypt_data && is_serialized($decrypt_data)) {
                $reset_data = unserialize($decrypt_data);
                $user       = self::get_user_by('ID', (int)$reset_data['user_id']);

                if (!is_wp_error($user)) {
                    if (is_array($user->user_meta['reset_password_key']) && !empty($user->user_meta['reset_password_key'])) {
                        if ($reset_data['reset_key'] === $user->user_meta['reset_password_key']['reset_key']) {
                            $current_timestamp = time(); // get the current Unix timestamp

                            if ($reset_data['expiration_time'] >= $current_timestamp) {
                                return TRUE;
                            } else {
                                $error->add('expire_date', __("Your reset key is expired.", 'b2b'), [
                                    'status'  => FALSE,
                                    'details' => [ 'time' => $reset_data['expiration_time'] ]
                                ]);
                                return $error;
                            }
                        } else {
                            $error->add('invalid_key', __("Your reset key is invalid!.", 'b2b'), [
                                'status'  => FALSE,
                                'details' => [ 'key' => $reset_data['reset_key'] ]
                            ]);
                            return $error;
                        }
                    } else {
                        $error->add('empty_key', __("Your reset key is invalid!.", 'b2b'), [
                            'status'  => FALSE,
                            'details' => [ 'key' => $reset_data['reset_key'] ]
                        ]);
                        return $error;
                    }
                } else {
                    $error->add('invalid_user', __("Your reset key is invalid!.", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'user' => $reset_data['user_id'] ]
                    ]);
                    return $error;
                }
            } else {
                $error->add('failed_decryption', __("Your reset key is invalid!.", 'b2b'), [
                    'status'  => FALSE,
                    'details' => [ 'key' => $key ]
                ]);
                return $error;
            }
        }

        public static function check_verification_code(array $verification_data): bool|WP_Error
        {
            $error             = new WP_Error();
            $current_timestamp = time(); // get the current Unix timestamp
            if ($verification_data['verification_expire_date'] >= $current_timestamp) {
                if ($verification_data['incoming_code'] === $verification_data['current_code']) {
                    return TRUE;
                } else {
                    $error->add('invalid_key', __("Your reset key is invalid!.", 'b2b'), [
                        'status' => FALSE
                    ]);
                    return $error;
                }
            } else {
                $error->add('expire_date', __("Your reset key is expired.", 'b2b'), [
                    'status' => FALSE
                ]);
                return $error;
            }
        }

        /**
         * Get user as a B2b User object
         *
         * @param \WP_User $user
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User
         */
        public static function get_user(WP_User $user): B2b_User
        {
            $class          = __CLASS__;
            self::$instance = new $class();

            return self::$instance->convert($user);
        }

        /**
         * Description...
         *
         * @param string $field
         * @param string $value
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User
         */
        public static function get_user_by(string $field, string $value): B2b_User|WP_Error
        {
            $error = new WP_Error();
            $user  = get_user_by($field, $value);

            if ($user) {
                return self::get_user($user);
            } else {
                $error->add('invalid_user', __("This user is not exists!.", 'b2b'), [
                    'status'  => FALSE,
                    'details' => [
                        'user'  => $value,
                        'field' => $field
                    ]
                ]);
                return $error;
            }
        }

        /**
         * Converting default WP user object to B2b User object
         *
         * @param \WP_User $user
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \B2B\APP\CLASSES\B2b_User
         */
        private function convert(WP_User $user): B2b_User
        {
            $class    = __CLASS__;
            $new_user = new $class();

            $new_user->ID             = $user->ID;
            $new_user->username       = $user->data->user_login;
            $new_user->password       = $user->data->user_pass;
            $new_user->email          = $user->data->user_email;
            $new_user->first_name     = $this->first_name;
            $new_user->last_name      = $this->last_name;
            $new_user->nickname       = $this->nickname;
            $new_user->display_name   = $user->data->display_name;
            $new_user->role           = $user->roles[0];
            $new_user->status         = $user->data->user_status;
            $new_user->registered     = $user->data->user_registered;
            $new_user->activation_key = $user->data->user_activation_key;

            $new_user->user_meta = array_merge($new_user->user_meta, self::USER_DEFAULTS);

            foreach ($new_user->user_meta as $key => $meta) {
                $new_user->user_meta[$key] = get_user_meta($user->ID, $key, TRUE);
            }

            $new_user->first_name = $new_user->user_meta['first_name'];
            $new_user->last_name  = $new_user->user_meta['last_name'];
            $new_user->nickname   = $new_user->user_meta['nickname'];
            $new_user->avatar     = $new_user->get_avatar();

            if ($new_user->user_meta['profile_id'] && class_exists('B2b_Profile')) {
                $profile_onj       = new B2b_Profile();
                $new_user->profile = $profile_onj->get_by_id((int)$new_user->user_meta['profile_id']);
            }

            return $new_user;
        }

        /**
         * Assign WP_User to B2b_User
         *
         * @param \WP_User $user
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        private function assign(WP_User $user): void
        {
            $this->ID             = $user->ID;
            $this->username       = $user->data->user_login;
            $this->password       = $user->data->user_pass;
            $this->email          = $user->data->user_email;
            $this->display_name   = $user->data->display_name;
            $this->role           = $user->roles[0];
            $this->status         = $user->data->user_status;
            $this->registered     = $user->data->user_registered;
            $this->activation_key = $user->data->user_activation_key;

            $this->user_meta = array_merge($this->user_meta, self::USER_DEFAULTS);

            foreach ($this->user_meta as $key => $meta) {
                $this->user_meta[$key] = get_user_meta($user->ID, $key, TRUE);
            }

            $this->first_name = $this->user_meta['first_name'];
            $this->last_name  = $this->user_meta['last_name'];
            $this->nickname   = $this->user_meta['nickname'];
            $this->avatar     = $this->get_avatar();
        }

        /**
         * Description...
         *
         * @param $avatar
         * @param $id
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        public function override_user_table_avatar($avatar, $id)
        {
            $user          = self::get_user_by('ID', $id);
            $avatar['url'] = $user->avatar;

            return $avatar;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \WP_Error|\static
         */
        protected function login(): B2b_User|WP_Error
        {
            $error         = new WP_Error();
            $form_data     = $_POST['data'];
            $user_login    = sanitize_text_field($form_data['user_login']);
            $user_password = sanitize_text_field($form_data['user_password']);

            $user = get_user_by('login', $user_login);

            if (empty($user)) {
                $user = get_user_by('email', $user_login);
                if (empty($user)) {
                    $error->add('invalid_username', __("Your login credentials is invalid.", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'username' => $user_login ]
                    ]);
                    return $error;
                }
            }

            if (!empty($user)) {
                $this->assign($user);

                $check_pwd = wp_check_password($user_password, $this->password, $this->ID);

                if (!$check_pwd) {
                    $error->add('invalid_password', __("Your login credentials is invalid.", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'password' => $user_password ]
                    ]);
                    return $error;
                }

                $cred = [
                    'user_login'    => $user_login,
                    'user_password' => $user_password
                ];

                if (!empty($form_data['rememberme'])) {
                    $cred['remember'] = $form_data['rememberme'];
                }

                $login = wp_signon($cred);

                if (is_wp_error($login)) {
                    $error->add('invalid_signOn', __($login->get_error_message(), 'b2b'), [
                        'status'  => FALSE,
                        'details' => [
                            'user_login' => $user_login,
                            'password'   => $user_login
                        ]
                    ]);
                    return $error;
                }

                if (!$this->is_confirm()) {
                    $error->add('account_confirmation', __("Your account is pending!, Please check your E-mail/Mobile/WhatsApp to activate your account.", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'email' => $this->user_meta['account_confirmation_status'] ]
                    ]);
                    return $error;
                }

                $profile_id = get_user_meta($login->ID, 'profile_id', TRUE);
                if (!$profile_id) {
                    $error->add('invalid_profile', __("This account is temporary disabled or blocked, Please contact us.", 'b2b'), [
                        'status' => FALSE
                    ]);
                    return $error;
                }
                $profile_obj = new B2b_Profile();
                $profile     = $profile_obj->get_by_id((int)$profile_id);
                if (!isset($profile->taxonomy['industry']) || empty($profile->taxonomy['industry'])) {
                    $error->add('empty_industry', __("You have to use atl east 1 industry", 'b2b'), [
                        'status'  => FALSE,
                        'details' => [ 'industry' => $profile->taxonomy['industry'] ]
                    ]);
                    return $error;
                }
            }

            return $this;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public static function logout()
        {

        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \WP_Error|bool
         */
        public function mobile_verification(): WP_Error|bool
        {
            $error = new WP_Error();

            $error->add('mobile_error', __('NO VERIFICATION', 'b2b'), [
                'status'  => FALSE,
                'details' => [
                    'e' => ''
                ]
            ]);

            return TRUE;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return \WP_Error|bool
         */
        public function whatsapp_verification(): WP_Error|bool
        {
            $error = new WP_Error();

            $error->add('whatsapp_error', __('NO VERIFICATION', 'b2b'), [
                'status'  => FALSE,
                'details' => [
                    'e' => ''
                ]
            ]);

            return TRUE;
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
        public function email_verification(): bool
        {
            $randomNumber = mt_rand(1000, 9999);

            update_user_meta($this->ID, 'verification_key', $randomNumber);
            update_user_meta($this->ID, 'verification_expire_date', current_time('timestamp') + 300);

            $email = B2b_Mail::init()
                             ->to($this->email)
                             ->subject('Welcome to B2b - Please Verify Your Email')
                             ->template('account-verification/body', [
                                 'data' => [
                                     'user'   => $this,
                                     'digits' => $randomNumber
                                 ]
                             ])
                             ->send();
            return $email;
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return string
         */
        private function get_avatar(): string
        {
            $url = wp_get_attachment_image_url($this->user_meta['avatar_id'], 'thumbnail');
            return empty($url) ? B2b_Hooks::PATHS['public']['img'] . '/default-profile.webp' : $url;
        }

        /**
         * Checking if user is confirmed his e-mail or not
         *
         * @param $user
         *
         * @return bool
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        private function is_confirm(): bool
        {
            if (empty($this->user_meta['account_confirmation_status']) || !boolval($this->user_meta['account_confirmation_status'])) {
                return FALSE;
            }

            return TRUE;
        }
    }
