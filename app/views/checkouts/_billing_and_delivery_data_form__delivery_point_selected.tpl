<div class="form__body{if !$fill_in_invoice_address} nojs-only{/if}" id="invoice-address-fields">
	<h3 class="form__legend">{t}Fakturační údaje{/t}</h3>
	{render partial="shared/form_field" fields="firstname,lastname,company,company_number,vat_id,address_street,address_city,address_zip,address_country"}
</div>

<div class="form__body">
	<h3 class="form__legend">{t}Adresa pro doručení{/t} <small>{$basket->getDeliveryMethod()->getDeliveryService()}</small></h3>
	{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_phone,delivery_company,delivery_address_street,delivery_address_city,delivery_address_zip,delivery_address_country"}
</div>

