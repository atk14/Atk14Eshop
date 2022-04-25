<li class="list-group-item" data-id="{$vat_rate->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{$vat_rate->getName()} &mdash; {$vat_rate->getVatPercent()}%
			</div>
			<span class="item__code">
				{if strlen($vat_rate->getCode())}{$vat_rate->getCode()}{/if}
			</span>
			<div class="item__controls">
				{dropdown_menu}
					{a action="edit" id=$vat_rate}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{if $vat_rate->isDeletable()}
					{capture assign="confirm"}{t 1=$vat_rate->getName()|h escape=no}You are about to permanently delete VAT rate %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$vat_rate _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
