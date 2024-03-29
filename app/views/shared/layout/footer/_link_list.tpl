{remove_if_contains_no_text}

{if $link_list && ($link_list->getVisibleItems($current_region) || ($logged_user && $logged_user->isAdmin()))}
	<div class="col-12 col-sm-6 col-md-3">

	{admin_menu for=$link_list align=left}
	{if $link_list->getTitle()}
		<div class="h5 footer__links-heading">{$link_list->getTitle()}</div>
	{/if}

	<ul class="list-unstyled">
		{foreach $link_list->getVisibleItems($current_region) as $item}
			<li{if $item->getCssClass()} class="{$item->getCssClass()}"{/if}>
				<a href="{$item->getUrl()}">{$item->getTitle()}</a>
			</li>
		{/foreach}
	</ul>

	</div>

{/if}

{/remove_if_contains_no_text}
