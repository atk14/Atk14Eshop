{assign products $card->getProducts()}

<section class="section--add-to-cart">

	{if !$products}

		<em>{t}This product is not in offer{/t}</em>

	{else}

		{if $card->hasVariants()}
			<ul class="nav nav-tabs" id="variants-nav" role="tablist">
				{foreach $products as $product}
					<li class="nav-item">
						<a class="nav-link{if $product@iteration == 1} active{/if}" id="tab-variant-{$product->getId()}" data-toggle="tab" href="#tab-variant-content-{$product->getId()}" role="tab" aria-controls="tab-variant-content-{$product->getId()}" aria-selected="{if $product@iteration == 1}true{else}false{/if}" data-product_id="{$product->getId()}">{$product->getLabel()}</a>
					</li>
				{/foreach}
			</ul>

			<div class="tab-content" id="myTabContent">
		{/if}

		{foreach $products as $product}

			{assign price $price_finder->getPrice($product)}

			{if $card->hasVariants()}
				<div class="tab-pane fade{if $product@iteration == 1} show active{/if}" id="tab-variant-content-{$product->getId()}" role="tabpanel" aria-labelledby="{$product->getLabel()}">
			{/if}
			<div class="add-to-cart-meta add-to-cart-meta-top">
				
				<p>
					{display_stockcount product=$product}
				</p>
				
				<p class="catalog-number">
					{t catalog_id=$product->getCatalogId()}Catalog number: %1{/t}
				</p>
				
			</div>
			{if $product->canBeOrdered($price_finder)}

				<div class="add-to-cart-widget">
					<div class="price">{t price=$price->getPriceInclVat()|display_price escape=no}Price: %1 <span class="dph">incl. VAT</span>{/t}</div>
					<form method="post" action="{link_to action="baskets/add_product"}" class="form_remote" data-remote="true">

						{!$product|add_to_basket_field}

						<button type="submit" class="btn btn-primary btn-lg add-to-cart-submit">{t}Add to cart{/t}  {!"cart-plus"|icon}</button>

						<input type="hidden" name="product_id" value="{$product->getId()}">
					</form>
				</div>

			{elseif !$price}
				<div class="add-to-cart-meta">
					<p><em>{t}This product is not in offer{/t}</em></p>
				</div>
			{else}
				<div class="add-to-cart-meta">	
				
					<p class="price">{t price=$price->getPriceInclVat()|display_price escape=no}Price: %1 <span class="dph">incl. VAT</span>{/t}</p>

					<p><em>{t}This product is sold out{/t}</em></p>
				
				</div>
			{/if}

			{if $card->hasVariants()}
				</div>
			{/if}
		{/foreach}

		{if $card->hasVariants()}
			</div>
		{/if}

	{/if}
</section>
