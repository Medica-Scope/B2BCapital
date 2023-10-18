<?php

/**
 * @Filename: blogs.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */

use NH\APP\HELPERS\Nh_Forms;
use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\Nh;

global $wp_query, $post, $user_ID;
$post_obj        = new Nh_Blog();
$opportunity_obj = new Nh_Opportunity();
$opportunity     = "";
$single_post     = $args['post'];

if ( ( $single_post->meta_data['opportunity'] ) ) {
	$opportunity         = $opportunity_obj->get_by_id( $single_post->meta_data['opportunity'] );
	$args['opportunity'] = $opportunity;
}

if ( $user_ID ) {
	$fav_chk            = $post_obj->is_post_in_user_favorites( $single_post->ID );
	$ignore_chk         = $post_obj->is_post_in_user_ignored( $single_post->ID );
	$args['fav_chk']    = $fav_chk;
	$args['ignore_chk'] = $ignore_chk;
}
$fav_chk     = ( isset( $args['fav_chk'] ) ) ? $args['fav_chk'] : '';
$ignore_chk  = ( isset( $args['ignore_chk'] ) ) ? $args['ignore_chk'] : '';
$opportunity = ( isset( $args['opportunity'] ) ) ? $args['opportunity'] : '';
?>
<div class="blog-item card">

    <a href="<?= $single_post->link ?>" class="img">
        <img src="<?= $single_post->thumbnail ?>" alt="B2B" />
        <span class="dots"></span>
    </a>


    <?php if (!empty($user_ID)) : ?>
        <div class="card-image">
            <div class="opportunity-item-controllers">
                <?php
                if ($fav_chk) {
                    $fav_class = 'bbc-star';
                } else {
                    $fav_class = 'bbc-star-o';
                }
                echo Nh_Forms::get_instance()
                    ->create_form([
                        'post_id'                      => [
                            'type'   => 'hidden',
                            'name'   => 'post_id',
                            'before' => '',
                            'after'  => '',
                            'value'  => $single_post->ID,
                            'order'  => 0
                        ],
                        'add_to_fav_nonce'               => [
                            'class' => '',
                            'type'  => 'nonce',
                            'name'  => 'add_to_fav_nonce_nonce',
                            'value' => Nh::_DOMAIN_NAME . "_add_to_fav_nonce_form",
                            'order' => 5
                        ],
                        'submit_add_to_fav_request' => [
                            'class'               => 'btn btn-light bg-white article-to-favorite ninja-add-to-fav',
                            'id'                  => 'submit_add_to_fav_request',
                            'type'                => 'submit',
                            'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                            'recaptcha_form_name' => 'frontend_add_to_fav',
                            'order'               => 10
                        ],
                    ], [
                        'class' => Nh::_DOMAIN_NAME . '-add-to-fav-form',
                    ]);
                ?>
            </div>
        </div>
    <?php
    endif;
    ?>



    <?php if (!empty($user_ID)) : ?>
        <div class="card-image">
            <div class="opportunity-item-controllers">
                <?php
                if ($fav_chk) {
                    $fav_class = 'bbc-star';
                } else {
                    $fav_class = 'bbc-star-o';
                }
               echo Nh_Forms::get_instance()
                ->create_form([
                    'post_id'                      => [
                        'type'   => 'hidden',
                        'name'   => 'post_id',
                        'before' => '',
                        'after'  => '',
                        'value'  => $single_post->ID,
                        'order'  => 0
                    ],
                    'ignore_article_nonce'               => [
                        'class' => '',
                        'type'  => 'nonce',
                        'name'  => 'ignore_article_nonce',
                        'value' => Nh::_DOMAIN_NAME . "_ignore_article_nonce_form",
                        'order' => 5
                    ],
                    'submit_ignore' => [
                        'class'               => 'btn',
                        'id'                  => 'submit_submit_ignore',
                        'type'                => 'submit',
                        'value'               => '<i class="' . $fav_class . ' fav-star"></i>',
                        'recaptcha_form_name' => 'frontend_ignore',
                        'order'               => 10
                    ],
                ], [
                    'class' => Nh::_DOMAIN_NAME . '-create-ignore-article-form',
                ]);
                ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="title">
        <a href="<?= $single_post->link ?>"><?= $single_post->title ?></a>
    </div>


    <?php if (!empty($single_post->taxonomy['category'])) : ?>
        <div class="category">
            <?= $single_post->taxonomy['category'][0]->name ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($opportunity)) : ?>
        <div class="opportunity">
            <a href="<?= $opportunity->link ?>"><?= $opportunity->name; ?></a>
        </div>
    <?php endif; ?>


    <div class="date">
        <img src="<?= get_avatar_url($single_post->author) ?>" alt="B2B" />
        <p><?= __('on', 'ninja') ?> <?= date('F d, Y', strtotime($single_post->created_date)) ?></p>
    </div>
    <div class="short-description">
        <?= $single_post->excerpt ?>
    </div>
</div>
