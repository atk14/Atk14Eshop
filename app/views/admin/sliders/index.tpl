<h1>{button_create_new}{t}Add new image slider{/t}{/button_create_new} {$page_title}</h1>

{if $sliders}


	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{render partial=slider_item from=$sliders}
	</ul>


{else}

	<p>{t}Currently there is no image slider.{/t}</p>

{/if}
