<?php
    /**
     * @Filename: main-nav.php
     * @Description:
     */

    use NH\APP\CLASSES\Nh_User;

    $active_link = !empty($args['active_link']) ? $args['active_link'] : FALSE;

    $acquisition_or_opportunities = $active_link === 'acquisition' || $active_link === 'opportunities' ? TRUE : FALSE;
?>

<ul class="dashboard-main-nav d-flex flex-row align-items-baseline">
    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account'))) ?>"
           class="btn-link <?php echo $active_link === 'my_account' ? 'active' : ''; ?>">
            <?= __('My Account', 'ninja') ?>
        </a>
    </li>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"
           class="btn-link <?php echo $acquisition_or_opportunities ? 'active' : ''; ?>">
            <?= Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja'); ?>
        </a>
    </li>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-widgets'))) ?>"
           class="btn-link <?php echo $active_link === 'my_widgets' ? 'active' : ''; ?>">
            <?= __('My Widgets', 'ninja') ?>
        </a>
    </li>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-favorite-articles'))) ?>"
           class="btn-link <?php echo $active_link === 'my_favorite_article' ? 'active' : ''; ?>">
            <?= __('My Articles', 'ninja') ?>
        </a>
    </li>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-notifications'))) ?>"
           class="btn-link <?php echo $active_link === 'my_notifications' ? 'active' : ''; ?>">
            <?= __('My Notifications', 'ninja') ?>
        </a>
    </li>
</ul>
