{if !$favourite_products}
	{capture assign="teaser"}{t}You haven`t added any items to your favourites yet.{/t}{/capture}
{else}
	{assign var=teaser ""}
{/if}

{render partial="shared/layout/content_header" title="$page_title" teaser=$teaser}

{if !$favourite_products}
		{capture assign="heart_icon"}<span class="text-danger">{!"heart"|icon}</span>{/capture}
		<p>{t heart_icon=$heart_icon escape=no}To add product to your favourites, click on %1 icon on product page.{/t}</p>
{else}

	<table class="table table--products table--products-simple table--fullheight-hack">
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
					{render partial="shared/product_price" product=$product fallback_message=$fallback_message}
				</td>
				<td class="table-products__item-actions">
						<div class="d-flex flex-column justify-content-between h-100">
							<div>{render partial="shared/favourite_product_icon" product=$product}</div>
							<div>
								{* form podobny jako u detailu produktu, lisi se 2x pridanim "sm" k css tride *}
								<form method="post" action="/en/baskets/add_product/" class="form_remote" data-remote="true">
									<div class="quantity-widget quantity-widget--sm js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Reduce the ordered quantity">-</button><input step="1" min="1" max="22" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_24" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Increase the ordered quantity">+</button>&nbsp;pcs</div>
									<button type="submit" class="btn btn-sm btn-primary add-to-cart-submit">Add to cart  <span class="fas fa-cart-plus"></span></button>
									<input type="hidden" name="product_id" value="24">
								</form>
							</div>
						</div>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

{/if}
