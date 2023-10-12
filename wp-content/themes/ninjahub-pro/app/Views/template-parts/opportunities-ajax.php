<?php

/**
 * @Filename: opportunities-ajax.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 21/2/2023
 *
 * @package NinjaHub
 * @since 1.0
 *
 */


use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
use NH\APP\MODELS\FRONT\MODULES\Nh_Profile;


global $user_ID;
$opportunity_obj = new Nh_Opportunity();
$profile_id  = get_user_meta($user_ID, 'profile_id', TRUE);
$profile_obj = new Nh_Profile();
$profile     = $profile_obj->get_by_id((int)$profile_id);
$favorites = [];
$opportunities = [];



            if (!is_wp_error($profile)) {
                $favorite_opportunities = [];
                $ignored_opportunities = ($profile->meta_data['ignored_opportunities']) ? $profile->meta_data['ignored_opportunities'] : [];
                $not_in = array_merge($favorite_opportunities, $ignored_opportunities);
                $opportunities = $opportunity_obj->get_all_custom(['publish'], -1, 'date', 'DESC', $favorite_opportunities, [], $user_ID);
                if (!empty($opportunities)) {
            ?>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-opportunity-tab" data-bs-toggle="pill" data-bs-target="#my-opportunity" type="button" role="tab" aria-controls="my-opportunity" aria-selected="true"><?= __("My Opportunities", "ninja") ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fav-opportunity-tab" data-bs-toggle="pill" data-bs-target="#fav-opportunity" type="button" role="tab" aria-controls="fav-opportunity" aria-selected="false"><?= __("My Favorite Opportunities", "ninja") ?></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="my-opportunity" role="tabpanel" aria-labelledby="my-opportunity-tab" tabindex="0">
                            <?php
                            foreach ($opportunities as $opportunity) {
                                $opportunity_date = get_the_date('Y-m-d', $opportunity->ID);
                                if ($user_ID) {
                                    $fav_chk            = $opportunity_obj->is_post_in_user_favorites($opportunity->ID, $user_ID);
                                    $ignore_chk         = $opportunity_obj->is_post_in_user_ignored_opportunities($opportunity->ID, $user_ID);
                                }
                                $fav_chk = (isset($fav_chk)) ? $fav_chk : '';
                                $ignore_chk = (isset($ignore_chk)) ? $ignore_chk : '';
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
                                    <span class="date"><?php echo get_the_date('F jS, Y', $opportunity->ID) ?></span>
                                    <p class="short-description"><?= $opportunity->meta_data['short_description'] ?></p>
                                    <span class="status"><?= $opportunity->status ?></span>
                                    <?php if (!empty($user_ID)): ?>
                                        <div class="ninja-fav-con">
                                            <button class="ninja-add-to-fav btn <?= ($fav_chk) ? 'btn-dark' : '' ?>" id="addToFav" data-uID="<?= $user_ID ?>" data-id="<?= $opportunity->ID ?>"
                                                    data-type="<?= $opportunity->type ?>" type="button">FAV
                                            </button>
                                        </div>
                                    <?php endif; ?>


                                    <?php if (!empty($user_ID)): ?>
                                        <div class="ninja-ignore-con">
                                            <button class="ninja-add-to-ignore btn <?= ($ignore_chk) ? 'btn-outline-dark' : '' ?>" id="addToIgnore" data-uID="<?= $user_ID ?>" data-id="<?= $opportunity->ID ?>"
                                                    data-type="<?= $opportunity->type ?>" type="button">X
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="fav-opportunity" role="tabpanel" aria-labelledby="fav-opportunity-tab" tabindex="0">
                            <?php
                            if (!empty($favorite_opportunities)) {
                                foreach ($favorite_opportunities as $fav_opportunity_id) {
                                    $obj = new Nh_Opportunity();
                                    $favorite_opportunity = $obj->get_by_id((int) $fav_opportunity_id);
                                    if ($favorite_opportunity) {
                                        $favorite_opportunity_date = get_the_date('Y-m-d', $favorite_opportunity->ID);
                            
                            ?>
                                        <div class="opportunity-card">
                                            <?php
                                            if ($favorite_opportunity_date >= date('Y-m-d', strtotime('-20 days'))) {
                                            ?>
                                                <span class="new"><?= __("New", "ninja") ?></span>
                                            <?php } ?>
                                            <h3><?= $favorite_opportunity->name ?></h3>
                                            <span class="date"><?php echo get_the_date('F jS, Y', $favorite_opportunity->ID) ?></span>
                                            <p class="short-description"><?= $favorite_opportunity->meta_data['short_description'] ?></p>
                                            <span class="status"><?= $favorite_opportunity->status ?></span>
                                        </div>
                                <?php
                                    }
                                }
                            } else { ?>
                                <p><?= __("No Favorites", "ninja") ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php }  ?>