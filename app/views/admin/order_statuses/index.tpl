<h1>{$page_title}</h1>

<ul class="list-group">

	{foreach $order_statuses as $order_status}

		<li class="list-group-item">
			{dropdown_menu clearfix=false}
				{a action="edit" id=$order_status}{!"edit"|icon} {t}Upravit{/t}{/a}
			{/dropdown_menu}

			<strong>{render partial="shared/order_status" order_status=$order_status}</strong>
			<small>
				<ul class="list-unstyled">
					<li>{t}code{/t}: {$order_status->getCode()}</li>
					{if $order_status->notificationEnabled(false)}
						<li>{if $order_status->notificationEnabled()}{t}it is notified{/t}{else}{t}notification disabled{/t}{/if}</li>
						<li>{t}bcc{/t}: {$order_status->getBccEmail()|default:$mdash}</li>
					{/if}
				</ul>
			</small>

		</li>
		
	{/foreach}

</ul>
