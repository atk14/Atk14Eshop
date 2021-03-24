<li class="list-group-item" data-id="{$region->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{$region->getName()}
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
