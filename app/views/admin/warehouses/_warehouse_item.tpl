<li class="list-group-item" data-id="{$warehouse->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{$warehouse->getName()}
			</div>
			<div class="item__properties">
				{if $warehouse->applicableToEshop()}
					<small class="text-center"><span title="{t}applicable to eshop{/t}" class="badge badge-success">{!"check"|icon}&nbsp;{t}eshop{/t}</span></small>
				{else}
					<small class="text-center"><span title="{t}not applicable to eshop{/t}" class="badge badge-secondary" style="opacity: 0.5;">{!"remove"|icon}&nbsp;{t}eshop{/t}</span></small>
				{/if}
			</div>
			<span class="item__code">
				{if $warehouse->getCode()|strlen}<small>{$warehouse->getCode()}</small>{/if}
			</span>
			<div class="item__controls">
				{dropdown_menu}
					{a action="warehouse_items/index" warehouse_id=$warehouse}{!"list"|icon} {t}Warehouse status{/t}{/a}
					{a action="edit" id=$warehouse}{!"pencil-alt"|icon} {t}Edit warehouse details{/t}{/a}
					{a action="warehouse_items/export" warehouse_id=$warehouse}{!"file-csv"|icon} {t}Export entries{/t}{/a}
					{a action="warehouse_items/import" warehouse_id=$warehouse}{!"file-import"|icon} {t}Import entries from CSV{/t}{/a}

					{capture assign="confirm"}{t 1=$warehouse->getName()|h escape=no}You are about to permanently delete warehouse %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$warehouse _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/dropdown_menu}
			</div>
	</div>	
</li>
