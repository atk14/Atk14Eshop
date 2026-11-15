{if !$cards->isEmpty()}
	<ul class="list--tree">
		{foreach $cards->iterateRecords() as $card}
			{if $card->hasVariants()}
				{foreach $card->getProducts() as $product}
					<li>
						<a href="{$product|link_to_product:"with_hostname=true"}">{$product->getName()}</a>
					</li>
				{/foreach}
			{else}
				<li>
					<a href="{$card|link_to_card:"with_hostname=true"}">{$card->getName()}</a>
				</li>
			{/if}
		{/foreach}
	</ul>
{/if}
