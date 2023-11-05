{t escape=no}Vážený zákazníku,{/t}<br/><br/>

{render partial="thanks_for_order_lower.html"}

{if $special_note}
	
	{render partial="partials/title_box" content=$special_note|h|nl2br titlebg="{$special_note_bgcolor}" titlecolor="{$special_note_color}" space_before=0}
{/if}

{t}V případě osobního odběru vyčkejte na výzvu k vyzvednutí. Pokud jste zvolili úhradu bankovním převodem, podklady k úhradě objednávky Vám budou zaslány obratem.{/t}

{if $shipping_days|strlen}
	{if $shipping_days=="3-5"}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dní od připsání platby na náš bankovní účet.{/t}
	{else}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dnů od připsání platby na náš bankovní účet.{/t}
	{/if}
{/if}

<br/><br/>

{render partial="partials/title_box" content="{t}Detaily objednávky{/t}"}

{t order_no=$order->getOrderNo() created_at=$order->getCreatedAt()|format_datetime escape=no}Objednávka: <strong>č. %1 vytvořená %2</strong>{/t}<br/>
{t}Platba:{/t} <strong>{$order->getPaymentMethod()}</strong>

<br/>
<br/>

<table style="width: 100%; font-family: {$font_stack}; font-size: 11px; color: #374953;"><!-- Title -->
<tbody>
<tr style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; text-align: center;">
	<th style="width: 15%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Kód{/t}</th>
	<th style="width: 30%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Produkt{/t}</th>
	<th style="width: 20%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Jedn. cena{/t}</th>
	<th style="width: 15%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Množství{/t}</th>
	<th style="width: 20%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Cena celkem{/t}</th>
</tr>
{foreach $order->getItems() as $item}
	{assign product $item->getProduct()}
	<tr style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">
		{if $product->getCode()=="price_rounding"}
			<td style="padding: 0.6em 0.4em;width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em;width: 30%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"><strong>{$product->getName()}</strong></td>
			<td style="padding: 0.6em 0.4em; width: 20%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em; width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em; width: 20%;text-align:right; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
		{else}
			<td style="padding: 0.6em 0.4em;width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{$product->getCatalogId()}</td>
			<td style="padding: 0.6em 0.4em;width: 30%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"><strong><a href="{$product|link_to_product:"with_hostname=$default_domain"}" style="color:{$table_cell_color};">{$product->getName()}</a></strong></td>
			<td style="padding: 0.6em 0.4em; width: 20%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getUnitPriceInclVat()|display_price:"$currency"}</td>
			<td style="padding: 0.6em 0.4em; width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{$item->getAmount()} {$product->getUnit()}</td>
			<td style="padding: 0.6em 0.4em; width: 20%;text-align:right; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
		{/if}
	</tr>
{/foreach}
<tr style="text-align: right;">
	<td style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; padding: 0.6em 0.4em;" colspan="4">{t}Cena celkem{/t}</td>
	<td style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; padding: 0.6em 0.4em;">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</td>
</tr>

</tbody>
</table>
<table style="width: 100%; font-family:
{$font_stack}; font-size: 11px;"><colgroup><col style="width: 15%; padding: 0.6em 0;" /> <col style="width: 30%; padding: 0.6em 0;" /> <col style="width: 20%; padding: 0.6em 0;" /> <col style="width: 15%; padding: 0.6em 0;" /> <col style="width: 20%; padding: 0.6em 0;" /> </colgroup>
<tbody>
	{foreach $order->getVouchers() as $voucher}
		<tr style="text-align: right;">
			<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{$voucher->getDescription()} {$voucher}</td>
			<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">{if $voucher->getDiscountAmount()}-{!$voucher->getDiscountAmount()|display_price:"$currency"}{/if}</td>
		</tr>
	{/foreach}
	{foreach $order->getCampaigns() as $campaign}
		{if $campaign->getDiscountAmount()}
			<tr style="text-align: right;">
				<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{$campaign}</td>
				<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">-{!$campaign->getDiscountAmount()|display_price:"$currency"}</td>
			</tr>
		{/if}
	{/foreach}
	<tr style="text-align: right;">
		<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{t}Doprava{/t}</td>
		<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">{!$order->getShippingFeeInclVat()|display_price:"$currency"|default:$mdash}</td>
	</tr>
	<tr style="text-align: right; font-weight: bold;">
		<td style="background-color: {$table_accent_bgcolor}; color:{$table_accent_color}; padding: 0.6em 0.4em;" colspan="4">{t}Celkem k úhradě{/t}</td>
		<td style="background-color: {$table_accent_bgcolor}; color:{$table_accent_color}; padding: 0.6em 0.4em;">{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}{if is_null($order->getShippingFeeInclVat())}<sup>*</sup>{/if}</td>
	</tr>
</tbody>
</table>

{if is_null($order->getShippingFeeInclVat())}
	<small><sup>*</sup> {t}Uvedená konečná cena neobsahuje poplatek za dopravu.{/t}</small><br/><br/>
{/if}

{render partial="partials/title_box" content="{t}Přeprava{/t}"}

{t}Dopravce:{/t} <strong>{$order->getDeliveryMethod()}</strong>

<br/><br/>

<table style="width: 100%; font-family: {$font_stack}; font-size: 11px; color: #374953;">
	<tbody>
		<tr style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; text-transform: uppercase;"><th style="width: 50%; text-align: left; padding: 0.3em 1em; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Dodací adresa{/t}</th><th style="width: 50%; text-align: left; padding: 0.3em 1em; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Fakturační adresa{/t}</th></tr>
		<tr>
		<td style="padding: 0.5em 0 0.5em 0.5em; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};" valign="top">
			{render partial="shared/order/delivery_address"}
		</td>
		<td style="padding: 0.5em 0 0.5em 0.5em; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};" valign="top">
			{render partial="shared/order/invoice_address"}
		</td>
		</tr>
	</tbody>
</table>

{if $order->getNote()}
	<br/>
	{t}Vaše poznámka k objednávce:{/t} {!$order->getNote()|h|nl2br}
{/if}

{if $order->getPaymentMethod()->isOnlineMethod()}
	{capture assign=order_finish_url}{link_to namespace="" action="orders/finish" token=$order->getToken() _with_hostname=true _ssl=REDIRECT_TO_SSL_AUTOMATICALLY}{/capture}
	<br/><br/>
	{t}Pokud Vám spadl prohlížeč před dokončením platby, pokračujte na tomto URL:{/t}
	<a href="{$order_finish_url}" style="{$link_style}"><span style="{$link_style}">{$order_finish_url}</span></a>
{/if}

{render partial="order_status_check_notice.html"}
