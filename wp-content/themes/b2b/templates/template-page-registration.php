<?php
    /**
     * @Filename: template-page-registration.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Registration Page
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
                              'custom-html-1'     => [
                                  'type'    => 'html',
                                  'content' => '<div class="row">',
                                  'order'   => 0,
                              ],
                              'first_name'        => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('First Name', 'b2b'),
                                  'name'        => 'first_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your first name', 'b2b'),
                                  'order'       => 5,
                              ],
                              'last_name'         => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Last Name', 'b2b'),
                                  'name'        => 'last_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your last name', 'b2b'),
                                  'order'       => 10,
                              ],
                              'phone_number'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Phone Number', 'b2b'),
                                  'name'        => 'phone_number',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your phone number', 'b2b'),
                                  'order'       => 15,
                              ],
                              'user_email'        => [
                                  'class'       => 'col-6',
                                  'type'        => 'email',
                                  'label'       => __('Email', 'b2b'),
                                  'name'        => 'user_email',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your email', 'b2b'),
                                  'order'       => 20,
                              ],
                              'user_password'     => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Password', 'b2b'),
                                  'name'        => 'user_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 25,
                              ],
                              'confirm_password'  => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Confirm Password', 'b2b'),
                                  'name'        => 'confirm_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your confirm password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_confirm_password"></i>',
                                  'order'       => 30,
                              ],
                              'user_type'         => [
                                  'type'           => 'select',
                                  'label'          => __('User Type', 'b2b'),
                                  'name'           => 'user_type',
                                  'required'       => TRUE,
                                  'placeholder'    => __('Enter your user type', 'b2b'),
                                  'options'        => [
                                      'owner'    => __('I am Owner', 'b2b'),
                                      'investor' => __('I am Investor', 'b2b'),
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'class'          => 'col-6',
                                  'order'          => 35,
                              ],
                              'verification_type' => [
                                  'type'           => 'select',
                                  'label'          => __('Account Verification Type', 'b2b'),
                                  'name'           => 'verification_type',
                                  'required'       => TRUE,
                                  'placeholder'    => __('Enter your verification type', 'b2b'),
                                  'options'        => [
                                      'email'    => __('Email', 'b2b'),
                                      'mobile'   => __('Phone Number', 'b2b'),
                                      'whatsapp' => __('Whatsapp', 'b2b'),
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'class'          => 'col-6',
                                  'order'          => 40,
                              ],
                              'custom-html-3'     => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 45,
                              ],
                              'registration_nonce'    => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'registration_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_registration_form",
                                  'order' => 50
                              ],
                              'submit'            => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'value'               => __('Create Account', 'b2b'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_register',
                                  'order'               => 55
                              ],
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-registration-form',
                              'id'    => B2b::_DOMAIN_NAME . '_registration_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();

