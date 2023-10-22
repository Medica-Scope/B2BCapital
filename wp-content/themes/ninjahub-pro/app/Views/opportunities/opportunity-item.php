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
$opportunity_obj = new Nh_Opportunity();
$opportunity     = (isset($args['opportunity'])) ? $args['opportunity'] : '';
$fav_form        = (isset($args['fav_form'])) ? $args['fav_form'] : '';
$ignore_form     = (isset($args['ignore_form'])) ? $args['ignore_form'] : '';
$opportunity_date     = (isset($args['opportunity_date'])) ? $args['opportunity_date'] : '';
?>
<div class="opportunity-card">
    <?php
    if ($opportunity_date >= date('Y-m-d', strtotime('-20 days'))) {
    ?>
        <span class="new"><?= __("New", "ninja") ?></span>
    <?php
    }
    ?>
    <h3><?= $opportunity->name ?></h3>
    <span class="date"><?= $opportunity_date ?></span>
    <p class="short-description"><?= $opportunity->meta_data['short_description'] ?></p>
    <span class="status"><?= $opportunity->status ?></span>
    <?php if (!empty($user_ID)) :
        echo $args['fav_form'];
    endif;


    if (!empty($user_ID)) :
        echo $args['ignore_form'];
    endif;
    ?>

</div>
<?php
