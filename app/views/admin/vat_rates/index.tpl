<h1>{button_create_new}{t}Add a vat_rate{/t}{/button_create_new} {$page_title}</h1>


{if $vat_rates}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $vat_rates as $vat_rate}
			{render partial="vat_rate_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
