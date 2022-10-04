<li class="list-group-item" data-id="{$creator_role->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{$creator_role->getName()}
		</div>
		<span class="item__code">
			{if $creator_role->getCode()|strlen}{$creator_role->getCode()}{/if}
		</span>
		<div class="item__controls">
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
