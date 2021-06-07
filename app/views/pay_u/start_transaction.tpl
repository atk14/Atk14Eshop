{*
<h2>{$page_title}</h2>

<ul>
	<li>objednavka: {$order->getVariableSymbol()}</li>
	<li>cena: {$order->getPrice()|format_price}</li>
</ul> *}

{render partial="shared/checkout_navigation"}

{render partial="shared/layout/content_header" title=$page_title}

{!$payment_form}
