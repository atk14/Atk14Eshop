{assign tag_digital_product Tag::GetInstanceByCode("digital_product")}
{assign incl_vat $basket->displayPricesInclVat()}

		<tbody class="table-products__list">

			{* Produkty *}
			{foreach $basket->getItems() as $item}
				{assign product $item->getProduct()}
				{assign price $item->getProductPrice()}
				<tr class="table-products__item">
					<td class="table-products__image">{a namespace="" action="cards/detail" id=$product->getCardId()}{!$product->getImage()|pupiq_img:"120x120x#ffffff"}{/a}</td>
					<td class="table-products__title">
						{a namespace="" action="cards/detail" id=$product->getCardId()}{$product->getName()}{/a}
						{if $product->getCard()->containsTag($tag_digital_product)}
							<br><small><span class="badge badge-pill badge-secondary">{$tag_digital_product->getTagLocalized()}</span></small>
						{/if}
						<span class="d-block d-lg-none table-products__id"><span class="property__key">{t}Kód{/t}</span>{$product->getCatalogId()}</span>
					</td>
					<td class="table-products__id"><span class="d-none d-lg-inline">{$product->getCatalogId()}</span></td>
					<td class="js--unit_price table-products__unit-price"><span class="property__key">{if $incl_vat}{t}Jedn. cena{/t}{else}{t}Jedn. cena bez DPH{/t}{/if}</span> {render partial="baskets/unit_price" unit=$product->getUnit()}</td>
					{if !$incl_vat}
					<td class="table-products__vat-percent"><span class="property__key">{t escape=no}%&nbsp;DPH{/t}</span>{if $price}{$price->getVatPercent()}{/if}</td>
					{/if}
					<td class="table-products__amount" data-url="{link_to namespace="api" controller="basket_items" action="add" product=$product->getId() format='json'}">
						<span class="property__key">{t}Množství{/t}</span>
						{*$item->getAmount()*}
						{capture assign=field_key}i{$item->getId()}{/capture}
						{!$form|field:$field_key}
					</td>
					<td class="js--price table-products__price">
						<span class="property__key">{if $incl_vat}{t}Celkem{/t}{else}{t}Celkem bez DPH{/t}{/if}</span>{render partial="baskets/price"}</td>
					<td class="table-products__item-actions">
						{capture assign="url"}{link_to namespace="api" controller="basket_items" action="destroy" product=$item->getProductId() format='json' _connector='&'}{/capture}
						{a namespace="" action="basket_items/destroy" _data-url="$url" id=$item _method=post _confirm="{t}Opravdu chcete odstranit tento produkt z nákupního košíku?{/t}" _title="{t}odstranit z košíku{/t}" _class="js--basket-destroy"}{!"remove"|icon}{/a}
					</td>
				</tr>
			{/foreach}

		</tbody>
