<?php

/**
 * @Filename: blogs.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */
global $wp_query;
$queried_post_type = $wp_query->query;
?>
<a class="blog-item" href="<?= the_permalink() ?>">
    <div class="img">
        <img src="<?= the_post_thumbnail_url() ?>" alt="B2B" />
        <span class="dots"></span>
    </div>
    <div class="date">
        <img src="<?= get_avatar_url(the_author_meta('id')) ?>"/>
        <p><?= _e('on', 'ninja') ?> <?= get_the_date('F d, Y') ?></p>
    </div>
    <div class="content">
        <?= the_excerpt() ?>
    </div>
</a>