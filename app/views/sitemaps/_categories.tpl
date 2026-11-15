{if $categories}
<ul class="list--tree">

{foreach $categories as $category}

	{if $category->isVisible() && !$category->isFilter() && !$category->isAlias()}

	<li>
		{a action="categories/detail" path=$category->getPath() _with_hostname=1}{$category->getName()}{/a}
		{render partial="categories" categories=$category->getChildCategories()}
	</li>

	{/if}

{/foreach}

</ul>
{/if}
