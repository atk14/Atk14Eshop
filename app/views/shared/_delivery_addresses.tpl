<ul class="card-deck card-deck--sized-4 cards--addresses">
	{foreach $delivery_addresses as $da}
		<li class="card bg-light">
			<div class="card-body js--card-address {if $addresscounter == 1}card--active{/if}">
				{render partial="shared/delivery_address" delivery_address=$da}
			</div>
			<div class="card-footer card__actions justify-content-start">
				{capture assign="confirm"}{t escape=false}Doručovací adresa bude smazána. Pokračovat?{/t}{/capture}
					{a _class="card__action btn btn-secondary btn-sm" action="edit" id=$da}{!"edit"|icon} <span>{t}upravit{/t}</span>{/a} &nbsp;
					{a_destroy _class="card__action btn btn-secondary btn-sm" action="destroy" id=$da _confirm=$confirm}{!"remove"|icon} <span>{t}smazat{/t}</span>{/a_destroy}
			</div>
		</li>
	{/foreach}
</ul>
