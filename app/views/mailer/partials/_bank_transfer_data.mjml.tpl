{assign bank_account $order->getBankAccount()}
<mj-section>
	

<mj-divider></mj-divider>

<mj-column mj-class="column-half">
	<mj-text>{t}Částka k úhradě:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}</mj-text>
</mj-column>
<mj-divider></mj-divider>

<mj-column mj-class="column-half">
	<mj-text>{t}Variabilní symbol:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{$order->getOrderNo()}</mj-text>
</mj-column>
<mj-divider></mj-divider>

<mj-column mj-class="column-half">
	<mj-text>{t}Číslo účtu:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{$bank_account->getAccountNumber()}</mj-text>
</mj-column>
<mj-divider></mj-divider>

{if $bank_account->getIban()}
<mj-column mj-class="column-half">
	<mj-text>IBAN:</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{$bank_account->getIban()}</mj-text>
</mj-column>
<mj-divider></mj-divider>
{/if}

{if $bank_account->getSwiftBic()}
<mj-column mj-class="column-half">
	<mj-text>SWIFT:</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{$bank_account->getSwiftBic()}</mj-text>
</mj-column>
<mj-divider></mj-divider>
{/if}

{if $bank_account->getHolderName()}
<mj-column mj-class="column-half">
	<mj-text>{t}Majitel účtu:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text>{$bank_account->getHolderName()}</mj-text>
</mj-column>
<mj-divider></mj-divider>
{/if}

{if $display_qr_code}
<mj-column mj-class="column-half">
	<mj-text>{t}QR kód pro načtení platby do bankovní aplikace:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text><img src="cid:qrcode" width="200" height="200" alt="{t}QR kód{/t}"></mj-text>
</mj-column>
<mj-divider></mj-divider>
{/if}

</mj-section>

