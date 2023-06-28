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
    use B2B\APP\MODELS\FRONT\B2b_Public;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Blog;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Opportunity;
    use B2B\B2b;

    get_header();
    $user_obj     = new B2b_User();
    $user         = $user_obj::get_current_user();
?>

    <main id="" class="">
        <h1>MY ACCOUNT</h1>
        <?php
            $form_fields = [
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
                    'value'        => $user->first_name,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your first name', 'b2b'),
                    'order'       => 5,
                ],
                'last_name'          => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Last name', 'b2b'),
                    'name'        => 'last_name',
                    'value'        => $user->last_name,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your last name', 'b2b'),
                    'order'       => 10,
                ],
                'phone_number'       => [
                    'class'       => 'col-6',
                    'type'        => 'text',
                    'label'       => __('Phone number', 'b2b'),
                    'name'        => 'phone_number',
                    'value'        => $user->user_meta['phone_number'],
                    'required'    => TRUE,
                    'placeholder' => __('Enter your phone number', 'b2b'),
                    'order'       => 15,
                ],
                'user_email'         => [
                    'class'       => 'col-6',
                    'type'        => 'email',
                    'label'       => __('Email', 'b2b'),
                    'name'        => 'user_email',
                    'value'        => $user->email,
                    'required'    => TRUE,
                    'placeholder' => __('Enter your email', 'b2b'),
                    'order'       => 20,
                ],
                'site_language'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Profile language', 'b2b'),
                    'name'        => 'site_language',
                    'placeholder' => __('Select your language', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => [$user->user_meta['site_language']],
                    'before'      => '',
                    'order'       => 30,
                ],
                'widget_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Widget list categories', 'b2b'),
                    'name'        => 'widget_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your widget', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['widget_list'],
                    'before'      => '',
                    'order'       => 30,
                ],
                'preferred_opportunities_cat_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('Preferred categories list for opportunities', 'b2b'),
                    'name'        => 'preferred_opportunities_cat_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your preferred', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['preferred_opportunities_cat_list'],
                    'before'      => '',
                    'order'       => 30,
                ],
                'preferred_articles_cat_list'   => [
                    'class'       => 'col-6',
                    'type'        => 'select',
                    'label'       => __('preferred categories list for articles', 'b2b'),
                    'name'        => 'preferred_articles_cat_list',
                    'multiple'    => 'multiple',
                    'placeholder' => __('Select your preferred', 'b2b'),
                    'options'        => [],
                    'default_option' => '',
                    'select_option'  => $user->profile->meta_data['preferred_articles_cat_list'],
                    'before'      => '',
                    'order'       => 30,
                ],
                'custom-html-3'      => [
                    'type'    => 'html',
                    'content' => '</div>',
                    'order'   => 45,
                ],
                'edit_profile_nonce' => [
                    'class' => '',
                    'type'  => 'nonce',
                    'name'  => 'edit_profile_nonce',
                    'value' => B2b::_DOMAIN_NAME . "_edit_profile_form",
                    'order' => 50
                ],
                'submit'             => [
                    'class'               => '',
                    'type'                => 'submit',
                    'id'                => B2b::_DOMAIN_NAME . '_edit_profile_submit',
                    'value'               => __('Save', 'b2b'),
                    'before'              => '',
                    'after'               => '',
                    'recaptcha_form_name' => 'frontend_edit_profile',
                    'order'               => 55
                ],
            ];
            $form_tags   = [
                'class' => B2b::_DOMAIN_NAME . '-edit-profile-form',
                'id'    => B2b::_DOMAIN_NAME . '_edit_profile_form'
            ];

            $languages = B2b_Public::get_available_languages();

            foreach ($languages as $lang) {
                $form_fields['site_language']['options'][$lang['code']] = $lang['name'];
            }

            $opportunities_obj = new B2b_Opportunity();
            $opportunities_tax_terms = $opportunities_obj->get_taxonomy_terms('opportunity-category');

            foreach ($opportunities_tax_terms as $key => $term) {
                $form_fields['preferred_opportunities_cat_list']['options'][$term->term_id] = $term->name;
            }

            $blogs_obj = new B2b_Blog();
            $blogs_obj_tax_terms = $opportunities_obj->get_taxonomy_terms('category');

            foreach ($blogs_obj_tax_terms as $key => $term) {
                $form_fields['preferred_articles_cat_list']['options'][$term->term_id] = $term->name;
            }

            echo B2b_Forms::get_instance()
                          ->create_form($form_fields, $form_tags);

        ?>

        <?php
            echo B2b_Forms::get_instance()
                          ->create_form([
                              'current_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Current password', 'b2b'),
                                  'name'        => 'current_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your current password', 'b2b'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_current_password"></i>',
                                  'order'       => 25,
                              ],
                              'new_password'      => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('New password', 'b2b'),
                                  'name'        => 'new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Enter your new password', 'b2b'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_new_password"></i>',
                                  'order'       => 25,
                              ],
                              'confirm_new_password'   => [
                                  'class'       => 'col-6',
                                  'type'        => 'password',
                                  'label'       => __('Confirm new password', 'b2b'),
                                  'name'        => 'confirm_new_password',
                                  'required'    => TRUE,
                                  'placeholder' => __('Re-enter your new password', 'b2b'),
                                  'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . B2b::_DOMAIN_NAME . '_confirm_new_password"></i>',
                                  'order'       => 30,
                              ],
                              'edit_password_nonce' => [
                                  'class' => '',
                                  'type'  => 'nonce',
                                  'name'  => 'edit_password_nonce',
                                  'value' => B2b::_DOMAIN_NAME . "_edit_password_form",
                                  'order' => 50
                              ],
                              'submit'             => [
                                  'class'               => '',
                                  'type'                => 'submit',
                                  'id'                => B2b::_DOMAIN_NAME . '_edit_password_submit',
                                  'value'               => __('Save', 'b2b'),
                                  'before'              => '',
                                  'after'               => '',
                                  'recaptcha_form_name' => 'frontend_edit_profile',
                                  'order'               => 55
                              ],
                          ], [
                              'class' => B2b::_DOMAIN_NAME . '-edit-password-form',
                              'id'    => B2b::_DOMAIN_NAME . '_edit_password_form'
                          ]);
        ?>
    </main><!-- #main -->

<?php get_footer();
