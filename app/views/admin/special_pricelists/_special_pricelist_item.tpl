<li class="list-group-item" data-id="{$special_pricelist->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{$special_pricelist->getName()}
			</div>
			<span class="item__code">
				{if $special_pricelist->getCode()|strlen}<small>{$special_pricelist->getCode()}</small>{/if}
			</span>
			<div class="item__controls">
				{dropdown_menu}
					{a action="special_pricelist_items/index" special_pricelist_id=$special_pricelist}{!"list"|icon} {t}Prices{/t}{/a}
					{a action="edit" id=$special_pricelist}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{if $special_pricelist->isDeletable()}
					{capture assign="confirm"}{t 1=$special_pricelist->getName()|h escape=no}You are about to permanently delete special pricelist %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$special_pricelist _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
