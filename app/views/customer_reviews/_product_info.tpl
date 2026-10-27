{if $request->xhr()}

	<center>
		{render partial="shared/product_image" product=$product}
		<br><br>
		<h3>{$product->getName()}</h3>
	</center>

{else}

	{render partial="shared/product_info"}

{/if}
