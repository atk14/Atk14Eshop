{if !$menu->isEmpty()}
<h3 class="footer-title">{$menu.0->getTitle()}</h3>

<ul>
	{foreach $menu.0->getSubmenu() as $item}
		<li>
			<a href="{$item->getUrl()}">{$item->getTitle()}</a>
		</li>
	{/foreach}
</ul>
{/if}
