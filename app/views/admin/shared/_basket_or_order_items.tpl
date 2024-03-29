{capture assign=return_uri}{$request->getUri()}#order_items{/capture}
{assign tag_digital_product Tag::GetInstanceByCode("digital_product")}
{assign currency $object->getCurrency()}

<table class="table">
	<thead>
		<tr>
			<th></th>
			<th> {t escape=false}Kód produktu&nbsp;/&nbsp;EAN{/t} </th>
			<th> {t}Název produktu{/t} </th>
			<th> {t}Počet{/t} </th>
			<th> {t}Jedn. cena{/t} </th>
			<th> {t}Celk. cena{/t} </th>
			<th> {t}%DPH{/t} </th>
			<th> {t}Celkem s DPH{/t} </th>
			{if get_class($object)=="Order"}
				<th>{t}Sleva v kampani{/t}&nbsp;<span class="label label-default" title="{t}Ano = na položku byla poskytnuta sleva v kampani (např. 7% sleva za registraci). Ne = sleva v kampani poskytnuta nebyla, nejčastěji z důvodu poskytnutí slevy dle ceníku.{/t}">?</span></th>
			{/if}
			<th class="hidden-print"></th>
		</tr>
	</thead>
	<tbody>
		{foreach $object->getItems() as $item}
			{assign product $item->getProduct()}
			{assign card $product->getCard()}
			<tr>
				<td>{render partial="shared/list_thumbnail" image=$item->getProduct()->getImage()}</td>
				<td>{$product->getCatalogId()}</td>
				<td>
					{$product->getFullName()}
					{if $product->getCard()->containsTag($tag_digital_product)}
						<br><small><span class="badge badge-pill badge-secondary">{$tag_digital_product->getTagLocalized()}</span></small>
					{/if}
				</td>
				<td>{$item->getAmount()} {$product->getUnit()}</td>
				<td>{!$item->getUnitPrice()|display_price:"$currency"}</td>
				<td>{!$item->getPrice()|display_price:"$currency"}</td>
				<td>{!$item->getVatPercent()}%</td>
				<td>{!$item->getPriceInclVat()|display_price:"$currency"}</td>
				{if get_class($object)=="Order"}
					<td>{if !is_null($item->getCampaignDiscountApplied())}{!$item->getCampaignDiscountApplied()|display_bool}{else}{t}Neurčeno{/t}{/if}</td>
				{/if}
				<td class="hidden-print">
					
					{dropdown_menu}
						{if $show_order_items_editing_links && $item->isEditable()}
							{a action="order_items/edit" id=$item return_uri=$return_uri}{!"edit"|icon} {t}Upravit{/t}{/a}
						{/if}
						{if $card->isViewableInEshop()}
							{a namespace="" action="cards/detail" id=$card}{!"eye-open"|icon} {t}Zobrazit produkt v e-shopu{/t}{/a}
						{/if}
						{if $show_order_items_editing_links && $item->isDeletable()}
							{a_destroy action="order_items/destroy" id=$item}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
						{/if}
					{/dropdown_menu}

				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
