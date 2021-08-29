<h1>{button_create_new}{t}Nová možnost platby{/t}{/button_create_new} {$page_title}</h1>

<ul class="list-group list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="payment_method_item" from=$payment_methods}
</ul>
