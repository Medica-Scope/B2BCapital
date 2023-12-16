<?php
/**
 * @Filename: dashboard.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 4/26/2023
 */

    use NH\Nh;

?>

<footer>
    <div class="whatsapp-chat">
        <a href="https://web.whatsapp.com/send?phone=<?= NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_whatsapp_number'] ?>&text=<?=
            NH_CONFIGURATION['contact'][Nh::_DOMAIN_NAME . '_whatsapp_msg'] ?>">Chat with Us</a>
    </div>
	<?php dynamic_sidebar( 'footer' ); ?>
</footer>
