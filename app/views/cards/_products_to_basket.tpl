{assign products $card->getProducts()}
{assign currency $price_finder->getCurrency()}
{assign incl_vat $basket->displayPricesInclVat()}

{capture assign=dp_options}{$currency}{if !$incl_vat},without_vat,show_vat_label{/if}{/capture}

<section class="section--add-to-cart">

	{if !$products}

		<em>{t}This product is not in offer{/t}</em>

	{else}

		{if $card->hasVariants()}
			<ul class="nav nav-tabs" id="variants-nav" role="tablist">
				{foreach $products as $product}
					<li class="nav-item" role="presentation">
						<a class="nav-link{if $product@iteration == 1} active{/if}" id="tab-variant-{$product->getId()}" data-toggle="tab" href="#tab-variant-content-{$product->getId()}" role="tab" aria-controls="tab-variant-content-{$product->getId()}" aria-selected="{if $product@iteration == 1}true{else}false{/if}" data-product_id="{$product->getId()}">{$product->getLabel()|default:$product->getCatalogId()}</a>
					</li>
				{/foreach}
			</ul>

			<div class="tab-content" id="myTabContent">
		{/if}

		{foreach $products as $product}

			{assign price $price_finder->getPrice($product)}
			{assign base_price $price_finder->getBasePrice($product)}

			{capture assign=price_info}
				{if $price && $price->priceExists()}
					<div class="prices">
						<div class="price--main">
							{if $price->discounted()}
								<span class="price--before-discount">{!$price->getProductPriceBeforeDiscount()|display_price:$dp_options}</span>
							{/if}
							{if $base_price && !$price->discounted()}
								<span class="price--before-discount"> {* tady byla trida price--recommended *}
									{t escape=no}Běžně <!-- běžná cena -->{/t} {!$base_price|display_price:$dp_options}
									{* {t}Ušetříte:{/t} <span class="moneysaved">{!($base_price->getPrice($incl_vat)-$price->getPrice($incl_vat))|display_price:$currency}</span> *}
								</span>
							{/if}
							{if $incl_vat}
								<span class="price--primary">{!$price|display_price:"$dp_options,show_vat_label"}</span>
							{else}
								<span class="price--primary">{!$price|display_price:"$dp_options"}</span>
								<div class="price--incl-vat">{!$price|display_price:"$currency,show_vat_label"}</div>
							{/if}
						</div>
					</div>
				{/if}
			{/capture}

			{if $card->hasVariants()}
				<div class="tab-pane fade{if $product@iteration == 1} show active{/if}" id="tab-variant-content-{$product->getId()}" role="tabpanel" aria-labelledby="tab-variant-{$product->getId()}">
			{/if}

				<div class="cart-panel">
					<div class="cart-panel__meta">
						<p>
							{display_stockcount product=$product}
						</p>
						<p class="catalog-number">
							{t catalog_id=$product->getCatalogId()}Catalog number: %1{/t}
						</p>
					</div>
					<div class="cart-panel__controls">
					{if $product->canBeOrdered($price_finder)}
						<div class="add-to-cart-widget">

							{!$price_info}

							<form method="post" action="{link_to action="baskets/add_product"}" class="form_remote" data-remote="true">

								{!$product|add_to_basket_field}

								<button type="submit" class="btn btn-primary add-to-cart-submit">{t}Add to cart{/t}  {!"cart-plus"|icon}</button>

								<input type="hidden" name="product_id" value="{$product->getId()}">
							</form>
						</div>

					{elseif !$price}
						<div class="add-to-cart-meta">
							<p><em>{t}This product is not in offer{/t}</em></p>
						</div>
					{else}

						<div class="add-to-cart-widget">

							{!$price_info}

							{if $price && $price->priceExists() && !WatchedProduct::IsWatchedProduct($product,$logged_user)}
								<p>
									{a action="watched_products/create_new" product_id=$product _class="btn btn-outline-primary" _rel="nofollow"}{!"dog"|icon} <span class="link__text">{t}Informovat o naskladnění{/t}</span>{/a}
								</p>
							{else}
								<p><em>{t}This product is sold out{/t}</em></p>
							{/if}

						</div>

					{/if}

						<div class="secondary-controls">
							<div class="secondary-controls__item">
								{render partial="shared/favourite_product_icon" product=$product}
								{if $basket->contains($product)}
									<span id="js--in_basket_notice_{$product->getId()}" class="link--small in_basket_notice">{!"cart-shopping"|icon} <span class="link__text">{t}Máte v košíku{/t}</span></span>
								{/if}
							</div>
							{if !$product->canBeOrdered($price_finder) && WatchedProduct::IsWatchedProduct($product,$logged_user)}
								<div class="secondary-controls__item">
									<span class="link--small">
										{!"dog"|icon} <span class="link__text">{t}Naskladnění sleduje hlídací pes{/t}</span>
									</span>
								</div>
							{/if}
						</div>

					</div>
				</div>

			{if $card->hasVariants()}
				</div>
			{/if}
		{/foreach}

		{if $card->hasVariants()}
			</div>
		{/if}

	{/if}

</section>
