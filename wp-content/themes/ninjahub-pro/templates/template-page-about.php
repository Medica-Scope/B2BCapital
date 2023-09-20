<?php
    /**
     * @Filename: template-page-about.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     *
     * Template Name: About Page
     * Template Post Type: page
     *
     * @package NinjaHub
     * @since 1.0
     *
     */


    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );

?>

    </div> <!-- </layout> -->
    </main>
    </div> <!-- </landing-page> -->

<?php get_footer();

