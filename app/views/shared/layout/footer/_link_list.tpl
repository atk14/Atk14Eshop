{if $link_list && !$link_list->isEmpty($current_region)}
	<div class="col-12 col-sm-6 col-md-3">

	{admin_menu for=$link_list align=left}
	{if $link_list->getTitle()}
		<h5>{$link_list->getTitle()}</h5>
	{/if}

	<ul class="list-unstyled">
		{foreach $link_list->getVisibleItems($current_region) as $item}
			<li>
				<a href="{$item->getUrl()}">{$item->getTitle()}</a>
			</li>
		{/foreach}
	</ul>

	</div>

{/if}
