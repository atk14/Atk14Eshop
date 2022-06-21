{assign next_automatic_order_status $order_status->getNextAutomaticOrderStatus()}

<li class="list-group-item">
	<div class="item__properties">

	<div class="item__title">
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
	</div>

	<div>
		{if $next_automatic_order_status}
			<small>
				{t days=$order_status->getNextAutomaticOrderStatusAfterDays()}After %1 days it will automatically go into the state:{/t}<br>
				{render partial="shared/order_status" order_status=$next_automatic_order_status}
			</small>
		{/if}
	</div>

	<div class="item__controls">
		{dropdown_menu}
			{a action="edit" id=$order_status}{!"edit"|icon} {t}Upravit{/t}{/a}
		{/dropdown_menu}
	</div>

	</div>
</li>
