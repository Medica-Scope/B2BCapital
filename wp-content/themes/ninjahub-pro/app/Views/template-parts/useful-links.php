<?php

/**
 * @Filename: useful-links.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */
use NH\APP\HELPERS\Nh_Hooks;

?>

<div class="useful-links-con">
    <img src="<?= Nh_Hooks::PATHS['public']['img'] ?>/links.webp" alt="B2B" />
    <h3><?= _e("Useful links for you", "ninja") ?></h3>
    <ul class="links">
        <li><a href="#"><?= _e("Order return form", "ninja") ?></a></li>
        <li><a href="#"><?= _e("Contact form", "ninja") ?></a></li>
        <li><a href="#"><?= _e("Shipping pricing table", "ninja") ?></a></li>
        <li><a href="#"><?= _e("Reviews", "ninja") ?></a></li>
        <li><a href="#"><?= _e("Your orders", "ninja") ?></a></li>
    </ul>
</div>