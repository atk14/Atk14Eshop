<h1>{$page_title}</h1>

<p><strong>{t}Stav objednávky{/t}</strong>: <span class="alert alert-secondary">{$order->getCurrentOrderStatus()}</span></p>

{render partial="shared/form" button_class="btn btn-secondary"}
