<h1>{button_create_new}{t}Add a new creator role{/t}{/button_create_new} {$page_title}</h1>

{if $creator_roles}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{render partial="creator_role_item" from=$creator_roles}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
