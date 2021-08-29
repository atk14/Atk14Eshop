<li class="list-group-item" data-id="{$customer_group->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{$customer_group->getName()}
		</div>

		<div class="item__code">
			{$customer_group->getCode()}
		</div>

		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$customer_group}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

				{if $customer_group->isDeletable()}
					{capture assign="confirm"}{t 1=$customer_group->getName()|h escape=no}You are about to permanently delete customer group %1.
Are you sure about that?{/t}{/capture}
					{a_destroy id=$customer_group _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
