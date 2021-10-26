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
{$delivery_address->getPhone()|display_phone|default:$mdelivery_addresssh}
{if $delivery_address->getAddressNote()}
	<br>
	<small>{t}poznámka:{/t} {$delivery_address->getAddressNote()}</small>
{/if}

