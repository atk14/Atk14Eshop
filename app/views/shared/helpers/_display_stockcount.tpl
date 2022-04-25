{if !$product->canBeOrdered()}
	
	<span class="text-danger">{t}Not in stock{/t}</span>

{elseif !$product->considerStockcount()}

	{if $stockcount>0 || $product->containsTag("digital_product") || $card->containsTag("digital_product")}

		<span class="text-success">{t}In stock{/t}</span>

	{else}

		<span class="text-success">{t}On order{/t}</span>

	{/if}

{elseif $stockcount>$unit->getStockcountDisplayLimit()}

	<span class="text-success">{t stockcount=$unit->getStockcountDisplayLimit()|number_format:$stockcount_precision:",":"" unit=$unit->getUnitLocalized()}In stock > %1 %2{/t}</span>

{else}

	<span class="text-success">{t stockcount=$stockcount|number_format:$stockcount_precision:",":"" unit=$unit->getUnitLocalized()}In stock %1 %2{/t}</span>

{/if}
