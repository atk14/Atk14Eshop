{assign currency $order->getCurrency()}

<p>
{capture assign=link_to_order}{a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}{/capture}
{t order_no=$link_to_order escape=no}Objednávka č. %1{/t}
<br>
{if $order->getInvoiceCompany()}{$order->getInvoiceCompany()}{if $order->getInvoiceName()}, {/if}{/if} {$order->getInvoiceName()}<br>
{if $order->getEmail()}
	{$order->getEmail()}<br>
{/if}
{if $order->getPhone()}
	{$order->getPhone()}<br>
{/if}
{t}doprava:{/t} {$order->getDeliveryMethod()}<br>
{t}platba:{/t} {$order->getPaymentMethod()}<br>
{t price=$order->getPriceToPay()|display_price:$currency escape=no}celková cena: %1{/t}
<br>
{t}zaplaceno: {/t} {$order->isPaid()|display_bool}{if $order->getPaymentMethod()->isCashOnDelivery()} ({t}dobírka{/t}){/if}
{if $order->isPaid() || $order->getPricePaid()}
	<br>
	{t}celkem zaplaceno:{/t} {!$order->getPricePaid()|display_price:$currency|default:$mdash}
{/if}
<br>
{t}akt. stav:{/t} {render partial="shared/order_status"}
