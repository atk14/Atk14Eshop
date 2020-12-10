<p>
{t order_no=$order->getOrderNo()}Order %1{/t}<br>
{if $order->getCompany}{$order->getCompany()}, {/if} {$order->getFirstname()} {$order->getLastname()}<br>
{if $order->getEmail()}
	{$order->getEmail()}<br>
{/if}
{if $order->getPhone()}
	{$order->getPhone()}<br>
{/if}
{t price=$order->getTotalPriceInclVat()|display_price:$order->getCurrency() escape=no}Total price: %1{/t}
</p>
