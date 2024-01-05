{*
 * {render partial="shared/delivery_address" delivery_address=$delivery_address}
 * {render partial="shared/delivery_address" object_with_delivery_address=$order}
 * {render partial="shared/delivery_address" object_with_delivery_address=$basket}
 *}

{capture assign=delivery_address_str}{trim}

{remove_if_contains_no_text}

{if $object_with_delivery_address}

	{$object_with_delivery_address->getDeliveryFirstname()} {$object_with_delivery_address->getDeliveryLastname()}<br>
	{if $object_with_delivery_address->getDeliveryCompany()}
		{$object_with_delivery_address->getDeliveryCompany()}<br>
	{/if}
	{$object_with_delivery_address->getDeliveryAddressStreet()}<br>
	{if $object_with_delivery_address->getDeliveryAddressStreet2()}
		{$object_with_delivery_address->getDeliveryAddressStreet2()}<br>
	{/if}
	{$object_with_delivery_address->getDeliveryAddressZip()} {$object_with_delivery_address->getDeliveryAddressCity()}<br>
	{if $object_with_delivery_address->getDeliveryAddressState()}
		{$object_with_delivery_address->getDeliveryAddressState()}<br>
	{/if}
	{$object_with_delivery_address->getDeliveryAddressCountry()|to_country_name}<br>
	{if $object_with_delivery_address->getEmail()}
		{$object_with_delivery_address->getEmail()}<br>
	{/if}
	{$object_with_delivery_address->getDeliveryPhone()|display_phone|default:$mdash}
	{if $object_with_delivery_address->getDeliveryAddressNote()}
		<br>
		<small>{t}upozornění:{/t} {$object_with_delivery_address->getDeliveryAddressNote()}</small>
	{/if}

{elseif $delivery_address}

	{$delivery_address->getFirstname()} {$delivery_address->getLastname()}<br>
	{if $delivery_address->getCompany()}
		{$delivery_address->getCompany()}<br>
	{/if}
	{$delivery_address->getAddressStreet()}<br>
	{if $delivery_address->getAddressStreet2()}
		{$delivery_address->getAddressStreet2()}<br>
	{/if}
	{$delivery_address->getAddressZip()} {$delivery_address->getAddressCity()}<br>
	{if $delivery_address->getAddressState()}
		{$delivery_address->getAddressState()}<br>
	{/if}
	{$delivery_address->getAddressCountry()|to_country_name}<br>
	{$delivery_address->getPhone()|display_phone|default:$mdash}
	{if $delivery_address->getAddressNote()}
		<br>
		<small>{t}upozornění:{/t} {$delivery_address->getAddressNote()}</small>
	{/if}

{/if}

{/remove_if_contains_no_text}

{/trim}{/capture}

{!$delivery_address_str|default:$mdash}
