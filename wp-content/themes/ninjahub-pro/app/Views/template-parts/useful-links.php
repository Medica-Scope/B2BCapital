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
    <h3><?= __("Useful links for you", "ninja") ?></h3>
    <ul class="links">
        <li><a href="#"><?= __("Order return form", "ninja") ?></a></li>
        <li><a href="#"><?= __("Contact form", "ninja") ?></a></li>
        <li><a href="#"><?= __("Shipping pricing table", "ninja") ?></a></li>
        <li><a href="#"><?= __("Reviews", "ninja") ?></a></li>
        <li><a href="#"><?= __("Your orders", "ninja") ?></a></li>
    </ul>
</div>