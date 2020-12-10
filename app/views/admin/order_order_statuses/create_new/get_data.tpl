<h1>{t}Změna stavu objednávky{/t} [2/2]</h1>

{render partial="order_mini_info" order=$order}

<p><strong>{t}Stav objednávky{/t}</strong>: <span class="alert alert-secondary">{render partial="shared/order_status" order_status=$order->getOrderStatus() order=null}</span> &rarr; <strong class="alert alert-warning">{render partial="shared/order_status" order_status=$new_order_status order=null}</strong></p>

{render partial="shared/form"}
