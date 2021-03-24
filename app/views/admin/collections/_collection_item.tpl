<li class="list-group-item" data-id="{$collection->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{render partial="shared/list_thumbnail" image=$collection->getImageUrl()}
			{$collection->getName()}
		</div>
		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$collection}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
				{a namespace="" action="collections/detail" id=$collection}{!"eye"|icon} {t}Visit public link{/t}{/a}

				{if $collection->isDeletable()}
					{capture assign="confirm"}{t 1=$collection->getName()|h escape=no}You are about to permanently delete collection %1
	Are you sure about that?{/t}{/capture}
					{a_destroy id=$collection _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}	
		</div>
	</div>
</li>
