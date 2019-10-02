<li class="list-group-item" data-id="{$region->getId()}">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				{$region->getName()}
			</div>
			<div>
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
