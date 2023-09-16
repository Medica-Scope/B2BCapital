<?php
    /**
     * @Filename: template-page-home.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: Home Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Partner;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Testimonial;
    use NH\Nh;

    get_header();

    $hooks = new Nh_Hooks();
//    $hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-theme', Nh_Hooks::PATHS['public']['css'] . '/theme');
    wp_enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home', Nh_Hooks::PATHS['public']['css'] . '/pages/home', [], '', '');
//    $hooks->add_style(Nh::_DOMAIN_NAME . '-public-style-home', Nh_Hooks::PATHS['public']['css'] . '/pages/home');

?>

    <main id="" class="site-home">
        <h1>HOME PAGE</h1>

        <h1>Our Partners</h1>
        <?php
            $partners_obj = new Nh_Partner();
            $partners = $partners_obj->get_all();
            foreach ($partners as $single) {
                echo $single->thumbnail;
            }
        ?>

        <h1>Testimonials</h1>
        <?php
            $testimonials_obj = new Nh_Testimonial();
            $testimonials = $testimonials_obj->get_all();
            foreach ($testimonials as $single) {
                echo $single->title;
                echo $single->thumbnail;
                echo $single->content;
            }
        ?>
    </main><!-- #main -->

<?php get_footer();

