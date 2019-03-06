<li class="list-group-item" data-id="{$pricelist->getId()}">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				{$pricelist->getName()}
			</div>
			<div>
				{dropdown_menu}
					{a action="pricelist_items/index" pricelist_id=$pricelist}{!"list"|icon} {t}Prices{/t}{/a}
					{a action="edit" id=$pricelist}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{if $pricelist->isDeletable()}
					{capture assign="confirm"}{t 1=$pricelist->getName()|h escape=no}You are about to permanently delete pricelist %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$pricelist _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
