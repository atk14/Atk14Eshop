{foreach $card->getProducts() as $product}
	
	{assign price $price_finder->getPrice($product)}

	<section>

		<h3>{$product->getName()}</h3>

		<p>
			{t catalog_id=$product->getCatalogId()}Catalog number: %1{/t}
		</p>

		<p>
			{display_stockcount product=$product}
		</p>
	
		{if $price}
			<p>
				{t price=$price->getPriceInclVat()|display_price escape=no}Price: %1 incl. VAT{/t}
			</p>
		{/if}

		{if $product->canBeOrdered($price_finder)}

			<form method="post" action="{link_to action="baskets/add_product"}">

				{!$product|add_to_basket_field}
				
				<button type="submit" class="btn btn-primary">{t}Add to basket{/t}</button>

				<input type="hidden" name="product_id" value="{$product->getId()}">
			</form>

		{elseif !$price}

			<p><em>{t}This product is not in offer{/t}</em></p>

		{else}

			<p><em>{t}This product is sold out{/t}</em></p>

		{/if}

	</section>

{/foreach}
