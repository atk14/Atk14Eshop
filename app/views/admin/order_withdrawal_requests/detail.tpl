{assign order $order_withdrawal_request->getOrder()}

<h1>{$page_title}</h1>

<dl class="dl-horizontal">
	<dt>{t}Id{/t}</dt>
	<dd>{$order_withdrawal_request->getId()}</dd>

	<dt>{t}Objednávka{/t}</dt>
	<dd>{a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}</dd>

	<dt>{t}Jméno{/t}</dt>
	<dd>{$order_withdrawal_request->getFirstname()} {$order_withdrawal_request->getLastname()}</dd>

	<dt>{t}E-mail{/t}</dt>
	<dd>{$order_withdrawal_request->getEmail()}</dd>

	<dt>{t}Telefon{/t}</dt>
	<dd>{$order_withdrawal_request->getPhone()|display_phone}</dd>

	<dt>{t}Bankovní účet{/t}</dt>
	<dd>{$order_withdrawal_request->getBankAccountNumber()|default:$mdash}</dd>

	<dt>{t}Důvody vrácení{/t}</dt>
	<dd>
		{if !$order_withdrawal_request->getReasons()}
			{$mdash}
		{else}
		<ul>
			{foreach $order_withdrawal_request->getReasons() as $reason}
				<li>{$reason}</li>
			{/foreach}
		</ul>
		{/if}
	</dd>

	<dt>{t}Jiný důvod{/t}</dt>
	<dd>
		{!$order_withdrawal_request->getOtherReason()|h|nl2br|default:$mdash}
	</dd>

	<dt>{t}Vrácené položky{/t}</dt>
	<dd>
		<ul>
			{foreach $order_withdrawal_request->getItems() as $item}
				{$product = $item->getProduct()}
				<li>
					{$product|catalog_id} - {$product->getName()} ({$item->getAmount()|display_amount:$product->getUnit()}) (<a href="{$product|link_to_product}">{t}zobrazit{/t}</a>)
				</li>
			{/foreach}
		</ul>
	</dd>

	<dt>{t}Datum podání žádosti{/t}</dt>
	<dd>
		{!$order_withdrawal_request->getCreatedAt()|format_date}
	</dd>

	<dt>{t}Žádost vytvořil uživatel{/t}</dt>
	<dd>
		{!$order_withdrawal_request->getCreatedByUser()|default:$mdash}
	</dd>

	<dt>{t}Podáno z IP adresy{/t}</dt>
	<dd>
		{!$order_withdrawal_request->getCreatedFromAddr()}
		{if $order_withdrawal_request->getCreatedFromAddr()!=$order_withdrawal_request->getCreatedFromHostname()}
			({$order_withdrawal_request->getCreatedFromHostname()})
		{/if}	
	</dd>
</dl>
