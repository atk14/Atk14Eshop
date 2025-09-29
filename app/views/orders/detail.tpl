{assign payment_transaction $order->getPaymentTransaction()}
{assign invoice_files InvoiceFile::GetInstancesForOrder($order)}
{capture assign=order_status}
	<ul class="list-unstyled">
		<li>{t date=$order->getCreatedAt()|format_datetime}Objednávka vytvořena: %1{/t}</li>
		<li>{t}Stav objednávky:{/t} {render partial="shared/order_status" order=$order lowerize=true}</li>
		{if $payment_transaction}
			<li>{t status=$payment_transaction->getPaymentStatus()|default:"?"}Stav platby: %1{/t}</li>
		{/if}
		{foreach $invoice_files as $invoice_file}
			<li><a href="{$invoice_file->getUrl()}">{t invoice_no=$invoice_file->getInvoiceNo()}{if $invoice_file->isStornoInvoice()}{t}Storno faktura %1{/t}{elseif $invoice_file->isProformaInvoice()}{t}Proforma faktura %1{/t}{else}{t}Faktura %1{/t}{/if}{/t}</a> ({$invoice_file->getFilename()}, {$invoice_file->getFilesize()|format_bytes})</li>
		{/foreach}
		{if $order->canBeFulfilled() && $order->hasDigitalContents()}
			<li><a href="{link_to action="digital_contents/index" order_token=$order->getToken(DigitalContent::GetOrderTokenOptions())}" class="btn btn-primary mt-4">{!"cloud-download-alt"|icon} {t}Stáhnout digitální produkty{/t}</a></li>
		{/if}
	</ul>
{/capture}
{render partial="shared/layout/content_header" title=$page_title teaser=$order_status}

{render partial="shared/order_detail" user=$order->getUser()}
