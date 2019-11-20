{render partial="shared/checkout_navigation"}

{render partial="shared/layout/content_header" title=$page_title}

{if $delivery_addresses}

<ul class="card-deck card-deck--sized-4 cards--addresses">
	{foreach $delivery_addresses as $da name=addresscounter}
		{assign addresscounter $smarty.foreach.addresscounter.iteration}
		<li class="card bg-light">
			<div class="card-body js--card-address {if $addresscounter == 1}card--active{/if}">
				{$da->getFirstname()} {$da->getLastname()}<br>
				{if $da->getCompany()}
					{$da->getCompany()}<br>
				{/if}
				{$da->getAddressStreet()}<br>
				{if $da->getAddressStreet2()}
					{$da->getAddressStreet2()}<br>
				{/if}
				{$da->getAddressCity()}<br>
				{$da->getAddressZip()}<br>
				{$da->getAddressCountry()|to_country_name}<br>
				{if $da->getAddressNote()}
					<em>{t}Poznámka:{/t} {$da->getAddressNote()}</em><br>
				{/if}
				{t}telefon:{/t} {!$da->getPhone()|h|default:"&mdash;"}
			</div>
			<div class="card-footer card__actions justify-content-start">
				<button class="js--predefined-address card__action btn btn-primary btn-sm" data-json="{$da->toJson()}">{!"check"|icon} <span>{t}Použít{/t}</span></button>
				&nbsp;
					{a_destroy action="delivery_addresses/destroy" id=$da->getId() _title="{t}Smazat adresu{/t}" _confirm="{t}Opravdu chcete smazat tuto adresu?{/t}" _class="card__action btn btn-secondary btn-sm"}{!"remove"|icon} <span>{t}Smazat{/t}</span>{/a_destroy}
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
		{a action="checkouts/set_payment_and_delivery_method" _class="btn btn-lg btn-secondary btn--back btn--arrow-l"}{t}Zpět na dopravu a platbu{/t}{/a}
		{render partial="shared/form_button" class="btn btn-primary btn-lg"}
	</div>
{/form}
