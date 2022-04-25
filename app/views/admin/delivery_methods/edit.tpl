<h1>{$page_title}</h1>

{render partial="shared/form"}

<hr>

<h3 id="country-specifications">{t}Specifické hodnoty u podporovaných zemí{/t}</h3>

<table class="table">

	<thead>
		<tr>
			<th>{t}Země{/t}</th>
			<th>{t}Cena s DPH{/t}</th>
			<th>{t}Kód dopravy{/t}</th>
			<th></th>
		</tr>
	</thead>

	{capture assign=return_uri}{$request->getUri()}#country-specifications{/capture}

	<tbody>
	{foreach $countries as $country_code}
		{assign specification $delivery_method->getCountrySpecification($country_code)}
		<tr>
			<th>{$country_code|to_country_name}</th>
			{if $specification}
				<td>{!$specification->g("price_incl_vat")|display_price|default:$mdash}</td>
				<td>{$specification->g("code")|default:"—"}</td>
				<td>
					{dropdown_menu}
						{a action="delivery_method_country_specifications/edit" id=$specification return_uri=$return_uri}{t}Upravit{/t}{/a}
					{/dropdown_menu}
				</td>
			{else}
				<td>&mdash;</td>
				<td>&mdash;</td>
				<td>
					{dropdown_menu}
						{a action="delivery_method_country_specifications/create_new" delivery_method_id=$delivery_method country=$country_code return_uri=$return_uri}{t}Upravit{/t}{/a}
					{/dropdown_menu}
				</td>
			{/if}
		</tr>
	{/foreach}
	</tbody>

</table>
