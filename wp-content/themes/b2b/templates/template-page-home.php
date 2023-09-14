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
     * @package b2b
     * @since 1.0
     *
     */


    use B2B\APP\MODELS\FRONT\MODULES\B2b_Partner;
    use B2B\APP\MODELS\FRONT\MODULES\B2b_Testimonial;

    get_header();
?>

    <main id="" class="site-home">
        <h1>HOME PAGE</h1>

        <h1>Our Partners</h1>
        <?php
            $partners_obj = new B2b_Partner();
            $partners = $partners_obj->get_all();
            foreach ($partners as $single) {
                echo $single->thumbnail;
            }
        ?>

        <h1>Testimonials</h1>
        <?php
            $testimonials_obj = new B2b_Testimonial();
            $testimonials = $testimonials_obj->get_all();
            foreach ($testimonials as $single) {
                echo $single->title;
                echo $single->thumbnail;
                echo $single->content;
            }
        ?>
    </main><!-- #main -->

<?php get_footer();

