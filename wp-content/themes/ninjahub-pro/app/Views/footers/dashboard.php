<?php
/**
 * @Filename: dashboard.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

use NH\APP\CLASSES\Nh_Init;
use NH\APP\HELPERS\Nh_Hooks;
use NH\Nh;

$whatsapp_number = Nh_Init::$_NH_CONFIGURATION['contact'][ Nh::_DOMAIN_NAME . '_whatsapp_number' ];
$whatsapp_msg    = Nh_Init::$_NH_CONFIGURATION['contact'][ Nh::_DOMAIN_NAME . '_whatsapp_msg' ];
$whatsapp_logo   = Nh_Hooks::PATHS['public']['img'] . '/whatsapp-logo.webp';
?>
<style>
.whatsapp-chat {
	position: fixed;
	bottom: 10rem;
	right: 1rem;
	width: 40px;
}

.whatsapp-chat img {
	display: block;
	width: 100%;
}
</style>
<footer>
	<div class="whatsapp-chat">
		<?php
		echo sprintf(
			'<a href="https://web.whatsapp.com/send?phone=%s&text=%s"><img src="%s" /></a>',
			$whatsapp_number,
			$whatsapp_msg,
			$whatsapp_logo );
		?>
	</div>
	<?php dynamic_sidebar( 'footer' ); ?>
</footer>