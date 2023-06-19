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

    get_header();
    $user_obj     = new B2b_User();
    $user         = $user_obj::get_current_user();
?>

    <main id="" class="">

    </main><!-- #main -->

<?php get_footer();
