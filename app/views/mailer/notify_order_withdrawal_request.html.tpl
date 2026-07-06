{t escape=no}Vážený zákazníku,{/t}<br/><br/>

{t order_no=$order->getOrderNo()}potvrzujeme, že jsme přijali vaši žádost o odstoupení od kupní smlouvy k objednávce č. %1.{/t}<br/><br/>

{t}Zde je rekapitulace údajů v žádosti:{/t}

<ul>
	<li>{t}Vaše jméno{/t}: {$order_withdrawal_request->getFirstname()} {$order_withdrawal_request->getLastname()}</li>
	<li>{t}Váš e-mail{/t}: {$order_withdrawal_request->getEmail()}</li>
	<li>{t}Váš telefon{/t}: {$order_withdrawal_request->getPhone()|display_phone}</li>
	{if $order_withdrawal_request->getBankAccountNumber()}
		<li>{t}Číslo vašeho bankovního účtu pro vrácení peněz{/t}: {$order_withdrawal_request->getBankAccountNumber()}</li>
	{/if}
	{if $order_withdrawal_request->getReasons()}
		<li>
			{t}Důvody vrácení zboží{/t}: {$order_withdrawal_request->getReasons()|to_sentence|lower}
		</li>
	{/if}
	{if $order_withdrawal_request->getOtherReason()}
		<li>
			{t}Jiný důvod k vrácení{/t}:<br>
			{!$order_withdrawal_request->getOtherReason()|h|nl2br}
		</li>
	{/if}
</ul>

{t}Položky objednávky, které vracíte:{/t}

<ul>
	{foreach $order_withdrawal_request->getItems() as $item}
		{$product = $item->getProduct()}
		<li>{$product|catalog_id} - {$product->getName()} ({$item->getAmount()|display_amount:$product->getUnit()})</li>
	{/foreach}
</ul>

{t}Pokyny pro vrácení objednávky:{/t}

<ol>
<li>Line 1</li>
<li>Line 2</li>
<li>{t}Zásilku zašlete na adresu{/t}:<br><br>

	ADRESS NAME<br>
	STREET<br>
	XXX XX CITY<br><br>
</li>

<li>{t}Vrácené zboží odešlete zpět nejpozději do 14 dnů od podání této žádosti{/t}</li>
<li>{t}Platbu za vrácené zboží vám vrátíme nejpozději do 14 dnů od odstoupení od smlouvy, ne však dříve, než nám bude zboží doručeno zpět{/t}</li>
</ol>

{capture assign=link}<a href="{"terms_and_conditions"|link_to_page:"with_hostname"}" style="{$link_style}">{t}{"terms_and_conditions"|link_to_page:"with_hostname"}{/t}</a>{/capture}
<p>{t link=$link escape=no}Další informace o odstoupení od kupní smlouvy nalezenete na adrese %1{/t}</p>
