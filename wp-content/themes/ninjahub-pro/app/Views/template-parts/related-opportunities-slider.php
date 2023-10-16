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

		foreach ( $opportunities as $opportunity_id ) {
            $opportunity = $opportunities_obj->get_by_id($opportunity_id);
			$args = [ 
				'opportunity_link'         => $opportunity->link,
				'opportunity_title'        => $opportunity->title,
				'opportunity_thumbnail'    => $opportunity->thumbnail,
				'opportunity_created_date' => $opportunity->created_date,
				'is_item_controllers'      => true,
			];
			?>
			<div class="col-4">
				<?php get_template_part( 'app/Views/template-parts/cards/opportunity-card-vertical', null,
					$args ); ?>
			</div>
			<?php
		}
		?>
	</div>
</div>
