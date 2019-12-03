{if $products}

	{foreach $products as $product}
		{$product->getCatalogId()}
		{if !$product@last}<br>{/if}
	{/foreach}

{/if}
