<?php
    /**
     * @Filename: sub-nav.php
     * @Description:
     */

    use NH\APP\CLASSES\Nh_User;

    $active_link = !empty($args['active_link']) ? $args['active_link'] : FALSE;

    $acquisition_or_opportunities = $active_link === 'acquisition' || $active_link === 'opportunities' ? TRUE : FALSE;
?>
<ul class="dashboard-subnav d-flex flex-row align-items-baseline">
    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-opportunities'))) ?>"
           class="btn-link <?= $acquisition_or_opportunities ? 'active' : ''; ?>">
            <?= sprintf(__('My %s', 'ninja'), Nh_User::get_user_role() === Nh_User::INVESTOR ? __('Acquisition', 'ninja') : __('Opportunities', 'ninja')); ?>
        </a>
    </li>

    <?php if (Nh_User::get_user_role() === Nh_User::INVESTOR) { ?>
        <li>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-investments'))) ?>"
               class="btn-link <?= $active_link === 'my_investments' ? 'active' : ''; ?>">
                <?= __('My Investments', 'ninja'); ?>
            </a>
        </li>
        <li>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-bids'))) ?>"
               class="btn-link <?= $active_link === 'my_bids' ? 'active' : ''; ?>">
                <?= __('My Bids', 'ninja'); ?>
            </a>
        </li>
    <?php } ?>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-favorite-opportunities'))) ?>"
           class="btn-link <?= $active_link === 'my_favorite' ? 'active' : ''; ?>">
            <?= __('My Favorite Opportunities', 'ninja') ?>
        </a>
    </li>

    <li>
        <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('my-account/my-ignored-opportunities'))) ?>"
           class="btn-link <?= $active_link === 'my_ignored' ? 'active' : ''; ?>">
            <?= __('My Ignored Opportunities', 'ninja') ?>
        </a>
    </li>

    <?php if (Nh_User::get_user_role() === Nh_User::OWNER || Nh_User::get_user_role() === Nh_User::ADMIN) { ?>
        <li>
            <a href="<?= apply_filters('nhml_permalink', get_permalink(get_page_by_path('dashboard/create-opportunity'))); ?>"
               class="btn-link <?= $active_link === 'create_new_opportunity' ? 'active' : ''; ?>">
                <?= __('Create New Opportunity', 'ninja'); ?>
            </a>
        </li>
    <?php } ?>
</ul>
