{if $request->xhr()}

	<center>
		{render partial="shared/product_image" product=$product}
		<br><br>
		<h3>{$product->getName()}</h3>
	</center>

{else}

<div class="d-sm-flex mb-3">
	<div class="mr-3 mb-4">
		<a href="{$product|link_to_product}">{render partial="shared/product_image" product=$product}</a>
	</div>
	<div>
	<h3><a href="{$product|link_to_product}">{$product->getName()}</a></h3>
	{if $product->getCard()->getTeaser()}
		{$product->getCard()->getTeaser()|markdown|strip_html|truncate:400}
	{/if}
	</div>
</div>

{/if}
