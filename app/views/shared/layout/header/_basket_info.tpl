{if !$nav_class}
	{assign var="nav_class" "nav navbar-nav"}
{/if}
<ul class="{$nav_class} js--basket_info">
	<li class="nav-item">
		<a href="{link_to namespace="" action="baskets/edit"}" class="nav-link">
			{!"shopping-cart"|icon}<span class="d-none d-sm-inline"> {t}Košík{/t}</span>
			{if !$basket->isEmpty()}
			{assign currency $basket->getCurrency()}
			<span class="cart-num-items">{$basket->getItems()|sizeof}</span>
			<div class="cart__price">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</div>
			{/if}
		</a>
	</li>
</ul>
