{if $also_bought_cards}
	<section class="linked-cards linked-cards--also-bought">
		<h3 class="h3">{t}Customers who bought this product also bought{/t}</h3>
		<div class="card-deck card-deck--sized-6">
			{foreach $also_bought_cards as $c}
				{render partial="linked_product_item"}
			{/foreach}
		</div>
	</section>
{/if}
