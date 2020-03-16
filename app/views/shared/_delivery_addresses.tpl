<ul class="card-deck card-deck--sized-4 cards--addresses">
	{foreach $delivery_addresses as $da}
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
				{t}telefon:{/t} {$da->getPhone()|display_phone|default:$mdash}
			</div>
			<div class="card-footer card__actions justify-content-start">
				{capture assign="confirm"}{t escape=false}Doručovací adresa bude smazána. Pokračovat?{/t}{/capture}
					{a _class="card__action btn btn-secondary btn-sm" action="edit" id=$da}{!"edit"|icon} <span>{t}upravit{/t}</span>{/a} &nbsp;
					{a_destroy _class="card__action btn btn-secondary btn-sm" action="destroy" id=$da _confirm=$confirm}{!"remove"|icon} <span>{t}smazat{/t}</span>{/a_destroy}
			</div>
		</li>
	{/foreach}
</ul>