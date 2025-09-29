{assign currency $order->getCurrency()}

<p>
{t order_no=$order->getOrderNo()}Objednávka č. %1{/t}
<br>
{if $order->getCompany}{$order->getCompany()}, {/if} {$order->getFirstname()} {$order->getLastname()}<br>
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
