{if $basket->isEmpty()}
	<div class="basket-content__empty">
		{t}The shopping basket is empty.{/t}
	</div>
{else}

	{assign incl_vat $basket->displayPricesInclVat()}
	{assign currency $basket->getCurrency()}
	<div class="basket-content__items" data-items-count="{$basket->getItems()|count}">
		<table class="table--offcanvas-basket">
			<tbody>
				{foreach $basket->getItems() as $item}
				{assign product $item->getProduct()}
				{assign unit $product->getUnit()}
				{assign price $item->getProductPrice()}
				<tr class="item">
					<td class="item__image">
						<a href="{$product|link_to_product}" aria-label="{$product->getName()} - {t}Product detail{/t}">
							<img {!$product->getImage()|img_attrs:"80x80x#ffffff"}></td>
						</a>
					<td class="item__name">
						<a href="{$product|link_to_product}">{$product->getName()}</a>
					</td>
					<td class="item__quantity">
						<div class="quantity-widget quantity-widget--sm">
							{if $item->canAmountBeDecreased()}
								{a_remote namespace="" action="basket_items/decrease_amount" id=$item _method=post _class="btn btn-sm btn-outline-secondary"}-{/a_remote}
							{else}
								<button class="btn btn-sm btn-outline-secondary" disabled>-</button>
							{/if}
							<span class="quantity-widget__number">{$item->getAmount()} {$unit}</span>
							{if $item->canAmountBeIncreased()}
								{a_remote namespace="" action="basket_items/increase_amount" id=$item _method=post _class="btn btn-sm btn-outline-secondary"}+{/a_remote}
							{else}
								<button class="btn btn-sm btn-outline-secondary" disabled>+</button>
							{/if}
						</div>
					</td>
					<td class="item__price">{render partial="shared/offcanvas_basket/price" price=$price}</td>
					<td class="item__actions">{a_remote namespace="" action="basket_items/destroy" id=$item _method=post _confirm="{t}Opravdu chcete odstranit tento produkt z nákupního košíku?{/t}"}{!"remove"|icon}{/a_remote}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
	<div class="basket-content__total">
		<div class="description">{t}Total price{/t}:</div>
		<div class="price">{!$basket->getItemsPrice($incl_vat)|display_price:"$currency,summary"}</div>
	</div>	

{/if}
