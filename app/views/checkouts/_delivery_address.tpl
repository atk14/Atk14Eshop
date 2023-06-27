{if $delivery_point_selected}

<div class="form__body">
	<h3 class="form__legend">{t}Kontaktní údaje pro vyzvednutí zásilky{/t}</h3>
	{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_phone"}
</div>

<div class="form__body">
	<h3 class="form__legend">{t}Adresa výdejního místa{/t}</h3>
	{render partial="shared/form_field" fields="delivery_company,delivery_address_street,delivery_address_city,delivery_address_state,delivery_address_zip,delivery_address_country"} {* tady chubi delivery_address_note - je to disablovane policko a je matouci *}
</div>

{else}

<div class="form__body">
	<h3 class="form__legend">{t}Adresa pro doručení{/t}</h3>
	{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_phone,delivery_company,delivery_address_street,delivery_address_city,delivery_address_state,delivery_address_zip,delivery_address_country,delivery_address_note"}
</div>

{/if}
