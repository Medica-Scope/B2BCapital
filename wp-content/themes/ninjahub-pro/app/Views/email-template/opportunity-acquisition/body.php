<?php
    /**
     * @Filename: body.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    $data = $variables['data'];
    $title = get_post_field('post_title', $data['opportunity']->ID);
?>
<p> Hello <?= $data['user']->first_name ?>,
</p>

<p>Opportunity <strong><a href="<?= get_permalink($data['opportunity']->ID) ?>"><?= $title ?></a></strong> has a new acquisition request</p>