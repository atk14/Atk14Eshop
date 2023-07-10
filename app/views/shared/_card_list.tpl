{*
 * {render partial="shared/card_list" cards=$collection->getCards() title="{t}Products in the collection{/t}"}
 * {render partial="shared/card_list" cards=$collection->getCards() title=""}
 *}
{*assign "item_template" "shared/card_item"*}
{assign "item_template" "shared/card_item_add_to_basket"}
{if is_null($title)}
	{assign title "{t}List of Products{/t}"}
{/if}

{if $cards}
	<section class="section--list-products">
		{if $title}
		<h4>{$title}</h4>
		{/if}
		<div class="card-deck card-deck--sized-4">
		{foreach $cards as $card}
			{render partial=$item_template card=$card}
		{/foreach}
		</div>
	</section>
{/if}
