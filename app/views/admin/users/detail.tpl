<div class="pull-right">{render partial="dropdown_menu"}</div>

<h1>{$page_title}</h1>

<table class="table">
	<tbody>
		<tr>
			<th>{t}Přihlašovací jméno{/t}</th>
			<td>{$user->getLogin()}</td>
		</tr>
		<tr>
			<th>{t}E-mail{/t}</th>
			<td>{$user->getEmail()}</td>
		</tr>
		<tr>
			<th>{t}Jméno{/t}, {t}oslovení{/t}</th>
			<td>{$user->getName()}{if $user->getGender()}, {$user->getGender()}{/if}</td>
		</tr>
		<tr>
			<th>{t escape=false}Role &amp; stavy{/t}</th>
			<td>
				<ul>
					{if $user->isAdmin()}<li>{t}administrátor{/t}</li>{/if}
				</ul>
			</td>
		</tr>
		<tr>
			<th>{t}Firma{/t}</th>
			<td>
				Název: {$user->getCompany()|default:"-"}<br>
				IČ: {$user->getCompanyNumber()|default:"-"}<br>
				DIČ: {$user->getVatId()|default:"-"}
			</td>
		</tr>
		<tr>
			<th>{t}Fakturační adresa{/t}</th>
			<td>
				{$user->getAddressStreet()}<br>
				{if $user->getAddressStreet2()}{$user->getAddressStreet2()}<br>{/if}
				{$user->getAddressZip()} {$user->getAddressCity()}<br>
				{$user->getAddressCountry()|to_country_name}
			</td>
		</tr>
		<tr>
			<th>{t}Doručovací adresy{/t}</th>
			<td>
{if $delivery_addresses}
	<ul>
		{foreach $delivery_addresses as $address}
			<li>
				{if $address->getName()}{$address->getName()}<br>{/if}
				{if $address->getCompany()}{$address->getCompany()}<br>{/if}
				{$address->getAddressStreet()}<br>
				{if $address->getAddressStreet2()}{$address->getAddressStreet2()}<br>{/if}
				{$address->getAddressZip()} {$address->getAddressCity()}<br>
				{$address->getAddressCountry()|to_country_name}
			</li>
		{/foreach}
	</ul>
{/if}
			</td>
		</tr>
		<tr>
			<th>{t}Telefon{/t}</th>
			<td>{$user->getPhone()|default:"-"}</td>
		</tr>
		<tr>
			<th>{t}Datum narození{/t}</th>
			<td>{$user->getBirthday()|format_date|default:"-"}</td>
		</tr>
	</tbody>
</table>

<h3>Objednávky</h3>
{if $orders}
	<table class="table">
		<thead>
			<tr>
				<th>{t}Číslo objednávky{/t}</th>
				<th>{t}Datum vytvoření{/t}</th>
				<th>{t}Celk. cena{/t}</th>
				<th>{t}Stav objednávky{/t}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial=order_item from=$orders item=order}
		</tbody>
	</table>
{else}
	<p><em>{t}Uživatel nevytvořil žádnou objednávku{/t}</em></p>
{/if}

