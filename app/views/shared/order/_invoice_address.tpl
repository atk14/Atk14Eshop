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

{if $order->getCompanyNumber() || $order->getVatId() || $order->getLocalVatId()}
	<br><br>
	{t}IČ:{/t} {$order->getCompanyNumber()|default:"—"}<br>
	{if $order->getInvoiceCountry()=="SK"}{t}IČ DPH:{/t}{else}{t}DIČ:{/t}{/if} {$order->getVatId()|default:"—"}
	{if $order->getLocalVatId()}
		<br>
		{t}DIČ:{/t} {$order->getLocalVatId()}
	{/if}
{/if}

{if $order->getAddressNote()|strlen}
	<br><br>
	{t}Poznámka:{/t} {$order->getAddressNote()}
{/if}
