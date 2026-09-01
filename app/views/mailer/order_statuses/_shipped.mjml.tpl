<mj-text>
<strong>{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 byla předána dopravci.{/t}</strong>
{if $order->getTrackingUrl()}
<br/><br/>
{t 1=$order->getTrackingNumber()}Číslo zásilky: %1{/t}
<br/><br/>
{t}Svou zásilku můžete sledovat přes následující odkaz:{/t}
</mj-text>
<mj-button href="{$order->getTrackingUrl()}">{t}Sledovat zásilku{/t}</mj-button>
<mj-text>
<p style="text-align: center;"><small><a href="{$order->getTrackingUrl()}" class="muted">{$order->getTrackingUrl()}</a></small></p>
{/if}
</mj-text>
