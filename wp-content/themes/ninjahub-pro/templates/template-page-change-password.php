<?php
    /**
     * @Filename: template-page-change-password.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Change Password Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */

    use NH\APP\CLASSES\Nh_User;
    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\Nh;

    get_header();
    $user_obj = new Nh_User();
    $user     = $user_obj::get_current_user();
?>

    <main id="" class="">
        <div class="container">
        <h1>MY ACCOUNT</h1>

        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"><?= __('My Account', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja'); ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-widgets'))) ?>"><?= __('My Widgets', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"><?= __('My Notifications', 'ninja') ?></a>
        </nav>
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"><?= __('Profile', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/change-password'))) ?>"><?= __('Password', 'ninja') ?></a>
        </nav>

        <?php
            echo Nh_Forms::get_instance()
                         ->create_form([
                             'current_password'     => [
                                 'class'       => 'col-6',
                                 'type'        => 'password',
                                 'label'       => __('Current password', 'ninja'),
                                 'name'        => 'current_password',
                                 'required'    => TRUE,
                                 'placeholder' => __('Enter your current password', 'ninja'),
                                 'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_current_password"></i>',
                                 'order'       => 5,
                             ],
                             'new_password'         => [
                                 'class'       => 'col-6',
                                 'type'        => 'password',
                                 'label'       => __('New password', 'ninja'),
                                 'name'        => 'new_password',
                                 'required'    => TRUE,
                                 'placeholder' => __('Enter your new password', 'ninja'),
                                 'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_new_password"></i>',
                                 'order'       => 10,
                             ],
                             'confirm_new_password' => [
                                 'class'       => 'col-6',
                                 'type'        => 'password',
                                 'label'       => __('Confirm new password', 'ninja'),
                                 'name'        => 'confirm_new_password',
                                 'required'    => TRUE,
                                 'placeholder' => __('Re-enter your new password', 'ninja'),
                                 'before'      => '<i class="fa-sharp fa-solid fa-eye-slash showPassIcon" data-target ="#' . Nh::_DOMAIN_NAME . '_confirm_new_password"></i>',
                                 'order'       => 15,
                             ],
                             'edit_password_nonce'  => [
                                 'class' => '',
                                 'type'  => 'nonce',
                                 'name'  => 'edit_password_nonce',
                                 'value' => Nh::_DOMAIN_NAME . "_edit_password_form",
                                 'order' => 20
                             ],
                             'submit'               => [
                                 'class'               => '',
                                 'type'                => 'submit',
                                 'id'                  => Nh::_DOMAIN_NAME . '_edit_password_submit',
                                 'value'               => __('Save', 'ninja'),
                                 'before'              => '',
                                 'after'               => '',
                                 'recaptcha_form_name' => 'frontend_edit_profile',
                                 'order'               => 25
                             ],
                         ], [
                             'class' => Nh::_DOMAIN_NAME . '-edit-password-form',
                             'id'    => Nh::_DOMAIN_NAME . '_edit_password_form'
                         ]);
        ?>
        </div>
    </main><!-- #main -->

<?php get_footer();
