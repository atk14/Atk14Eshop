{*
 * {render partial="shared/card_list" cards=$collection->getCards() title="{t}Products in the collection{/t}"}
 * {render partial="shared/card_list" cards=$collection->getCards() title=""}
 *}

{if is_null($title)}
	{assign title "{t}List of Products{/t}"}
{/if}

{if $cards}
	<section class="card-list">
		{if $title}
		<h4>{$title}</h4>
		{/if}
		<div class="card-deck card-deck--sized">
		{foreach $cards as $card}
			{render partial="shared/card_item" card=$card}
		{/foreach}
		</div>
	</section>
{/if}
