{if !$nav_class}
	{assign var="nav_class" "nav navbar-nav"}
{/if}
{assign incl_vat $basket->displayPricesInclVat()}

<ul class="{$nav_class} basket_info">
	<li class="nav-item">
		<a href="{link_to namespace="" action="baskets/edit"}" class="nav-link" data-toggle="offcanvas" data-target="#offcanvas-basket" aria-expanded="false" aria-controls="offcanvas-basket">
			{render partial="shared/basket_info_content"}
		</a>
	</li>
</ul>
