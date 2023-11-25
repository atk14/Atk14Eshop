{if !$delivery_service_branches}

	{t}Žádné podací místo nebylo nalezeno{/t}

{else}

	<ul>
		{foreach $delivery_service_branches as $delivery_service_branch}
			<li>
				{highlight_search_query param_name=delivery_branch_search_q}
					{$delivery_service_branch->getAddressStr()}
				{/highlight_search_query}

				{if $delivery_service_branch->getUrl()}
					<a href="{$delivery_service_branch->getUrl()}" target="_blank">{t}Zobrazit podrobnosti{/t}</a>
				{/if}

				{a action="set_branch" delivery_method_id=$delivery_method delivery_service_branch_id=$delivery_service_branch->getExternalBranchId() _method=post}
					{t}Vybrat tuto pobočku{/t}
				{/a}
			</li>
		{/foreach}
	</ul>

{/if}
