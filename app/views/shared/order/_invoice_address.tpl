{if strlen($order->getInvoiceCompany())}
	{$order->getInvoiceCompany()}<br>
{/if}
{$order->getInvoiceName()}<br>
{$order->getInvoiceStreet()}<br>
{if strlen($order->getInvoiceStreet2())}
	{$order->getInvoiceStreet2()}<br>
{/if}
{$order->getInvoiceCity()}<br>
{$order->getInvoiceZip()}<br>
{$order->getInvoiceCountry()|to_country_name}

{if $order->getCompanyNumber() || $order->getVatId()}
	<br><br>
	{t}IČ:{/t} {$order->getCompanyNumber()|default:"—"}<br>
	{t}DIČ:{/t} {$order->getVatId()|default:"—"}
{/if}

{if strlen($order->getAddressNote())}
	<br><br>
	{t}Poznámka:{/t} {$order->getAddressNote()}
{/if}
