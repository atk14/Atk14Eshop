<li class="list-group-item" data-id="{$creator_role->getId()}">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			{$creator_role->getName()}
		</div>
		{if strlen($creator_role->getCode())}<small>{$creator_role->getCode()}</small>{/if}
		<div>
			{dropdown_menu}
				{a action=edit id=$creator_role}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

				{if $creator_role->isDeletable()}
					{capture assign="confirm"}{t 1=$creator_role->getName()|h escape=no}You are about to permanently delete creator role %1
	Are you sure about that?{/t}{/capture}
					{a_destroy id=$creator_role _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
