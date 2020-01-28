{if !$pager}
{assign var=pager value=$finder->getPager()}
{/if}
{assign var=items value=$finder->getRecords()}
{assign var=item_name value="`$pager->getItemVariable()`"} {* e.g. "item" *}

{if !$pager->isXhr()}
<div class='ajax_pager' data-count={count($finder->getRecords())} data-pager='{$pager->jsData()}' id='{$pager->getName()}'>
{/if}
	<a id="anchor--{$pager->getName()}-top" class="sr-only">&nbsp;</a>
	<div class="card-deck card-deck--sized-4 product-list js--pager-list">
		{render partial="shared/ajax_pager/ajax_pager_list"}
	</div>
	<div class="pagination-container">
		<div class="pager-buttons js--pager-buttons">
			{render partial="shared/ajax_pager/ajax_pager_buttons"}
		</div>
	</div>
{if !$pager->isXhr()}
</div>
{/if}

