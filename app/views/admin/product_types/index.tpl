<h1>{button_create_new}{t}Add a new product type{/t}{/button_create_new} {$page_title}</h1>


<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="product_type_item" from=$product_types}
</ul>
