{assign products $card->getProducts()}

{if $products}
	<ul class="section--variants__list">
		{render partial="product_item" from=$card->getProducts() item=product}
	</ul>
{/if}
