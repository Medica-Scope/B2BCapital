<?php
    /**
     * The header for our theme
     *
     * This is the template that displays all of the <head> section and everything up until <div id="content">
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package NinjaHub
     */

    use NH\Nh;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <?php wp_body_open(); ?>

        <div id="page" class="site">

            <?php
                $landing = [
                    'contact-us',
                    'about'
                ];

                $dashboard = [
                    'my-account',
                    'dashboard',
                    'create-opportunity'
                ];

                $my_account = [

                    'login',
                    'industry',
                    'reset-password',
                    'forgot-password',
                    'registration',
                    'verification',
                    'authentication',
                ];

                if (is_front_page() || is_page($landing) || is_post_type_archive('service') || is_singular('service')) {
                    get_template_part('app/Views/headers/landing');
                } elseif (is_page($dashboard)) {
                    get_template_part('app/Views/headers/dashboard');
                } elseif (is_page($my_account)) {
                    get_template_part('app/Views/headers/my-account');
                } else {
                    // TODO:: Will be used for Blogs later..
                    get_template_part('app/Views/headers/default');
                }
            ?>
