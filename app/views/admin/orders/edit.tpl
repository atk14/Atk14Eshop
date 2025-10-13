<h1>
	{$page_title}

	{render partial="action_buttons"}
</h1>

{form _class="form-horizontal"}

	{render partial="shared/form_error"}

	{*firstname,lastname,email,company,company_number,vat_id,address_street,address_street2,address_city,address_zip,address_country,address_note*}

	<fieldset>
		<legend>{t}Zákazník{/t}</legend>
		{render partial="shared/form_field" fields="firstname,lastname,email,phone"}
	</fieldset>

	<fieldset>
		<legend>{t}Fakturační adresa{/t}</legend>
		{render partial="shared/form_field" fields="company,company_number,vat_id,address_street,address_street2,address_city,address_state,address_zip,address_country,address_note"}
	</fieldset>

	<fieldset>
		<legend>{t}Doručovací adresa{/t}</legend>
		{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,delivery_company,delivery_address_street,delivery_address_street2,delivery_address_city,delivery_address_state,delivery_address_zip,delivery_address_country,delivery_address_note,delivery_phone"}
	</fieldset>

	<fieldset>
		<legend>{t}Doprava{/t}</legend>
		{render partial="shared/form_field" fields="delivery_method_id,delivery_fee_incl_vat,delivery_fee_vat_percent,tracking_number"}
	</fieldset>

	<fieldset>
		<legend>{t}Platba{/t}</legend>
		{render partial="shared/form_field" fields="payment_method_id,payment_fee_incl_vat,payment_fee_vat_percent"}
	</fieldset>

	<fieldset>
		<legend>{t}Ostatní{/t}</legend>
		{render partial="shared/form_field" fields="price_paid,note"}
	</fieldset>

	{render partial="shared/form_button"}

{/form}

<h3 id="order_items">{button_create_new action="order_items/create_new" order_id=$order return_to_anchor="order_items"}{/button_create_new} {t}Položky objednávky{/t}</h3>

{render partial="shared/basket_or_order_items" show_order_items_editing_links=1}

{render partial="campaigns"}

{render partial="vouchers"}

<h3>{t}Sumarizace cen{/t}</h3>

{assign currency $order->getCurrency()}

<table class="table">
	<tbody>

		<tr>
			<th>{t}Cena za zboží vč. DPH{/t}</th>
			<td align="right">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</td>
		</tr>

		<tr>
			<th>{t}Doprava a platba{/t}</th>
			<td align="right">{!$order->getShippingFeeInclVat()|display_price:"$currency"}</td>
		</tr>

		<tr>
			<th>{t}Slevová kampaň{/t}</th>
			<td align="right">{!(-$order->getCampaignsDiscountAmount())|display_price:"$currency"}</td>
		</tr>

		<tr>
			<th>{t}Slevové kupóny{/t}</th>
			<td align="right">{!(-$order->getVouchersDiscountAmount())|display_price:"$currency"}</td>
		</tr>

		<tr>
			<th>{t}Celkem k úhradě{/t}</th>
			<td align="right"><span class="h4">{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}</span></td>
		</tr>
	</tbody>
</table>
