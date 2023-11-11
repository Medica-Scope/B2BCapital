<?php
    /**
     * @Filename: body.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    $data = $variables['data'];
?>
<p> Hello <?= $data['user']->first_name ?>,
</p>
<p>Opportunity <strong><a href="<?= get_permalink($data['opportunity']->ID) ?>"><?= $data['opportunity']->post_title ?></a></strong> has been Verified SEO</p>