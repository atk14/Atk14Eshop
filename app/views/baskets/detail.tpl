{if $basket->isEmpty()}

	{t}The shopping basket is empty.{/t}

{else}

	{assign incl_vat $basket->displayPricesInclVat()}
	{assign currency $basket->getCurrency()}

	<ul>
	{foreach $basket->getItems() as $item}
		{assign product $item->getProduct()}
		{assign unit $product->getUnit()}
		{assign price $item->getProductPrice()}

		<li>
			<a href="{$product|link_to_product}">
				<img {!$product->getImage()|img_attrs:"120x120x#ffffff"}>
			</a>

			<a href="{$product|link_to_product}">{$product->getName()}</a>

			{$item->getAmount()} {$unit}

			{render partial="price" price=$price} 
		</li>
	{/foreach}
	</ul>

	<p>
		{t}Total price{/t}: {!$basket->getItemsPrice($incl_vat)|display_price:$currency}
	</p>	

	<a href="{link_to action="baskets/edit"}" class="btn btn-default">{t}Go to shopping basket{/t}</a>

{/if}
