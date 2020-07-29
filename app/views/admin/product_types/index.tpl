<h1>{button_create_new}{t}Add a new product type{/t}{/button_create_new} {$page_title}</h1>

<p>
	{t}Typem produktu lze ovlivnit:{/t}
</p>
<ul>
	<li>{t}podobu URL produktu (např. "/kniha/dobrodruzstvi-toma-sawyera/" oproti "/produkt/dobrodruzstvi-toma-sawyera/"){/t},</li>
	<li>{t}výchozí vzor pro sestavování nadpisu stránky v <html><head><title> (např. "Dobrodružství Toma Sawyera - Mark Twain - kniha" oproti "Dobrodružství Toma Sawyera"){/t},</li>
	<li>{t}vzhled výsledků fulltextového vyhledávání{/t}.</li>
</ul>


<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="product_type_item" from=$product_types}
</ul>
