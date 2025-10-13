{if !$delivery_service_branches}

	{t}Žádné výdejní místo nebylo nalezeno{/t}

{else}

	<ul class="list-unstyled">
		{foreach $delivery_service_branches as $delivery_service_branch}
			<li>
				{highlight_search_query param_name=delivery_branch_search_q}
					{$delivery_service_branch->getAddressStr()}
				{/highlight_search_query}

				<div class="pb-2">
					<a href="{link_to action="set_branch" delivery_method_id=$delivery_method delivery_service_branch_id=$delivery_service_branch->getExternalBranchId()}" data-method="post" class="btn btn-xs btn-primary" tabindex="10">
						{t}vybrat výdejní místo{/t}
					</a>
					{if $delivery_service_branch->getUrl()}
						<a href="{$delivery_service_branch->getUrl()}" target="_blank" class="btn btn-xs btn-outline-secondary">{t}podrobnosti{/t}</a>
					{/if}
				</div>
			</li>
		{/foreach}
	</ul>

{/if}
