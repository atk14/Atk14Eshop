{assign currency $order->getCurrency()}
{assign max_product_count 10}
{assign product_count 0}
{assign is_max_count 0}
<tr>
	{highlight_search_query}
	<td><span class="table-hint-xs">{t}Číslo objednávky{/t}</span> {a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}</td>
	{/highlight_search_query}
	<td class="text-sm-right"><span class="table-hint-xs">{t}Cena{/t}</span> {!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
	<td><span class="table-hint-xs">{t}Datum vytvoření{/t}</span> {$order->getCreatedAt()|format_date}</td>
	<td><span class="table-hint-xs">{t}Stav{/t}</span> {render partial="shared/order_status" order=$order}</td>
	<td class="order__thumbnails">
		<div class="card-thumbnails">
		{foreach $order->getItems() as $item}
			{assign product $item->getProduct()}
			{assign image $product->getImage()}
			{if $image && $product_count==$max_product_count}
				<a href="#" class="card-thumbnails__more js--card-thumbnails__more" title="{t}Show more{/t}">{!"ellipsis"|icon}</a>
				{assign is_max_count true}
			{/if}
			{if $image}
				<a href="{$product|link_to_product}" class="{if $is_max_count}d-none was-hidden"{/if}">
				{if $item->getAmount()>1}
				<span class="badge badge-pill badge-success">{$item->getAmount()}&times;</span>
				{/if}
				<img {!$image|img_attrs:"60x60x#ffffff"} title="{$product->getName()}">
				</a>
				{assign product_count $product_count+1}
			{/if}
		{/foreach}
		</div>
		{if $order->canBeFulfilled() && $order->hasDigitalContents()}<a href="{link_to action="digital_contents/index" order_token=$order->getToken(DigitalContent::GetOrderTokenOptions())}">{!"cloud-download-alt"|icon} {t}Stáhnout digitální produkty{/t}</a>{/if}
	</td>
	{*
	<td class="text-sm-right">{if $order->canBeFulfilled() && $order->hasDigitalContents()}<a href="{link_to action="digital_contents/index" order_token=$order->getToken(DigitalContent::GetOrderTokenOptions())}" class="btn btn-sm btn-primary">{!"cloud-download-alt"|icon} {t}Stáhnout digitální produkty{/t}</a>{/if}</td>
	*}
	{* <td class="text-sm-right"><span class="table-hint-xs">{t}Faktura{/t}</span>{a}{t}Faktura{/t} #######{/a}</td> *}
</tr>
