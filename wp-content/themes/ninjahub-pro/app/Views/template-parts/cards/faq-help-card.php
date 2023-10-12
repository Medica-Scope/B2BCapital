<?php
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

?>
<div class="faq-help-card shadow">
	<div>
		<h3>
			<?= __( 'Help and Modules', 'ninja' ) ?>
		</h3>
		<p>
			<?= __( 'Our help and module screens are here to make your life easier', 'ninja' ) ?>
		</p>
		<a href="<?= apply_filters( 'nhml_permalink', get_post_type_archive_link( 'faq' ) ) ?>" class="btn square">
			<?= __( 'Go', 'ninja' ) ?>
		</a>
	</div>

	<img src="<?php echo Nh_Hooks::PATHS['public']['img']; ?>/help.webp" alt="help icon" />
</div>
