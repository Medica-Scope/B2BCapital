<?php
    /**
     * @Filename: template-page-myaccount.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Account Page
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
    $user_obj     = new B2b_User();
    $user         = $user_obj::get_current_user();
?>

    <main id="" class="">
        <h1>MY ACCOUNT</h1>
        <?php
            echo B2b_Forms::get_instance()
                          ->create_form([
                              'custom-html-1'      => [
                                  'type'    => 'html',
                                  'content' => '<div class="row">',
                                  'order'   => 0,
                              ],
                              'first_name'         => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('First name', 'b2b'),
                                  'name'        => 'first_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your first name', 'b2b'),
                                  'order'       => 5,
                              ],
                              'last_name'          => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Last name', 'b2b'),
                                  'name'        => 'last_name',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your last name', 'b2b'),
                                  'order'       => 10,
                              ],
                              'phone_number'       => [
                                  'class'       => 'col-6',
                                  'type'        => 'text',
                                  'label'       => __('Phone number', 'b2b'),
                                  'name'        => 'phone_number',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your phone number', 'b2b'),
                                  'order'       => 15,
                              ],
                              'user_email'         => [
                                  'class'       => 'col-6',
                                  'type'        => 'email',
                                  'label'       => __('Email', 'b2b'),
                                  'name'        => 'user_email',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your email', 'b2b'),
                                  'order'       => 20,
                              ],
                              'current_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Current password', 'b2b'),
                                  'name'        => 'current_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your current password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 25,
                              ],
                              'new_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('New password', 'b2b'),
                                  'name'        => 'new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your new password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_user_password"></i>',
                                  'order'       => 25,
                              ],
                              'confirm_new_password'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Confirm new password', 'b2b'),
                                  'name'        => 'confirm_new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Re-enter your new password', 'b2b'),
                                  'before'      => '<i class="fa fa-eye showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_confirm_password"></i>',
                                  'order'       => 30,
                              ],
                              'profile_language'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'select',
                                  'label'       => __('Profile language', 'b2b'),
                                  'name'        => 'profile_language',
                                  'required'    => TRUE,
                                  'placeholder' => __('Select your language', 'b2b'),
                                  'options'        => [
                                      'en'    => __('English', 'b2b'),
                                      'ar'   => __('Arabic', 'b2b')
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'before'      => '',
                                  'order'       => 30,
                              ],
                              'widget_list'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'select',
                                  'label'       => __('Widget list categories', 'b2b'),
                                  'name'        => 'widget_list',
                                  'required'    => TRUE,
                                  'multiple'    => TRUE,
                                  'placeholder' => __('Select your widgets', 'b2b'),
                                  'options'        => [
                                      '0'    => __('one', 'b2b'),
                                      '1'   => __('two', 'b2b')
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'before'      => '',
                                  'order'       => 30,
                              ],
                              'preferred_opportunities_cat_list'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'select',
                                  'label'       => __('Preferred categories list for opportunities', 'b2b'),
                                  'name'        => 'preferred_opportunities_cat_list',
                                  'required'    => TRUE,
                                  'multiple'    => TRUE,
                                  'placeholder' => __('Select your preferred', 'b2b'),
                                  'options'        => [
                                      '0'    => __('one', 'b2b'),
                                      '1'   => __('two', 'b2b')
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'before'      => '',
                                  'order'       => 30,
                              ],
                              'preferred_articles_cat_list'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'select',
                                  'label'       => __('preferred categories list for articles', 'b2b'),
                                  'name'        => 'preferred_articles_cat_list',
                                  'required'    => TRUE,
                                  'multiple'    => TRUE,
                                  'placeholder' => __('Select your preferred', 'b2b'),
                                  'options'        => [
                                      '0'    => __('one', 'b2b'),
                                      '1'   => __('two', 'b2b')
                                  ],
                                  'default_option' => '',
                                  'select_option'  => '',
                                  'before'      => '',
                                  'order'       => 30,
                              ],
                              'custom-html-3'      => [
                                  'type'    => 'html',
                                  'content' => '</div>',
                                  'order'   => 45,
                              ],
                              'profile_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'profile_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_profile_form",
                                  'order' => 50
                              ],
                              'submit'             => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'value'               => __('Save', 'b2b'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_edit_profile',
                                  'order'               => 55
                              ],
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-profile-form',
                              'id'    => B2b::_DOMAIN_NAME . '_profile_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();
