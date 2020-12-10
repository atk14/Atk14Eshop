<h1>{t}Změna stavu objednávky{/t} [1/2]</h1>

{render partial="order_mini_info" order=$order}

<p><strong>{t}Stav objednávky{/t}</strong>: <span class="alert alert-secondary">{render partial="shared/order_status" order_status=$order->getOrderStatus() order=null}</span></p>

{render partial="shared/form" button_class="btn btn-secondary"}
