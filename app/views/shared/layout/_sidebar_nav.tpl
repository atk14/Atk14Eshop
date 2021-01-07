{assign current_category ""}
{if $controller=="categories" && $action=="detail"}
	{assign current_category $category}
{/if}

{assign root Category::GetInstanceByCode("catalog")}
{assign tree CategoryTree::GetInstance($root,["visible" => true, "is_filter" => false])}

<ul class="nav accordion nav--sidebar" id="sidebar_menu">

	{foreach $tree as $node}
		{assign category $node->getCategory()}
		{assign active $current_category && $current_category->isDescendantOf($category)}

		<li class="nav-item">
			{if $node->hasChilds()}

				<a href="{link_to action="categories/detail" path=$category->getPath()}" class="nav-link{if $active} active{else} collapsed{/if}" id="sidebar_menu_item_{$node->getId()}" data-toggle="collapse" data-target="#sidebar_submenu_{$node->getId()}" aria-expanded="false" aria-controls="sidebar_submenu_{$node->getId()}">{$category->getName()}</a>

				<ul class="nav nav--sidebar__submenu collapse{if $active} show{/if}" id="sidebar_submenu_{$node->getId()}" aria-labelledby="sidebar_menu_item_{$node->getId()}" data-parent="#sidebar_menu">
					{foreach $node->getChildNodes() as $subnode}
						{assign subcategory $subnode->getCategory()}
						{assign active_subitem $current_category && $current_category->isDescendantOf($subcategory)}

						{* TODO: pokud se jedna o aktivni polozku, nastavit $active_subitem na 1*}
						<li class="nav-item">
							<a href="{link_to action="categories/detail" path=$subcategory->getPath()}" class="nav-link{if $active_subitem} active{/if}">{$subcategory->getName()}</a>
						</li>
					{/foreach}
				</ul>
				
			{else}

				<a href="{link_to action="categories/detail" path=$category->getPath()}" class="nav-link{if $active} active{/if}" id="sidebar_menu_item_{$node->getId()}">{$category->getName()}</a>

			{/if}
		</li>

	{/foreach}
	
</ul>
