<ol class="timeline">
	{foreach $checkout_navigation as $item}
		<li role="presentation" class="timeline__item{if $item->isActive()} active{/if}{if $item->isDisabled()} disabled{/if}">
			{if $item->isDisabled() || $item->isActive()}
				<span class="timeline__item-title"><span class="timeline__item-title-txt">{$item->getTitle()}</span></span>
			{else}
				<a href="{$item->getUrl()}"><span class="timeline__item-title"><span class="timeline__item-title-txt">{$item->getTitle()}</span></span></a>
			{/if}
		</li>
	{/foreach}
</ol>
