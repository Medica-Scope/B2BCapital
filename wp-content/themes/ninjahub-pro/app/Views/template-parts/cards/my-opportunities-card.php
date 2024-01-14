<?php
$opportunity_title             = ! empty( $args['opportunity_title'] ) ? $args['opportunity_title'] : '';
$opportunity_link              = ! empty( $args['opportunity_link'] ) ? $args['opportunity_link'] : '';
$opportunity_modified          = ! empty( $args['opportunity_modified'] ) ? $args['opportunity_modified'] : '';
$opportunity_created_date      = ! empty( $args['opportunity_created_date'] ) ? $args['opportunity_created_date'] : '';
$opportunity_short_description = ! empty( $args['opportunity_short_description'] ) ? $args['opportunity_short_description'] : '';
$opportunity_stage             = ! empty( $args['opportunity_stage'] ) ? $args['opportunity_stage'] : '';
$badge_status_classes_arr      = [ 
	'new'              => 'text-bg-primary',
	'approved'         => 'text-bg-success',
	'publish'          => 'text-bg-success',
	'translated'       => 'text-bg-secondary',
	'cancel'           => 'text-bg-secondary',
	'hold'             => 'text-bg-warning',
	'seo-verified'     => 'text-bg-primary',
	'content-verified' => 'text-bg-primary',
	'content-rejected' => 'text-bg-warning',
	'closed' => 'text-bg-success',
];

$stages_string = [ 
	'new'              => __( 'New', 'ninja' ),
	'approved'         => __( 'Approved', 'ninja' ),
	'hold'             => __( 'Held', 'ninja' ),
	'cancel'           => __( 'Canceled', 'ninja' ),
	'content-verified' => __( 'Content Verified', 'ninja' ),
	'content-rejected' => __( 'Content Rejected', 'ninja' ),
	'seo-verified'     => __( 'SEO Verified', 'ninja' ),
	'translated'       => __( 'Translated', 'ninja' ),
	'publish'          => __( 'Published', 'ninja' ),
	'draft'            => __( 'Drafted', 'ninja' ),
	'closed'            => __( 'Closed', 'ninja' ),
];

$opportunity_stage_key = str_replace( ' ', '_', strtolower( $opportunity_stage ) );
$badge_status_class    = array_key_exists( $opportunity_stage_key, $badge_status_classes_arr ) ? $badge_status_classes_arr[ $opportunity_stage_key ] : '';
?>
<div class="my-opportunities-card">
	<div class="opportunities-card-header row p-0 position-relative">

		<h3 class="col-md-10">
			<a href="<?= $opportunity_link ?>">
				<?= mb_strimwidth( $opportunity_title, 0, 80, '...' ); ?>
			</a>
		</h3>
		<div class="col-md-2 d-flex justify-content-end align-items-start">
			<span class="status badge <?= $badge_status_class; ?>">
				<?= $stages_string[ $opportunity_stage ]; ?>
			</span>
		</div>
	</div>

	<div class="opportunities-card-body">
		<small class="date text-mute">
			<?= date( 'F jS, Y', strtotime( $opportunity_created_date ) ); ?>
		</small>

		<p class="short-description text-break">
			<?= mb_strimwidth( $opportunity_short_description, 0, 140, '...' ); ?>
		</p>
	</div>
</div>
