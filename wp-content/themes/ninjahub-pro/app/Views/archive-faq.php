<?php

    /**
     * @Filename: archive-faq.php
     * @Description:
     * @User: Ahmed Gamal
     * @Date: 9/21/2023
     */

    use NH\APP\CLASSES\Nh_Post;

    global $wp_query, $post;
    $queried_post_type = $wp_query->query;
    $post_obj          = new Nh_Post();
    $single_post       = $post_obj->convert($post);
?>

<div class="faq-item">
    <h3 class="title"><?= $single_post->title ?></h3>
    <div class="content">
        <?= $single_post->content ?>
    </div>
</div>