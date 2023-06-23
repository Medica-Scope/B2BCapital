<?php
    /**
     * @Filename: template-page-login.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Login Page
     * Template Post Type: page
     *
     * @package b2b
     * @since 1.0
     *
     */

    use B2B\APP\HELPERS\B2b_Forms;
    use B2B\B2b;

    get_header();
?>

    <main id="" class="">
        <?php
            echo do_shortcode('[nextend_social_login]');
            echo B2b_Forms::get_instance()
                          ->create_form([
                              'custom-html-1' => [
                                  'type'    => 'html',
                                  'content' => '<div class="row">',
                                  'order'   => 0,
                              ],
                              'user_login'    => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Phone Number or Email', 'b2b'),
                                  'name'        => 'user_login',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter you phone or email', 'b2b'),
                                  'order'       => 5,
                              ],
                              'user_password' => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Password', 'b2b'),
                                  'name'        => 'user_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter you password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 10,
                              ],
                              'rememberme'    => [
                                  'class'   => 'col-6',
                                  'type'    => 'checkbox',
                                  'choices' => [
                                      [
                                          'class' => '',
                                          'label' => 'Remember me',
                                          'name'  => 'rememberme',
                                          'value' => '1',
                                          'order' => 0,
                                      ]
                                  ],
                                  'order'   => 15,
                              ],
                              'custom-html-3' => [
                                  'type'    => 'html',
                                  'content' => '<div class="form-group col-6" ><a href="' . get_permalink(get_page_by_path('my-account')) . 'forgot-password" class="main-color"> ' . __('Forget Password', 'b2b') . ' </a></div></div>',
                                  'order'   => 20,
                              ],
                              'login_nonce'   => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'login_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_login_form",
                                  'order' => 25
                              ],
                              'submit'        => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'value'               => __('Login', 'b2b'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_login',
                                  'order'               => 25
                              ],
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-login-form',
                              'id'    => B2b::_DOMAIN_NAME . '_login_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

