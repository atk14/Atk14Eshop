<strong>{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 byla předána dopravci.{/t}</strong>

{if $order->getTrackingUrl()}
<br/><br/>
{t 1=$order->getTrackingNumber()}Číslo zásilky: %1{/t}
<br/><br/>
{t url=$order->getTrackingUrl() escape=false}Svou zásilku můžete sledovat přes následující odkaz: <a href="%1">%1</a>{/t}
{/if}
