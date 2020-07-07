<li class="list-group-item" data-id="{$product_type->getId()}">
	<div class="d-flex justify-content-between align-items-center">
		{$product_type->getName()}
		<div>
			{dropdown_menu}
				{a action=edit id=$product_type}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

				{if $product_type->isDeletable()}
					{capture assign="confirm"}{t 1=$product_type->getName()|h escape=no}You are about to permanently delete product type %1
Are you sure about that?{/t}{/capture}
					{a_destroy id=$product_type _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
