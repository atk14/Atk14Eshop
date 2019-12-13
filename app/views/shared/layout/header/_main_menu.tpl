{assign main_menu LinkList::GetInstanceByCode("main_menu")}

<ul class="navbar-nav">
	{if $main_menu}
		{foreach $main_menu->getItems($current_region) as $item}
			<li class="nav-item">
				{assign submenu $item->getSubmenu()}

				{if $submenu}

					<div class="btn-group btn-group-sm">
						<a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a>
						<button class="btn btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">{t}Show menu{/t}</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							{foreach $submenu->getItems() as $subitem}
								<a href="{$subitem->getUrl()}" class="dropdown-item">{$subitem->getTitle()}</a>
							{/foreach}
						</div>
					</div>

				{else}

					<a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a>

				{/if}

			</li>
		{/foreach}
	{/if}
</ul>

