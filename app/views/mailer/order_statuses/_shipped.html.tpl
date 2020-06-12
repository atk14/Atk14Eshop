<strong>{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 byla předána dopravci.{/t}</strong>

{if $order->getTrackingUrl()}
<br/><br/>
{t 1=$order->getTrackingNumber()}Číslo zásilky: %1{/t}
<br/><br/>
{t}Svou zásilku můžete sledovat přes následující odkaz:{/t}
<br/>
<a href="{$order->getTrackingUrl()}" style="{$link_style}">{$order->getTrackingUrl()}</a>
{/if}
