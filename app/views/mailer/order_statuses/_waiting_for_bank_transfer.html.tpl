{render partial="thanks_for_order.html"}

{t order_no=$order->getOrderNo() escape=no}Vaše objednávka č. %1 byla úspěšně dokončena. Zboží Vám bude dodáno, <strong>po obdržení Vaší platby</strong>.{/t}
<br/><br/>
{t}Vybrali jste si platbu bankovním převodem.{/t}
<br/><br/>
{t}Zde jsou bankovní údaje pro platbu bankovním převodem:{/t}
<br/><br/>
<strong>{t}Částka k úhradě:{/t}</strong> {!$order->getPriceToPay()|display_price:"$currency,summary"}
<br/><br/>
<strong>{t}Číslo účtu:{/t}</strong> {"merchant.billing_information.bank_account.number"|system_parameter}
<br/><br/>
{if "merchant.billing_information.bank_account.iban"|system_parameter}
	<strong>IBAN:</strong> {"merchant.billing_information.bank_account.iban"|system_parameter}
	<br/><br/>
{/if}
{if "merchant.billing_information.bank_account.swift"|system_parameter}
	<strong>SWIFT:</strong> {"merchant.billing_information.bank_account.swift"|system_parameter}
	<br/><br/>
{/if}
<strong>{t}Variabilní symbol:{/t}</strong> {$order->getOrderNo()}
<br/><br/>
<strong>{t}Majitel účtu:{/t}</strong> {"merchant.billing_information.bank_account.holder"|system_parameter}
