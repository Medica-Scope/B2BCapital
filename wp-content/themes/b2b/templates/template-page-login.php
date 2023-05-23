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

    <main id="primary" class="">
        <?php
            echo B2b_Forms::get_instance()
                          ->create_form([
                              'user_login'    => [
                                  'class'       => '',
                                  'type'        => 'text',
                                  'label'       => __('Email Address', 'b2b'),
                                  'name'        => 'user_login',
                                  'required'    => TRUE,
                                  'placeholder' => __('Ex. username Or email@gmail.com', 'b2b'),
                                  // 'hint'        => __("Lorem ipsum dolor sit amet.", 'b2b'),
                                  'before'      => "<h3 class='page-head'><?= __('Forget Password', 'b2b') ?></h3>",
                                  'after'       => '',
                                  'order'       => 0,
                              ],
                              'user_password' => [
                                  'class'       => '',
                                  'type'        => 'password',
                                  'label'       => __('Password', 'b2b'),
                                  'name'        => 'user_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Password', 'b2b'),
                                  // 'hint'        => __('Lorem ipsum dolor sit amet.', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                  'after'       => '<a href="' . get_permalink(get_page_by_path('my-account')) . '/forgot-password" class="main-color"> ' . __('Forget Password', 'b2b') . ' </a>',
                                  'order'       => 10,
                              ],
                              'login_nonce'   => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'login_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_login_form",
                                  'order' => 15
                              ],
                              'submit'        => [
                                  'class'  => '',
                                  'type'   => 'submit',
                                  'value'  => __('Login', 'b2b'),
                                  'before' => '',
                                  'after'  => '',
                                  'order'  => 20
                              ]
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-login-form',
                              'id'    => B2b::_DOMAIN_NAME . '_login_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

