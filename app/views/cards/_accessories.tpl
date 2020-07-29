{assign var=accessories value=$card->getViewableAccessories()}

{if $accessories}
	<section class="linked-cards linked-cards--accessories">
		<h3 class="h3">{t}Accessories{/t}</h3>
		<div class="card-deck card-deck--sized-6">
			{foreach $accessories as $c}
				{render partial="linked_product_item"}
			{/foreach}
		</div>
	</section>
{/if}
