<h1>{$page_title}</h1>

<ul class="list-group">

	{foreach $order_statuses as $order_status}

		<li class="list-group-item">
			{dropdown_menu clearfix=false}
				{a action="edit" id=$order_status}{!"edit"|icon} {t}Upravit{/t}{/a}
			{/dropdown_menu}

			<strong>{$order_status->getCode()}</strong><br>
			{$order_status->getName()}
			{if $order_status->notificationEnabled()}
				<em>({t}notifikuje se{/t})</em>
			{/if}
		</li>
		
	{/foreach}

</ul>
