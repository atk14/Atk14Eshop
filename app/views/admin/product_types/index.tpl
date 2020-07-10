<h1>{button_create_new}{t}Add a new product type{/t}{/button_create_new} {$page_title}</h1>

<p>
	{t}Typem produktu lze ovlivnit:{/t}
</p>
<ul>
	<li>{t}podobu URL produktu (např. "/book/great-escapes/" oproti "/product/great-escapes/"){/t},</li>
	<li>{t}výchozí vzor pro sestavování nadpisu stránky v <html><head><title>{/t},</li>
	<li>{t}výsledek fulltextového vyhledávání{/t}.</li>
</ul>


<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="product_type_item" from=$product_types}
</ul>
