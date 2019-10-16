{assign starting_price $price_finder->getStartingPrice($card)}

<li class="search-results-item">
	<div class="search-results-item--image">
		{if $card->getImage()}
			{a action="cards/detail" id=$card}
				{!$card->getImage()|pupiq_img:"575x575xcrop":"class='img-fluid'"}
			{/a}
		{else}
		{/if}
		<div class="flags">		
			{if $starting_price && $starting_price->discounted()}
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">Sleva</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
				</div>
			{/if}
		</div>
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{a action="cards/detail" id=$card}{$card->getName()}{/a}<br>
			</h4>
			
			<p class="search-result-description">
				{$card->getTeaser()}
			</p>
			
			<p class="search-result-price">
				{if $starting_price}
					<span class="card-price">{!$price_finder->getStartingPrice($card)|display_price:$price_finder->getCurrency()}</span>
					{*<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>*}
				{/if}
			</p>
			
		</div>
		<div class="search-results-item--actions">
			{a action="cards/detail" id=$card _class="btn btn-primary btn-sm"}{t}Informace o produktu{/t} <i class="icon ion-ios-arrow-forward"></i>{/a}
		</div>
	</div>
	<div class="search-results-item--tag">
		{t}Produkt{/t}
	</div>
</li>
