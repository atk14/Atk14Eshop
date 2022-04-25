<h1>{button_create_new}{t}Create new customer group{/t}{/button_create_new} {$page_title}</h1>


<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{render partial="customer_group_item" from=$customer_groups}
</ul>
