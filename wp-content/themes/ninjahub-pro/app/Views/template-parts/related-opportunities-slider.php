<?php

    use NH\APP\MODELS\FRONT\MODULES\Nh_Opportunity;
    use NH\APP\MODELS\FRONT\Nh_Public;
    use NH\APP\HELPERS\Nh_Hooks;
    use NH\Nh;

?>

<div class="related-opportunities-slider">
    <div class="row overflow-x-auto flex-nowrap">
        <?php
            $opportunities_obj = new Nh_Opportunity();
            $opportunities     = isset($args['related_opportunities']) && is_array($args['related_opportunities']) ? $args['related_opportunities'] : [];
            foreach ($opportunities as $opportunity_id) {
                $opportunity = $opportunities_obj->get_by_id($opportunity_id);
                if ($opportunity->meta_data['opportunity_stage'] !== 'publish') {
                    continue;
                }
                $args        = [
                    'opportunity_link'         => $opportunity->link,
                    'opportunity_title'        => $opportunity->title,
                    'opportunity_thumbnail'    => $opportunity->thumbnail,
                    'opportunity_created_date' => $opportunity->created_date,
                    'business_type'            => $opportunity->taxonomy['business-type'][0]->name,
                    'is_item_controllers'      => TRUE,
                    'location'                 => $opportunity->meta_data['location_group_location'],
                    'location_appearance'      => $opportunity->meta_data['location_group_appearance'],
                    'valuation'                => $opportunity->meta_data['valuation_in_usd_group_valuation_in_usd'],
                    'valuation_appearance'     => $opportunity->meta_data['valuation_in_usd_group_appearance'],
                ];
                ?>
                <div class="col-4">
                    <?= get_template_part('app/Views/template-parts/cards/opportunity-card-vertical', NULL, $args); ?>
                </div>
                <?php
            }
        ?>
    </div>
</div>
