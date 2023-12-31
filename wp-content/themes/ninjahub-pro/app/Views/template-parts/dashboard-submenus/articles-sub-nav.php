<?php
/**
 * @Filename: sub-nav.php
 * @Description:
 */

use NH\APP\CLASSES\Nh_User;

$active_link = ! empty( $args['active_link'] ) ? $args['active_link'] : false;

?>
<ul class="dashboard-subnav d-flex flex-row align-items-baseline">

	<li>
		<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/my-favorite-articles' ) ) ) ?>"
			class="btn-link <?= $active_link === 'my_favorite_article' ? 'active' : ''; ?>">
			<?= __( 'My Favorite Articles', 'ninja' ) ?>
		</a>
	</li>

    <li>
		<a href="<?= apply_filters( 'nhml_permalink', get_permalink( get_page_by_path( 'my-account/my-ignored-articles' ) ) ) ?>"
			class="btn-link <?= $active_link === 'my_ignored_article' ? 'active' : ''; ?>">
			<?= __( 'My Ignored Articles', 'ninja' ) ?>
		</a>
	</li>

</ul>
