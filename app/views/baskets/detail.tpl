{if $basket->isEmpty()}
	<div class="basket-content__empty">
		{t}The shopping basket is empty.{/t}
	</div>
{else}

	{assign incl_vat $basket->displayPricesInclVat()}
	{assign currency $basket->getCurrency()}
	<div class="basket-content__items">
		<ul class="list-unstyled">
		{foreach $basket->getItems() as $item}
			{assign product $item->getProduct()}
			{assign unit $product->getUnit()}
			{assign price $item->getProductPrice()}

			<li class="p-1">
				<a href="{$product|link_to_product}">
					<img {!$product->getImage()|img_attrs:"50x50x#ffffff"}>
				</a>

				<a href="{$product|link_to_product}">{$product->getName()}</a>

				{$item->getAmount()} {$unit}

				{render partial="price" price=$price} 
			</li>
		{/foreach}
		</ul>
	</div>
	<div class="basket-content__total">
		<div class="description">{t}Total price{/t}:</div>
		<div class="price">{!$basket->getItemsPrice($incl_vat)|display_price:$currency}</div>
	</div>	


{/if}
