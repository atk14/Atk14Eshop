<h1>{* {button_create_new}{t}Add a region{/t}{/button_create_new} *} {$page_title}</h1>


{if $regions}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $regions as $region}
			{render partial="region_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
