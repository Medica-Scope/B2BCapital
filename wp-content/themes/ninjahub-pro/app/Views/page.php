<?php
    /**
     * @Filename: page.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */
?>
<div class="container container-xxl">
    <div class="golobal-page-content">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <?php nh_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
            the_content();

            wp_link_pages([
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'ninja'),
                    'after'  => '</div>',
                ]);
        ?>
    </div><!-- .entry-content -->

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <?php
                edit_post_link(sprintf(wp_kses(/* translators: %s: Name of current post. Only visible to screen readers */ __('Edit <span class="screen-reader-text">%s</span>', 'ninja'), [
                                'span' => [
                                    'class' => [],
                                ],
                            ]), wp_kses_post(get_the_title())), '<span class="edit-link">', '</span>');
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
</div>
</div>