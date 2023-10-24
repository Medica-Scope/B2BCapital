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

global $wp_query, $post, $user_ID, $wp;
$opportunity_obj = new Nh_Opportunity();
$opportunity     = (isset($args['opportunity'])) ? $args['opportunity'] : '';
$fav_form        = (isset($args['fav_form'])) ? $args['fav_form'] : '';
$ignore_form     = (isset($args['ignore_form'])) ? $args['ignore_form'] : '';
$opportunity_date     = (isset($args['opportunity_date'])) ? $args['opportunity_date'] : '';
$opportunity_link         = $opportunity->link;
$opportunity_title        = $opportunity->title;
$opportunity_thumbnail    = $opportunity->thumbnail;
$opportunity_created_date = $opportunity->created_date;
$is_item_controllers      = TRUE;
$opportunity_id           = $opportunity->ID;
$current_page = '';
if (preg_match('#dashboard#', $wp->request)) {
    $current_page = 'dashboard';
} elseif (preg_match('#my-favorite-opportunities#', $wp->request)) {
    $current_page = 'my-favorite-opportunities';
} elseif (preg_match('#my-ignored-opportunities#', $wp->request)) {
    $current_page = 'my-ignored-opportunities';
}
?>
<div class="opportunity-item card shadow border-0">
    <div class="row g-0">
        <div class="card-image">
            <div class="opportunity-item-controllers">
                <?php if (!empty($user_ID)) :
                    echo ($current_page == 'my-ignored-opportunities') ? '' : $args['fav_form'];
                endif;
                if (!empty($user_ID)) :
                    echo ($current_page == 'my-favorite-opportunities') ? '' : $args['ignore_form'];
                endif;
                ?>
            </div>
        </div>
        <div class="card-body p-0">
            <p class="card-text"><small class="text-body-secondary">
                    <?= __('Business Type', 'ninja'); ?>
                </small></p>

            <a href="<?= $opportunity_link ?>" class="card-title btn btn-link btn-link-dark">
                <?= $opportunity_title; ?>
            </a>

            <p class="card-text"><small class="text-body-secondary">
                    <?= $opportunity_created_date; ?>
                </small>
            </p>

            <div class="card-extra-info">
                <div class="card-info-item">
                    <small class="text-body-secondary">Location</small>
                    <p class="card-text fw-bold">Egypt</p>
                </div>
                <div class="card-info-item">
                    <small class="text-body-secondary">Valuation</small>
                    <p class="card-text fw-bold">95460$</p>
                </div>
                <div class="card-info-item">
                    <small class="text-body-secondary">Location</small>
                    <p class="card-text fw-bold">Egypt</p>
                </div>
                <div class="card-info-item">
                    <small class="text-body-secondary">Valuation</small>
                    <p class="card-text fw-bold">95460$</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
