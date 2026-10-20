<h1>{button_create_new}{t}Add a preferred product{/t}{/button_create_new} {$page_title}</h1>

<p>{t}Products listed here get preferred whenever they already show up as a candidate in the "customers who bought this also bought" recommendations - they are never shown if they are unrelated to the viewed product.{/t}</p>

{if $card_recommendation_boosts}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{render partial="card_recommendation_boost_item" from=$card_recommendation_boosts}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
