{$order->getDeliveryName()}<br>
{if strlen($order->getDeliveryCompany())}
	{$order->getDeliveryCompany()}<br>
{/if}
{$order->getDeliveryAddressStreet()}<br>
{if strlen($order->getDeliveryAddressStreet2())}
	{$order->getDeliveryAddressStreet2()}<br>
{/if}
{$order->getDeliveryAddressZip()} {$order->getDeliveryAddressCity()}<br>
{$order->getDeliveryAddressCountry()|to_country_name}
<br>
<br>
{t}Telefon:{/t} {$order->getDeliveryPhone()|display_phone|default:"—"}
{if strlen($order->getDeliveryAddressNote())}
	<br><br>
	{t}Poznámka:{/t} {$order->getDeliveryAddressNote()}
{/if}
