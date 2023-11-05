{assign bank_account $order->getBankAccount()}

<strong>{t}Částka k úhradě:{/t}</strong> {!$order->getPriceToPay()|display_price:"$currency,summary=auto"}
<br/><br/>
<strong>{t}Variabilní symbol:{/t}</strong> {$order->getOrderNo()}
<br/><br/>
<strong>{t}Číslo účtu:{/t}</strong> {$bank_account->getAccountNumber()}
<br/><br/>
{if $bank_account->getIban()}
	<strong>IBAN:</strong> {$bank_account->getIban()}
	<br/><br/>
{/if}
{if $bank_account->getSwiftBic()}
	<strong>SWIFT:</strong> {$bank_account->getSwiftBic()}
	<br/><br/>
{/if}
{if $bank_account->getHolderName()}
	<strong>{t}Majitel účtu:{/t}</strong> {$bank_account->getHolderName()}
	<br/><br/>
{/if}
{if $display_qr_code}
	{t}QR kód pro načtení platby do bankovní aplikace:{/t}
	<br/>
	<img src="cid:qrcode" width="200" height="200" alt="{t}QR kód{/t}">
	<br/><br/>
{/if}
