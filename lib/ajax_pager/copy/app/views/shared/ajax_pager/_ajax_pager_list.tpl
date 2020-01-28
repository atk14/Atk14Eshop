{foreach from=$finder item=item}
	{assign var="`$pager->getItemVariable()`" value=$item}
	<li class="list__item">
		{render partial=$pager->getItemTemplate()}
	</li>
{/foreach}
