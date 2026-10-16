{assign var=card value=$card_recommendation_boost->getCard()}
<li class="list-group-item" data-id="{$card_recommendation_boost->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{render partial="shared/list_thumbnail" image=$card->getImage()}
			{$card->getName()}
		</div>
		<div class="item__controls">
			{dropdown_menu}
				{a action="cards/edit" id=$card}{!"pencil-alt"|icon} {t}Edit product{/t}{/a}
				{a_destroy id=$card_recommendation_boost}{!"trash-alt"|icon} {t}Remove{/t}{/a_destroy}
			{/dropdown_menu}
		</div>
	</div>
</li>
