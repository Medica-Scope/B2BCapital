<?php
    /**
     * The template for displaying the footer
     *
     * Contains the closing of the #content div and all content after.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package b2b
     */

    use B2B\B2b;

?>

<footer class="site-top-footer">
    <div class="top-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <img src="<?= B2b::get_site_logo() ?>" alt="B2b Logo">
                    <div class="social-links">
                        <a href="<?= B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_in'] ?>">LinkedIn</a>
                        <a href="<?= B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_fb'] ?>">Facebook</a>
                        <a href="<?= B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_ig'] ?>">Instagram</a>
                        <a href="<?= B2B_CONFIGURATION['social'][B2b::_DOMAIN_NAME . '_social_tw'] ?>">Twitter</a>
                    </div>
                </div>
                <div class="col-2"><?= __('Articles', 'b2b') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2"><?= __('As Investor', 'b2b') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2"><?= __('As Owner', 'b2b') ?>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Icons</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li><a href="#">Interface icons</a></li>
                        <li><a href="#">Animated icons</a></li>
                        <li><a href="#">Icon tags</a></li>
                    </ul>
                </div>
                <div class="col-2">
                    <?= __('Reach US', 'b2b') ?>
                    <a href="javascript:(0);"><?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_address_en'] ?></a>
                    <a href="mailto:<?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_email'] ?>"><?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_email'] ?></a>
                    <a href="tel:<?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_phone'] ?>"><?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_phone'] ?></a>
                    <a href="tel:<?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_mobile'] ?>"><?= B2B_CONFIGURATION['contact'][B2b::_DOMAIN_NAME . '_contact_mobile'] ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-footer">
        <div class="container-fluid">
            <div class="row">
            <div class="site-info col-6">
                <p><?= __('Copyright © 2023 B2B All rights reserved') ?></p>
            </div><!-- .site-info -->

            <div class="bottom-footer-menu col-6">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'bottom-footer-menu',
                        'menu_id'        => 'bottom-footer',
                    ]);
                ?>
            </div>
            </div>
        </div>
    </div>


</footer>

<?php wp_body_close(); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
