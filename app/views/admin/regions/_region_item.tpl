{assign currencies $region->getCurrencies()}
{assign delivery_countries $region->getDeliveryCountries()}

<li class="list-group-item" data-id="{$region->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{$region->getName()}
			</div>
			<div class="item__code">
				{$region->getCode()}
			</div>
			<div class="item__properties">
				<small>{t}Delivery to{/t}:</small><br>
				{$delivery_countries|to_sentence}
			</div>
			<div class="item__properties">
				<small>{if sizeof($currencies)==1}{t}Currency{/t}:{else}{t}Currencies{/t}:{/if}</small><br>
				{$currencies|to_sentence}
			</div>
			<div class="item__controls">
				{dropdown_menu}
					{a action="edit" id=$region}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{if $region->isDeletable()}
					{capture assign="confirm"}{t 1=$region->getName()|h escape=no}You are about to permanently delete VAT rate %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$region _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
