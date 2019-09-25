{dropdown_menu}
	{if $order->getNextOrderStatuses()}
		<a href="" class="btn btn-default"><i class="glyphicon glyphicon-step-forward"></i> {t}Změnit stav objednávky{/t}</a>
		{foreach $order->getNextOrderStatuses() as $status}
			{a action="order_order_statuses/create_new" order_id=$order order_status_id=$status}{t 1=$status->getName()}Nastavit do stavu '%1'{/t}{/a}
		{/foreach}
	{/if}
{/dropdown_menu}

