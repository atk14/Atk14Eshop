{assign bank_account $order->getBankAccount()}
<mj-section>
	

<mj-column width="100%"><mj-divider></mj-divider></mj-column>

<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{t}Částka k úhradě:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>

<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{t}Variabilní symbol:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{$order->getOrderNo()}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>

<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{t}Číslo účtu:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{$bank_account->getAccountNumber()}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>

{if $bank_account->getIban()}
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">IBAN:</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{$bank_account->getIban()}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>
{/if}

{if $bank_account->getSwiftBic()}
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">SWIFT:</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{$bank_account->getSwiftBic()}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>
{/if}

{if $bank_account->getHolderName()}
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{t}Majitel účtu:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{$bank_account->getHolderName()}</mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>
{/if}

{if $display_qr_code}
<mj-column mj-class="column-half">
	<mj-text mj-class="compact">{t}QR kód pro načtení platby do bankovní aplikace:{/t}</mj-text>
</mj-column>
<mj-column mj-class="column-half">
	<mj-text mj-class="compact"><img src="cid:qrcode" width="200" height="200" alt="{t}QR kód{/t}"></mj-text>
</mj-column>
<mj-column width="100%"><mj-divider></mj-divider></mj-column>
{/if}
<mj-spacer height="40px" />
</mj-section>

