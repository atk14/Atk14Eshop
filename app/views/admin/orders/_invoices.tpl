{if INVOICES_ENABLED}
<tr id="invoices">
	<th>{t}Faktury{/t}</th>
	<td>
		{assign invoice_files InvoiceFile::GetInstancesForOrder($order)}
		{capture assign=return_uri}{$request->getUri()}#invoices{/capture}
		{dropdown_menu clearfix=false}
		{a action="invoice_files/create_new" order_id=$order return_uri=$return_uri}{if $invoice_files}{t}Nahrát další fakturu{/t}{else}{t}Nahrát fakturu{/t}{/if}{/a}
		{/dropdown_menu}
		{if $invoice_files}
			<ul>
				{foreach $invoice_files as $invoice_file}
					<li>
						<a href="{$invoice_file->getUrl()}">{$invoice_file->getFilename()}{if $invoice_file->isStornoInvoice()} ({t}storno{/t}){elseif $invoice_file->isProformaInvoice()} ({t}proforma{/t}){/if}</a>
						{a action="invoice_files/edit" id=$invoice_file return_uri=$return_uri _class="btn btn-outline-primary btn-xs" _title="{t}Upravit fakturu{/t}"}{!"edit"|icon} {t}Edit{/t}{/a}
						{if $invoice_file->isDeletable()}
						{a_destroy action="invoice_files/destroy" id=$invoice_file _class="btn btn-danger btn-xs" _title="{t}Smazat fakturu{/t}"}{!"remove"|icon}{/a_destroy}
						{/if}
					</li>
				{/foreach}
			</ul>
		{else}
			<em>{t}Žádná faktura nebyla nahrána.{/t}</em>
		{/if}
	</td>
</tr>
{/if}
