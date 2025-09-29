{trim}

{t}Vážený zákazníku,{/t}<br/>

{if $invoice_file->isProformaInvoice()}
{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {t}Proforma faktura{/t}{/capture}
{render partial="partials/title_box" content=$order_title}

{t app_name=$region->getApplicationName() order_no=$order->getOrderNo()}K Vaší objednávce v obchodě %1 - s označením %2 Vám zasíláme proforma fakturu.{/t}
{elseif $invoice_file->isStornoInvoice()}
{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {t}Vystavení storno daňového dokladu{/t}{/capture}
{render partial="partials/title_box" content=$order_title}

{t app_name=$region->getApplicationName() order_no=$order->getOrderNo()}K Vaší objednávce v obchodě %1 - s označením %2 bylo vystaveno storno daňového dokladu.{/t}
{else}
{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {t}Vystavení daňového dokladu{/t}{/capture}
{render partial="partials/title_box" content=$order_title}

{t app_name=$region->getApplicationName() order_no=$order->getOrderNo()}K Vaší objednávce v obchodě %1 - s označením %2 byl vystaven daňový doklad.{/t}
{/if}

<br/>
<br/>
{if $invoice_file->isProformaInvoice()}
	{t}Proforma fakturu najdete v příloze tohoto e-mailu.{/t}
{else}
	{t}Doklad najdete v příloze tohoto e-mailu.{/t}
{/if}

{/trim}
