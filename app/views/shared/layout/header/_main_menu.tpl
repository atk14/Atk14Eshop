{assign main_menu LinkList::GetInstanceByCode("main_menu")}

<ul class="navbar-nav">
	{if $main_menu}
		{foreach $main_menu->getItems($current_region) as $item}
			
				{assign submenu $item->getSubmenu()}

				{if $submenu}
					<li class="nav-item dropdown">
							<div class="nav-link  dropdown-toggle" data-toggle="dropdown">
								<a href="{$item->getUrl()}" class="js--prevent-dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">{$item->getTitle()}</a>
							</div>
							<div class="dropdown-menu js--prevent-dropdown-toggle">
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
	{/if}
</ul>

