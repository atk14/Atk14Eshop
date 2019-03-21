{cache key="main_menu" lang=$lang region=$current_region->getCode()}

<nav class="navbar navbar-light navbar-expand nav-main">
	<ul class="navbar-nav">

		{foreach $lazy_loader.main_menu->getItems() as $item}
			<li class="nav-item">
				<a class="nav-link" href="{$item->getUrl()}">{$item->getTitle()}</a>
			</li>
		{/foreach}

	</ul>
</nav>

{/cache}
