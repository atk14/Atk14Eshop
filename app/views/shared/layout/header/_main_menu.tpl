{cache key="main_menu" lang=$lang region=$current_region->getCode()}

<nav class="navbar navbar-light navbar-expand nav-main">
	<ul class="navbar-nav">

		{assign main_menu LinkList::FindByCode("main")}
		{if $main_menu}
			{foreach $main_menu->getItems($current_region) as $item}
			<li class="nav-item">
				<a class="nav-link" href="{$item->getUrl()}">{$item->getLabel()}</a>
			</li>
			{/foreach}
		{/if}

	</ul>
</nav>

{/cache}
