<?php

/**
 * @Filename: blogs.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\CLASSES\Nh_Post;

global $wp_query,$post;
$queried_post_type = $wp_query->query;
$post_obj = new Nh_Post();
$single_post = $post_obj->convert($post);
?>
<a class="blog-item" href="<?= $single_post->link ?>">
    <div class="img">
        <img src="<?= $single_post->thumbnail ?>" alt="B2B" />
        <span class="dots"></span>
    </div>
    <div class="date">
        <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B"/>
        <p><?= _e('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
    </div>
    <div class="short-description">
        <?= $single_post->excerpt ?>
    </div>
</a>