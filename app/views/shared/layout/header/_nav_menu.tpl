{*
 *	{render partial="shared/layout/header/nav_menu" menu=LinkList::GetInstanceByCode("main_menu")}
 *
 *	{render partial="shared/layout/header/nav_menu" menu="main_menu"}
 *	{render partial="shared/layout/header/nav_menu" menu="main_menu" nav_class="navbar-nav" enable_dropdown_menus=false dropdown_class="dropdown-menu--dark bg-dark dropdown-menu--transparent dropdown-highlight-danger"}
 *}

{if !isset($enable_dropdown_menus)}{assign enable_dropdown_menus true}{/if}
{if !isset($nav_class)}{assign nav_class true}{/if}

{if is_string($menu)}
	{assign menu LinkList::GetInstanceByCode($menu)}
{/if}

{if $menu && !$menu->isEmpty()}
	<ul class="{$nav_class}">

			{foreach $menu->getVisibleItems($current_region) as $item}

					{assign submenu ""}
					{if $enable_dropdown_menus && $enable_dropdown_menus!=="false"}
						{assign submenu $item->getSubmenu(["reasonable_max_items_count" => 20])}
					{/if}

					{if $submenu}
						<li class="nav-item dropdown{if $item->getCssClass()} {$item->getCssClass()}{/if}">
								<a href="{$item->getUrl()}" class="nav-link dropdown-toggle"  data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$item->getTitle()}</a>
								<div class="dropdown-menu {$dropdown_class}">
									{foreach $submenu->getItems() as $subitem}
										<a href="{$subitem->getUrl()}" class="dropdown-item{if $subitem->getCssClass()} {$subitem->getCssClass()}{/if}">{!$subitem->getTitle()}</a>
									{/foreach}
								</div>
						</li>
					{else}
						<li class="nav-item{if $item->getCssClass()} {$item->getCssClass()}{/if}">
							<a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a>
						</li>
					{/if}

			{/foreach}

	</ul>
{/if}
