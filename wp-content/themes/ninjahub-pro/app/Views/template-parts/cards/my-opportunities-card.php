<?php
    $opportunity_title             = !empty($args['opportunity_title']) ? $args['opportunity_title'] : '';
    $opportunity_link              = !empty($args['opportunity_link']) ? $args['opportunity_link'] : '';
    $opportunity_modified          = !empty($args['opportunity_modified']) ? $args['opportunity_modified'] : '';
    $opportunity_created_date      = !empty($args['opportunity_created_date']) ? $args['opportunity_created_date'] : '';
    $opportunity_short_description = !empty($args['opportunity_short_description']) ? $args['opportunity_short_description'] : '';
    $opportunity_stage             = !empty($args['opportunity_stage']) ? $args['opportunity_stage'] : '';
    $badge_status_classes_arr      = [
        'approved'      => 'text-bg-success',
        'success'       => 'text-bg-success',
        'published'     => 'text-bg-success',
        'pending'       => 'text-bg-danger',
        'closed'        => 'text-bg-dark',
        'translated'    => 'text-bg-secondary',
        'review'        => 'text-bg-secondary',
        'held'          => 'text-bg-warning',
        'seo_verified'  => 'text-bg-primary',
        'bidding_start' => 'text-bg-primary',
    ];

    $opportunity_stage_key = str_replace(' ', '_', strtolower($opportunity_stage));
    $badge_status_class    = array_key_exists($opportunity_stage_key, $badge_status_classes_arr) ? $badge_status_classes_arr[$opportunity_stage_key] : '';
?>
<div class="my-opportunities-card">
    <div class="opportunities-card-header row p-0 position-relative">
        <?php
            if (strtotime($opportunity_modified) >= strtotime(date('Y-m-d', strtotime('-30 days')))) {
                ?>
                <span class="badge"><?= __('New', 'ninja'); ?></span>
                <?php
            }
        ?>

        <h3 class="col-8">
            <a href="<?= $opportunity_link ?>"><?php echo $opportunity_title; ?></a>
        </h3>
        <div class="col-4 d-flex justify-content-end align-items-start">
			<span class="status badge <?php echo $badge_status_class; ?>">
				<?php echo $opportunity_stage; ?>
			</span>
        </div>
    </div>

    <div class="opportunities-card-body">
        <small class="date text-mute">
            <?php echo date('F jS, Y', strtotime($opportunity_created_date)); ?>
        </small>

        <p class="short-description">
            <?php echo wp_html_excerpt($opportunity_short_description, 140, '...'); ?>
        </p>
    </div>
</div>
