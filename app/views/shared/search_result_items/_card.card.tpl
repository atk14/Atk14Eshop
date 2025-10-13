{assign starting_price $price_finder->getStartingPrice($card)}
{assign main_creators CardCreator::GetMainCreatorsForCard($card)}

<div class="card card--search card--search--card card--search--card--id-{$card->getId()}{if $basket->contains($card)} card--search--card--in-basket{/if}">
	<div class="card__image">
		{a action="cards/detail" id=$card}
			{if $card->getImage()}
				<img {!$card->getImage()|img_attrs:"400x300x#ffffff"} class="card-img-top" alt="{$card->getName()}">
			{else}
				<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top default-image">
			{/if}
		{/a}

		<div class="card__flags">
			{if $starting_price && $starting_price->discounted()}
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
				</div>
			{/if}
		</div>
		{if $card->getTags()}
			<div class="card__tags">
				{render partial="shared/tags" tags=$card->getTags()}
			</div>
		{/if}
		<div class="card__label">
			{$card->getProductType()|capitalize} {* e.g. Product, Book...*}
		</div>
		{render partial="shared/card_icons"}
	</div>
	<div class="card-body">
		<h4 class="card-title">{a action="cards/detail" id=$card}{highlight_keywords keywords=$params.q tag="<mark>"}{$card->getName()}{/highlight_keywords}{/a}</h4>
		{if $main_creators}
			<div class="card-author">
				{highlight_keywords keywords=$params.q tag="<mark>"}{$main_creators|to_sentence:", "}</div>{/highlight_keywords}
		{/if}
		<div class="card-text">{highlight_keywords keywords=$params.q tag="<mark>"}{$card->getTeaser()|markdown|strip_html|truncate:300}{/highlight_keywords}</div>
	</div>
	
	<div class="card-footer">
		{if $starting_price}
			{render partial="shared/card_price" card=$card}
			<span class="card-footer__icon">{a action="cards/detail" id=$card}{!"shopping-cart"|icon} {!"chevron-right"|icon}{/a}</span>
		{/if}
		<div class="w-100 mt-2">{a action="cards/detail" id=$card _class="btn btn-primary btn-sm"}{t}Zobrazit produkt{/t}{/a}</div>
	</div>
	
</div>
