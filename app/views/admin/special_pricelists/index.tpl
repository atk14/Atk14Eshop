<h1>{button_create_new}{t}Add a pricelist{/t}{/button_create_new} {$page_title}</h1>

<p>
	{t}Speciální ceníky jsou určeny ke správě výhodnějších cen nějaké typicky malé množiny produktů.{/t}
	{t}Ceny lze stanovovat buďto konkrétní částkou nebo procentní slevou vůči ceníku daného zákazníka.{/t}
	{t}Jeden zákazník může mít více speciálních ceníků.{/t}
</p>

{if $special_pricelists}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $special_pricelists as $special_pricelist}
			{render partial="special_pricelist_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}V této chvíli není založen žádný speciální ceník.{/t}</p>

{/if}
