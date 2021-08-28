<h1>{button_create_new}{t}Nová možnost doručení{/t}{/button_create_new} {$page_title}</h1>

<ul class="list-group list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="delivery_method_item" from=$delivery_methods}
</ul>
