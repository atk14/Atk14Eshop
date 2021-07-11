{if !$favourite_products}
	{capture assign="teaser"}{t}You haven`t added any items to your wishlist yet.{/t}{/capture}
{else}
	{assign var=teaser ""}
{/if}

{render partial="shared/layout/content_header" title="$page_title" teaser=$teaser}

{if !$favourite_products}
		<p>{t escape=no}To add product to your wishlist, click on <span class="text-danger">{!"heart"|icon}</span> icon on product page.{/t}</p>
{else}

	<table class="table table--products table--products-simple">
		<tbody>
		{foreach $favourite_products as $fp}
			{assign product $fp->getProduct()}
			<tr>
				<td class="table-products__image">
					<a href="{$product|link_to_product}">
						{render partial="shared/product_image" product=$product image_size=80}
					</a>
				</td>
				<td class="table-products__title">
					<h4 class="product__title">
						<a href="{$product|link_to_product}">
						{$product->getName()}
						</a>
					<h4>
					<p class="product__number">{$product->getCatalogId()}</p>
				</td>
				<td class="table-products__stockcount">
					{display_stockcount product=$product}
				</td>
				<td class="table-products__price">
					{capture assign=fallback_message}<span class="text-secondary">{t}cena není stanovena{/t}</span>{/capture}
					{!$price_finder->getPrice($product)|display_price|default:$fallback_message}
				</td>
				<td class="table-products__item-actions">
					{render partial="shared/favourite_product_icon" product=$product}
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

{/if}
