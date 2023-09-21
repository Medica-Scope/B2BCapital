<?php
    /**
     * @Filename: archive-faq.php
     * @Description:
     * @User: Ahmed Gamal
     * @Date: 9/21/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style( Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home' );
?>
<div class="faq-item">
        <?= get_the_title(); ?>
</div>
    </div> <!-- </layout> -->
    </main>
    </div> <!-- </landing-page> -->

<?php get_footer();