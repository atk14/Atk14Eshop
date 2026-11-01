{assign var=card value=$card_recommendation_boost->getCard()}
<li class="list-group-item" data-id="{$card_recommendation_boost->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{render partial="shared/list_thumbnail" image=$card->getImage()}
			{$card->getName()}
			{if $card_recommendation_boost->isNegative()}
				<span class="badge badge-danger">{t}negativní{/t}</span>
			{/if}
		</div>
		<div class="item__controls">
			{dropdown_menu}
				{a action="edit" id=$card_recommendation_boost}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
				<a href="{$card|link_to_card}">{!"eye-open"|icon} {t}Show product on web{/t}</a>
				{a action="cards/edit" id=$card}{!"pencil-alt"|icon} {t}Edit product{/t}{/a}
				{a_destroy id=$card_recommendation_boost}{!"trash-alt"|icon} {t}Remove{/t}{/a_destroy}
			{/dropdown_menu}
		</div>
	</div>
</li>
