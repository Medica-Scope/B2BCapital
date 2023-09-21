<?php

/**
 * @Filename: archive-faq.php
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 9/21/2023
 */
?>
<a class="faq-item" href="<?= the_permalink() ?>">
    <div class="img">
        <img src="<?= the_post_thumbnail_url() ?>" alt="B2B" />
        <span class="title"><?= the_title() ?></span>
    </div>
    <div class="date">
        <p><?= get_the_date('F d, Y') ?></p>
    </div>
    <div class="content">
        <?= the_excerpt() ?>
    </div>
</a>