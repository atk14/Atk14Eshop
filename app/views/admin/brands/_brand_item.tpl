<li class="list-group-item" data-id="{$brand->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{render partial="shared/list_thumbnail" image=$brand->getLogoUrl()}
			{$brand->getName()}
		</div>
		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$brand}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
				{a namespace="" action="brands/detail" id=$brand}{!"eye"|icon} {t}Visit public link{/t}{/a}

				{if $brand->isDeletable()}
					{capture assign="confirm"}{t 1=$brand->getName()|h escape=no}You are about to permanently delete brand %1
	Are you sure about that?{/t}{/capture}
					{a_destroy id=$brand _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
