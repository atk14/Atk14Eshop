{trim}
{assign show_branch_id $show_branch_id|default:true}

{*assign object_class $order|get_class*}

	{assign var=delivery_method_data value=$order->getDeliveryMethodData()}
	{if $delivery_method_data}
		{assign delivery_address $delivery_method_data.delivery_address}
		{capture assign=delivery_service_branch_info}
			{t 1=$delivery_address.company 2=$delivery_address.place 3=$delivery_address.zip 4=$delivery_address.city 5=$delivery_address.street}Pobočka: %1 %2, %3, %4, %5{/t}{if $show_branch_id} ({t 1=$delivery_method_data.external_branch_id}ID pobočky: %1{/t}){/if}
		{/capture}
	{/if}
{/trim}
 {if $delivery_service_branch_info}[ {trim}{$delivery_service_branch_info}{/trim} ]{/if}
