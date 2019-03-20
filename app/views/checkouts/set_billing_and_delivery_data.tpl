{render partial="shared/checkout_navigation"}

<h1>{$page_title}</h1>

{if $delivery_addresses}

<ul class="list list--delivery_addresses">
	{foreach $delivery_addresses as $da name=addresscounter}
		{assign addresscounter $smarty.foreach.addresscounter.iteration}
		<li class="list__item">
			<div class="card card--default card--horizontal js--card-address {if $addresscounter == 1}card--active{/if}">
				{strip}
				<ul class="card__block list list--inline-psv">
					<li>{$da->getFirstname()} {$da->getLastname()}</li>
					{if $da->getCompany()}<li>{$da->getCompany()}</li>{/if}
					<li>{$da->getAddressStreet()}</li>
					{if $da->getAddressStreet2()}<li>{$da->getAddressStreet2()}</li>{/if}
					<li>{$da->getAddressCity()}</li>
					<li>{$da->getAddressZip()}</li>
					<li>{$da->getAddressCountry()|to_country_name}</li>
					{if $da->getAddressNote()}<li><em>{t}Poznámka:{/t} {$da->getAddressNote()}</em></li>{/if}
					<li>{t}telefon:{/t} {!$da->getPhone()|h|default:"&mdash;"}</li>
				</ul>
				{/strip}
				<div class="card__actions">
					<button class="js--predefined-address card__action" data-json="{$da->toJson()}">{!"cogs"|icon}<span class="sr-only">{t}Použít{/t}</span></button>
					{a_destroy action="delivery_addresses/destroy" id=$da->getId() _title="{t}Smazat adresu{/t}" _confirm="{t}Opravdu chcete smazat tuto adresu?{/t}" _class="card__action"}{!"remove"|icon}<span class="sr-only">{t}Smazat{/t}</span>{/a_destroy}
				</div>
			</div>
		</li>
	{/foreach}
</ul>
{/if}

{form _class="form" _novalidate="novalidate"}
	{render partial="shared/form_error"}

	{if $delivery_point_selected}
		{render partial="billing_and_delivery_data_form__delivery_point_selected"}
	{else}
	<div class="form__body">
		<h3 class="form__legend">{t}Adresa pro doručení{/t}</h3>
		{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_company,delivery_address_street,delivery_address_city,delivery_address_zip,delivery_address_country,delivery_address_note,delivery_phone"}
	</div>

		
	<div class="form__body">
		{render partial="shared/form_field" fields="fill_in_invoice_address"}
	</div>

	<div class="form__body{if !$fill_in_invoice_address} nojs-only{/if}" id="invoice-address-fields">
		<h3 class="form__legend">{t}Fakturační údaje{/t} <small>{t}(nepovinné){/t}</small></h3>
		{render partial="shared/form_field" fields="firstname,lastname,company,company_number,vat_id,address_street,address_city,address_zip,address_country"}
	</div>
	{/if}

	<div class="form__footer">
		{a action="checkouts/set_payment_and_delivery_method" _class="btn btn-lg btn-primary btn--back btn--arrow-l"}{t}Zpět na dopravu a platbu{/t}{/a}
		{render partial="shared/form_button" class="btn btn--cta btn-lg"}
	</div>
{/form}
