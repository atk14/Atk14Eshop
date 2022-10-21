{assign current_category ""}
{if $controller=="categories" && $action=="detail"}
	{assign current_category $category}
{/if}
{if $controller=="cards" && $card}
	{assign current_category $card->getPrimaryCategory()}
{/if}

{assign root Category::GetInstanceByCode("catalog")}
{assign tree CategoryTree::GetInstance($root,["visible" => true, "is_filter" => false])}

<button class="sidebar-toggle js-sidebar-toggle"><span class="sidebar-toggle__text-hidden">{t}Zobrazit kategorie{/t}</span><span class="sidebar-toggle__text-shown">{t}Skrýt kategorie{/t}</span><span class="sidebar-toggle__icon">{!"chevron-down"|icon}</span></button>
<ul class="nav nav--sidebar" id="sidebar_menu">

	{foreach $tree as $node}
		{assign category $node->getCategory()}
		{assign active $current_category && $current_category->isDescendantOf($category)}

		{if $node->hasChilds()}
			<li class="nav-item nav-item--has-submenu">
				<a href="{link_to action="categories/detail" path=$node->getPath()}" class="nav-link{if $active} active{/if}" >{$category->getName()}</a>

				<span class="expander {if $active} {else} collapsed{/if}" role="button" id="sidebar_menu_item_{$node->getId()}" data-toggle="collapse" data-target="#sidebar_submenu_{$node->getId()}" aria-expanded="{if $active}true{else}false{/if}" aria-controls="sidebar_submenu_{$node->getId()}">{!"chevron-down"|icon}</span>

				{render partial="shared/layout/sidebar_nav_submenu" tree=$node active=$active}
			</li>
		{else}
			<li class="nav-item">
				<a href="{link_to action="categories/detail" path=$node->getPath()}" class="nav-link{if $active} active{/if}" id="sidebar_menu_item_{$node->getId()}">{$category->getName()}</a>
			</li>
		{/if}

	{/foreach}
	
</ul>
