<?php
    /**
     * @Filename: single-service.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
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
