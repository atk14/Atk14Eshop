<li class="list-group-item" data-id="{$warehouse->getId()}">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				{$warehouse->getName()}
			</div>
			<div>
				{dropdown_menu}
					{a action="warehouse_items/index" warehouse_id=$warehouse}{!"list"|icon} {t}Warehouse status{/t}{/a}
					{a action="edit" id=$warehouse}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{capture assign="confirm"}{t 1=$warehouse->getName()|h escape=no}You are about to permanently delete warehouse %1
		Are you sure about that?{/t}{/capture}
					{a_destroy id=$warehouse _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/dropdown_menu}
			</div>
	</div>	
</li>
