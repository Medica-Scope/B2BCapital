<?php
    /**
     * @Filename: template-page-reset-password.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Reset Password Page
     * Template Post Type: page
     *
     * @package b2b
     * @since 1.0
     *
     */

    use B2B\APP\CLASSES\B2b_User;
    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="">
        <?php
            if (isset($_GET['key'])) {
                $key = sanitize_text_field($_GET['key']);

                $validate = B2b_User::check_reset_code($key);

                if (!is_wp_error($validate)) {
                    echo B2b_Forms::get_instance()
                                  ->create_form([
                                      'user_password'         => [
                                          'class'       => '',
                                          'type'        => 'password',
                                          'label'       => __('Password', 'b2b'),
                                          'name'        => 'user_password',
                                          'required'    => TRUE,
                                          'placeholder' => __('Your Password', 'b2b'),
                                          'hint'        => __("Password should contain at least 1 special character", 'b2b'),
                                          'before'      => "<h3 class='page-head'><?= __('Reset Password, 'b2b') ?></h3>",
                                          'after'       => '<i class="fa fa-eye showPassIcon resetCustom" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                          'order'       => 0,
                                      ],
                                      'user_password_confirm' => [
                                          'class'       => '',
                                          'type'        => 'password',
                                          'label'       => __('Confirm Password', 'b2b'),
                                          'name'        => 'user_password_confirm',
                                          'required'    => TRUE,
                                          'placeholder' => __('Confirm Your Password', 'b2b'),
                                          'hint'        => __("Password should contain at least 1 special character", 'b2b'),
                                          'before'      => '',
                                          'after'       => '<i class="fa fa-eye showPassIcon reset" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password_confirm"></i>',
                                          'order'       => 10,
                                      ],
                                      'user_key'              => [
                                          'class'    => '',
                                          'type'     => 'hidden',
                                          'name'     => 'user_key',
                                          'required' => TRUE,
                                          'value'    => $key,
                                          'order'    => 15,
                                      ],
                                      'forgot_nonce'          => [
                                          'class' => '',
                                          'type'  => 'nonce',
                                          'name'  => 'change_password_nonce',
                                          'value' => B2b::_DOMAIN_NAME . "_change_password_form",
                                          'order' => 15
                                      ],
                                      'submit'                => [
                                          'class'               => 'btn',
                                          'type'                => 'submit',
                                          'value'               => __('Reset Password', 'b2b'),
                                          'before'              => '',
                                          'after'               => '',
                                          'recaptcha_form_name' => 'frontend_reset_password',
                                          'order'               => 20
                                      ]
                                  ], [
                                      'class' => B2b::_DOMAIN_NAME . '-change-password-form',
                                      'id'    => B2b::_DOMAIN_NAME . '_change_password_form'
                                  ]);

                } else {
                    ?>
                    <p>
                        <?= $validate->get_error_message() ?>,
                                                             please follow the link <a href="<?= get_permalink(get_page_by_path('my-account/forgot-password')) ?>">Reset
                                                                                                                                                                   Password</a>
                                                             to get the new code
                    </p>

                    <?php
                }

            } else {
                // Set the HTTP status code to 404
                status_header(404);

                // Load the 404 template
                get_template_part('404');
            }
        ?>
    </main><!-- #main -->

<?php get_footer();

