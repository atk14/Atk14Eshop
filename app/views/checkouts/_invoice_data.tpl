<div class="form__body{if !$fill_in_invoice_address} nojs-only{/if}" id="invoice-address-fields">
	<h3 class="form__legend">{t}Fakturační údaje{/t} <small>{t}(nepovinné){/t}</small></h3>
	{render partial="shared/form_field" fields="firstname,lastname,company,company_number,vat_id,address_street,address_city,address_zip,address_country"}
</div>
