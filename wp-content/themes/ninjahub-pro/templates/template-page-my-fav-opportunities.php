<?php
    /**
     * @Filename: template-my-fav-opportunities.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: My Favorite Opportunities Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\CLASSES\Nh_User;

    get_header();
?>

    <main id="" class="">
        <div class="container">
        <nav>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"><?= __('My Account', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja'); ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-widgets'))) ?>"><?= __('Widgets', 'ninja') ?></a>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"><?= __('Notifications', 'ninja') ?></a>
        </nav>
            <nav>
                <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"><?= sprintf(__('My %s', 'ninja'), Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja')); ?></a>
                <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-favorite-opportunities'))) ?>"><?= sprintf(__('My Favorite %s', 'ninja'), Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja')) ?></a>
            </nav>
        </div>
    </main><!-- #main -->

<?php get_footer();

