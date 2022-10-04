{$order->getDeliveryName()}<br>
{if $order->getDeliveryCompany()|strlen}
	{$order->getDeliveryCompany()}<br>
{/if}
{$order->getDeliveryAddressStreet()}<br>
{if $order->getDeliveryAddressStreet2()|strlen}
	{$order->getDeliveryAddressStreet2()}<br>
{/if}
{$order->getDeliveryAddressZip()} {$order->getDeliveryAddressCity()}<br>
{$order->getDeliveryAddressCountry()|to_country_name}
<br>
<br>
{t}Telefon:{/t} {$order->getDeliveryPhone()|display_phone|default:"—"}
{if $order->getDeliveryAddressNote()|strlen}
	<br><br>
	{t}Poznámka:{/t} {$order->getDeliveryAddressNote()}
{/if}
