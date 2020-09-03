{if !$nav_class}
	{assign var="nav_class" "nav"}
{/if}
<ul class="{$nav_class} js--basket_info">
	<li class="nav-item">
		<a href="{link_to namespace="" action="baskets/edit"}" class="nav-link xxnav-link--border">
			{!"shopping-cart"|icon} {t}Košík{/t}
			{if !$basket->isEmpty()}
			{assign currency $basket->getCurrency()}
			<span class="cart-num-items">{$basket->getItems()|sizeof}</span>
			<div class="cart__price">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</div>
			{/if}
		</a>
	</li>
</ul>
