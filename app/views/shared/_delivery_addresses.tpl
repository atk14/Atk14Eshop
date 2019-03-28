<ul class="list list--delivery_addresses">
	{foreach $delivery_addresses as $da}
		<li class="list__item">
			<div class="card card--default card--horizontal">
				{strip}
				<ul class="card__block list list--inline-psv list--location">
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
					{capture assign="confirm"}{t escape=false}Doručovací adresa bude smazána. Pokračovat?{/t}{/capture}
					{a _class="card__action" action="edit" id=$da}<i class="icon ion-gear-a"></i><span class="sr-only">{t}upravit{/t}</span>{/a}
					{a_destroy _class="card__action" action="destroy" id=$da _confirm=$confirm}<i class="icon ion-close"></i><span class="sr-only">{t}smazat{/t}</span>{/a_destroy}
				</div>
			</div>
		</li>
	{/foreach}
</ul>
