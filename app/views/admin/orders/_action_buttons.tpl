{dropdown_menu class="hidden-print"}
	{if $action=="detail"}<a href="javascript:print()">{!"print"|icon} {t}Tisk{/t}</a>{/if}
	{if $action=="edit"}{a action="detail" id=$order}{!"eye-open"|icon} {t}Detail{/t}{/a}{/if}
	{if $action=="detail"}{a action="edit" id=$order}{!"edit"|icon} {t}Upravit{/t}{/a}{/if}
	{if $action!="index"}{a action="set_responsible_user" id=$order}{!"user"|icon} {t}Určit zodpovědnou osobu{/t}{/a}{/if}
	{if $order && $order->getAllowedNextOrderStatuses()}
		{a action="order_order_statuses/create_new" order_id=$order}{!"level-up-alt"|icon} {t}Změnit stav objednávky{/t}{/a}
	{/if}
{/dropdown_menu}
