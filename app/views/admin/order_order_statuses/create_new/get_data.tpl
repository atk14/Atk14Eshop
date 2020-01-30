<h1>{$page_title}</h1>

<p><span class="alert alert-secondary">{$order->getOrderStatus()}</span> &rarr; <strong class="alert alert-warning">{$new_order_status}</strong></p>

{render partial="shared/form"}
