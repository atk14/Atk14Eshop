{if !$pager}
{assign var=pager value=$finder->getPager()}
{/if}

{if !$pager->isXhr()}
<div class='ajax_pager' data-pager='{$pager->jsData()}' id='{$pager->getName()}'>
{/if}
	<a name="{$pager->getName()}_top_href">
	<ul class="list list--base-4 list--products js--pager-list">
		{render partial="shared/ajax_pager/ajax_pager_list"}
	</ul>
{if !$pager->isXhr()}
	{render partial="shared/ajax_pager/ajax_pager_buttons"}
	</ul>
{/if}
