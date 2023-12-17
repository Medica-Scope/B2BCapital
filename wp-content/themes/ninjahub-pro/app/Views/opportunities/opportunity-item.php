<?php

    /**
     * @Filename: opportunity-item.php
     * @Description:
     * @User: Ahmed Gamal
     * @Date: 9/21/2023
     */

    use NH\APP\HELPERS\Nh_Forms;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Blog;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\Nh;

    global $wp_query, $post, $user_ID, $wp;
    $opportunity              = (isset($args['opportunity'])) ? $args['opportunity'] : '';
    $fav_form                 = (isset($args['fav_form'])) ? $args['fav_form'] : '';
    $ignore_form              = (isset($args['ignore_form'])) ? $args['ignore_form'] : '';
    $opportunity_date         = (isset($args['opportunity_date'])) ? $args['opportunity_date'] : '';
    $opportunity_link         = $opportunity->link;
    $opportunity_title        = $opportunity->title;
    $opportunity_thumbnail    = $opportunity->thumbnail;
    $opportunity_created_date = $opportunity->created_date;
    $is_item_controllers      = TRUE;
    $opportunity_id           = $opportunity->ID;
    $current_page             = (isset($args['current_page'])) ? $args['current_page'] : '';
?>
<div class="opportunity-item card shadow border-0">
	<div class="row g-0">
		<div class="card-image">
			<a href="<?= esc_url($opportunity_link); ?>"><img src="<?= esc_url($opportunity_thumbnail); ?>"
					alt="<?= esc_attr($opportunity_title); ?>"></a>
			<div class="opportunity-item-controllers">
				<?php
                        if (!empty($user_ID)) :
                            echo ($current_page == 'my-ignored-opportunities') ? '' : $args['fav_form'];
                        endif;
                        if (!empty($user_ID)) :
                            echo ($current_page == 'my-favorite-opportunities') ? '' : $args['ignore_form'];
                        endif;
                    ?>
			</div>
		</div>
		<div class="card-body p-0">
			<p class="card-text">
				<small class="text-body-secondary">
					<?= __('Business Type', 'ninja'); ?>
				</small>
				<?= $opportunity->taxonomy['business-type'][0]->name ?>
			</p>

			<a href="<?= $opportunity_link ?>" class="card-title btn btn-link btn-link-dark text-start">
				<?= mb_strimwidth( $opportunity_title, 0, 60, '...' ); ?>
			</a>

			<p class="card-text">
				<small class="text-body-secondary">
					<?= date('F j, Y', strtotime($opportunity_created_date)); ?>
				</small>
			</p>

			<div class="card-extra-info">

				<div class="card-info-item">
					<?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_location'] === 1) { ?>
					<small class="text-body-secondary"><?= __('Location', 'ninja') ?></small>
					<?php
                            if ((int)$opportunity->meta_data['location_group_appearance'] === 1) {
                                ?><p class="card-text fw-bold">
						<?= $opportunity->meta_data['location_group_location']; ?></p><?php
                            } else {
                                _ex('<small class="card-text fw-bold">HIDDEN</small>', 'ninja');
                            }
                            ?>
					<?php } ?>
				</div>

				<div class="card-info-item">
					<?php if ((int)NH_CONFIGURATION['opportunities_fields'][Nh::_DOMAIN_NAME . '_valuation_in_usd'] === 1) { ?>
					<small class="text-body-secondary"><?= __('Valuation', 'ninja') ?></small>
					<?php
                            if ((int)$opportunity->meta_data['valuation_in_usd_group_appearance'] === 1) {
                                ?><p class="card-text fw-bold">
						<?= '$ ' . $opportunity->meta_data['valuation_in_usd_group_valuation_in_usd']; ?></p><?php
                            } else {
                                _ex('<small class="card-text fw-bold">HIDDEN</small>', 'ninja');
                            }
                            ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
