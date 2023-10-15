<?php
/**
 * @Filename: sub-nav.php
 * @Description:
 */

$active_link = ! empty( $args['active_link'] ) ? $args['active_link'] : false;
?>
<ul class="dashboard-subnav d-flex flex-row align-items-baseline">
	<li><a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account' ) ) ) ?>"
			class="btn-link <?php echo $active_link === 'profile_data' ? 'active' : ''; ?>">
			<?= __( 'Profile Data', 'ninja' ) ?>
		</a></li>

	<li><a
			href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/change-password' ) ) ) ?>"
			class="btn-link <?php echo $active_link === 'change_password' ? 'active' : ''; ?>">
			<?= __( 'Change Password', 'ninja' ) ?>
		</a></li>
</ul>
