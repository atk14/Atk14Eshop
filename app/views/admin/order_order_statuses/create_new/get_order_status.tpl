<h1>{$page_title}</h1>

<p><strong>{t}Stav objednávky{/t}</strong>: <span class="alert alert-secondary">{render partial="shared/order_status" order_status=$order->getOrderStatus() order=null}</span></p>

{render partial="shared/form" button_class="btn btn-secondary"}
