<h1>{button_create_new}{t}Add a warehouse{/t}{/button_create_new} {$page_title}</h1>


{if $warehouses}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $warehouses as $warehouse}
			{render partial="warehouse_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
