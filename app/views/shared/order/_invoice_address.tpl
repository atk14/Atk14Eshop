{if $order->getInvoiceCompany()|strlen}
	{$order->getInvoiceCompany()}<br>
{else}
	{$order->getInvoiceName()}<br>
{/if}
{$order->getInvoiceStreet()}<br>
{if $order->getInvoiceStreet2()|strlen}
	{$order->getInvoiceStreet2()}<br>
{/if}
{$order->getInvoiceZip()} {$order->getInvoiceCity()}<br>
{if $order->getInvoiceState()|strlen}
	{$order->getInvoiceState()}<br>
{/if}
{$order->getInvoiceCountry()|to_country_name}

{if $order->getCompanyNumber() || $order->getVatId()}
	<br><br>
	{t}IČ:{/t} {$order->getCompanyNumber()|default:"—"}<br>
	{t}DIČ:{/t} {$order->getVatId()|default:"—"}
{/if}

{if $order->getAddressNote()|strlen}
	<br><br>
	{t}Poznámka:{/t} {$order->getAddressNote()}
{/if}
