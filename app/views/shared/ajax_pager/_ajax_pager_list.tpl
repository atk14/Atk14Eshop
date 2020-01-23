{foreach from=$finder item=item}
	{if !$skip_first_three_items || $item@iteration>3}
	{assign var="`$pager->getItemVariable()`" value=$item} {* e.g. "item" *}
	{render partial=$pager->getItemTemplate()} {* e.g. "catalog/submenu_cell" *}
	{/if}
{/foreach}
