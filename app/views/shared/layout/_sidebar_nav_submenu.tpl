<ul class="nav nav--sidebar__submenu collapse{if $active} show{/if}" id="sidebar_submenu_{$node->getId()}" aria-labelledby="sidebar_menu_item_{$node->getId()}">

{foreach $tree as $node}
	{assign category $node->getCategory()}
	{assign active $current_node && $current_node->isDescendantOf($node)}

			{if $node->hasChilds()}
			<li class="nav-item nav-item--has-submenu">
				<a href="{link_to action="categories/detail" path=$node->getPath()}" class="nav-link{if $active} active{else} collapsed{/if}">{$category->getName()}</a>

				<span class="expander {if $active} {else} collapsed{/if}" role="button" id="sidebar_menu_item_{$node->getId()}" data-bs-toggle="collapse" data-bs-target="#sidebar_submenu_{$node->getId()}" aria-expanded="{if $active}true{else}false{/if}" aria-controls="sidebar_submenu_{$node->getId()}" aria-label="{t}Expand submenu{/t}">{!"chevron-down"|icon}</span>

				{render partial="shared/layout/sidebar_nav_submenu" tree=$node active=$active parent_sidebar_id="sidebar_submenu_{$node->getId()}"}
			</li>

		{else}
			<li class="nav-item">
				<a href="{link_to action="categories/detail" path=$node->getPath()}" class="nav-link{if $active} active{/if}" id="sidebar_menu_item_{$node->getId()}">{$category->getName()}</a>
			</li>
		{/if}

{/foreach}

</ul>
