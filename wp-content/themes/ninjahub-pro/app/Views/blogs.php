<?php

/**
 * @Filename: blogs.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\CLASSES\Nh_Post;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;

global $wp_query,$post,$user_ID;
$queried_post_type = $wp_query->query;
$post_obj = new Nh_Blog();
$single_post = $post_obj->convert($post);
$fav_chk = $post_obj->is_post_in_user_favorites($single_post->ID, $user_ID);
$ignore_chk = $post_obj->is_post_in_user_ignored_articles($single_post->ID, $user_ID);
// href="<?= $single_post->link 
?>
<a class="blog-item" >
    <div class="img">
        <img src="<?= $single_post->thumbnail ?>" alt="B2B" />
        <span class="dots"></span>
    </div>
    <?php if(!empty($user_ID)): ?>    
    <div class="ninja-fav-con">

        <button class="ninja-add-to-fav btn <?= ($fav_chk)? 'btn-dark':'' ?>" id="addToFav" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>" data-type="<?= $single_post->type ?>" type="button">FAV</button> 
    </div>
    <?php endif;?>
    <?php if(!empty($user_ID)): ?>    
    <div class="ninja-ignore-con">

        <button class="ninja-add-to-ignore btn <?= ($ignore_chk)? 'btn-outline-dark':'' ?>" id="addToIgnore" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>" data-type="<?= $single_post->type ?>" type="button">X</button> 
    </div>
    <?php endif;?>
    <div class="date">
        <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B"/>
        <p><?= _e('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
    </div>
    <div class="short-description">
        <?= $single_post->excerpt ?>
    </div>
</a>