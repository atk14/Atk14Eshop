<ul class="nav accordion nav--sidebar" id="sidebar_menu">
	{assign active_item 13}{* active item in 1st level - fake value for development *}
	
  {assign enable_dropdown_menus true}
  {assign menu LinkList::GetInstanceByCode("main_menu")}
  
  {foreach $menu->getItems($current_region) as $item}
	{assign submenu ""}
	{if $enable_dropdown_menus && $enable_dropdown_menus!=="false"}
		{assign submenu $item->getSubmenu(["reasonable_max_items_count" => 20])}
	{/if}
	{if $item->getId() == $active_item}
		{assign active 1}
	{else}
		{assign active 0}
	{/if}
	
		<li class="nav-item">
			
			{if $submenu}

			<a href="{$item->getUrl()}" class="nav-link{if $active} active{else} collapsed{/if}" id="sidebar_menu_item_{$item->getId()}" data-toggle="collapse" data-target="#sidebar_submenu_{$item->getId()}" aria-expanded="false" aria-controls="sidebar_submenu_{$item->getId()}">{$item->getTitle()}</a>

			<ul class="nav nav--sidebar__submenu collapse{if $active} show{/if}" id="sidebar_submenu_{$item->getId()}" aria-labelledby="sidebar_menu_item_{$item->getId()}" data-parent="#sidebar_menu">
				{foreach $submenu->getItems() as $subitem}
					{* TODO: pokud se jedna o aktivni polozku, nastavit $active_subitem na 1*}
					<li class="nav-item">
						<a href="{$subitem->getUrl()}" class="nav-link{if $active_subitem} active{/if}">{$subitem->getTitle()}</a>
					</li>
				{/foreach}
			</ul>

			{else}

				<a href="{$item->getUrl()}" class="nav-link" id="sidebar_menu_item_{$item->getId()}">{$item->getTitle()}</a>

			{/if}

		</li>
  {/foreach}
  
</ul>