<?php
/**
 * @Filename: search.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/27/2023
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'my-2 py-2 border-bottom' ); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				nh_posted_on();
				nh_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->
