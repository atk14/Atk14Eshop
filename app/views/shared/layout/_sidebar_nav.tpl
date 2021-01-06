<ul class="nav flex-column">

  {assign enable_dropdown_menus true}
  {assign menu LinkList::GetInstanceByCode("main_menu")}
  
  {foreach $menu->getItems($current_region) as $item}
		<li class="nav-item">
			<a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a>

			{assign submenu ""}
			{if $enable_dropdown_menus && $enable_dropdown_menus!=="false"}
				{assign submenu $item->getSubmenu(["reasonable_max_items_count" => 20])}
				{if $submenu}

					<div class="xdropdown-menu">
						{foreach $submenu->getItems() as $subitem}
							<a href="{$subitem->getUrl()}" class="dropdown-item">{$subitem->getTitle()}</a>
						{/foreach}
					</div>

				{/if}
			{/if}

		</li>
  {/foreach}
  
</ul>