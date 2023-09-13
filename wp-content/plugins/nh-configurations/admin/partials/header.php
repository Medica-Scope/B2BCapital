<?php
    /**
     * Filename: header.php
     * Description:
     * User: NINJA MASTER - Mustafa Shaaban
     * Date: 7/21/2022
     */

?>

<nav class="nh-nav-configuration">
    <div class="nav nav-tabs">
        <?php
            foreach ($this->pages as $slug => $title) {
                ?><a href="<?= admin_url("admin.php?page=$slug") ?>" class="nav-link <?= $_GET['page'] === $slug ? 'active' : ''; ?>"><?= $title ?></a><?php
            }
        ?>
    </div>
</nav>

<div aria-live="polite" aria-atomic="true" class="position-relative bg-dark">
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>
</div>
