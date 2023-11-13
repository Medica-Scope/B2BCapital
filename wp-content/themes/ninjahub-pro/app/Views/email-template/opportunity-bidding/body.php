<?php
    /**
     * @Filename: body.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    $data = $variables['data'];
    $title = get_post_field('post_title', $data['opportunity_id']);
?>
<p> Hello <?= $data['user']->first_name ?>,
</p>

<p>Opportunity <strong><a href="<?= get_permalink($data['opportunity_id']) ?>"><?= $title ?></a></strong> has a new bid</p>