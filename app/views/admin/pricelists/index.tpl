<h1>{button_create_new}{t}Add a pricelist{/t}{/button_create_new} {$page_title}</h1>

<p>{t}Obvykle je vhodné spravovat dva ceníky: jeden ceník pro ceny všech produktů a druhý, základní ceník, pro ceny slevněných produktů před slevou. Zákazník tak  může být v eshopu informován, že nějaký produkt je slevněn z nějaké původní ceny.{/t}</p>

{if $pricelists}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $pricelists as $pricelist}
			{render partial="pricelist_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
