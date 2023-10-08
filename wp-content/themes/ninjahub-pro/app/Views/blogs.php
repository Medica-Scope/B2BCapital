<?php

    /**
     * @Filename: blogs.php
     * @Description:
     * @User: Ahmed Gamal
     * @Date: 9/21/2023
     */

    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;

    global $wp_query, $post, $user_ID;

    // href="<?= $single_post->link
    $single_post = $args['post'];
    $fav_chk     = (isset($args['fav_chk'])) ? $args['fav_chk'] : '';
    $ignore_chk  = (isset($args['ignore_chk'])) ? $args['ignore_chk'] : '';
    $opportunity = (isset($args['opportunity'])) ? $args['opportunity'] : '';
?>
<div class="blog-item">

    <a href="<?= $single_post->link ?>" class="img">
        <img src="<?= $single_post->thumbnail ?>" alt="B2B"/>
        <span class="dots"></span>
    </a>


    <?php if (!empty($user_ID)): ?>
        <div class="ninja-fav-con">
            <button class="ninja-add-to-fav btn <?= ($fav_chk) ? 'btn-dark' : '' ?>" id="addToFav" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>"
                    data-type="<?= $single_post->type ?>" type="button">FAV
            </button>
        </div>
    <?php endif; ?>


    <?php if (!empty($user_ID)): ?>
        <div class="ninja-ignore-con">
            <button class="ninja-add-to-ignore btn <?= ($ignore_chk) ? 'btn-outline-dark' : '' ?>" id="addToIgnore" data-uID="<?= $user_ID ?>" data-id="<?= $single_post->ID ?>"
                    data-type="<?= $single_post->type ?>" type="button">X
            </button>
        </div>
    <?php endif; ?>


    <div class="title">
        <a href="<?= $single_post->link ?>"><?= $single_post->title ?></a>
    </div>


    <?php if (!empty($single_post->taxonomy['category'])): ?>
        <div class="category">
            <?= $single_post->taxonomy['category'][0]->name ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($opportunity)): ?>
        <div class="opportunity">
            <a href="<?= $opportunity->link ?>"><?= $opportunity->name; ?></a>
        </div>
    <?php endif; ?>


    <div class="date">
        <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B"/>
        <p><?= __('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
    </div>
    <div class="short-description">
        <?= $single_post->excerpt ?>
    </div>
</div>