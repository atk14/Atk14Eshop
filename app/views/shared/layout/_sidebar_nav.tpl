<ul class="nav flex-column accordion" id="sidebar_menu">

  {assign enable_dropdown_menus true}
  {assign menu LinkList::GetInstanceByCode("main_menu")}
  
  {foreach $menu->getItems($current_region) as $item}
		<li class="nav-item">

			{assign submenu ""}
			{if $enable_dropdown_menus && $enable_dropdown_menus!=="false"}
				{assign submenu $item->getSubmenu(["reasonable_max_items_count" => 20])}
			{/if}
			
			{if $submenu}
				<a href="{$item->getUrl()}" class="nav-link" id="sidebar_menu_item_{$item->getId()}" data-toggle="collapse" data-target="#sidebar_submenu_{$item->getId()}" aria-expanded="false" aria-controls="sidebar_submenu_{$item->getId()}">{$item->getTitle()}</a>
				<div class="flex-column collapse" id="sidebar_submenu_{$item->getId()}" aria-labelledby="sidebar_menu_item_{$item->getId()}" data-parent="#sidebar_menu">
					{foreach $submenu->getItems() as $subitem}
						<a href="{$subitem->getUrl()}" class="dropdown-item">{$subitem->getTitle()}</a>
					{/foreach}
				</div>
			{else}
				<a href="{$item->getUrl()}" class="nav-link" id="sidebar_menu_item_{$item->getId()}">{$item->getTitle()}</a>
			{/if}
		</li>
  {/foreach}
  
</ul>