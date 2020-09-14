{*
 *
 *	{render partial="shared/layout/header/main_menu" menu="main_menu"}
 *	{render partial="shared/layout/header/main_menu" menu="main_menu" nav_class="navbar-nav" enable_dropdown_menus=false}
 *}

{if !isset($menu)}{assign menu "main_menu"}{/if}
{if !isset($enable_dropdown_menus)}{assign enable_dropdown_menus true}{/if}
{if !isset($nav_class)}{assign nav_class true}{/if}
{assign main_menu LinkList::GetInstanceByCode($menu)}
{if $main_menu}
	<ul class="{$nav_class}">

			{foreach $main_menu->getItems($current_region) as $item}

					{assign submenu ""}
					{if $enable_dropdown_menus && $enable_dropdown_menus!=="false"}
						{assign submenu $item->getSubmenu(["reasonable_max_items_count" => 20])}
					{/if}

					{if $submenu}
						<li class="nav-item dropdown">
								<a href="{$item->getUrl()}" class="nav-link dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$item->getTitle()}</a>
								<div class="dropdown-menu">
									{foreach $submenu->getItems() as $subitem}
										<a href="{$subitem->getUrl()}" class="dropdown-item">{$subitem->getTitle()}</a>
									{/foreach}
								</div>
						</li>
					{else}
						<li class="nav-item">
							<a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a>
						</li>
					{/if}

			{/foreach}

	</ul>
{/if}