<div class="searchbar">
	<div class="container-fluid">
		<div class="row">
			<form class="form-inline searchbar__form" action="{link_to namespace="" action="searches/index"}">
				<input name="q" type="text" class="form-control form-control-lg" placeholder="{t}Hledat{/t}" size="10">
				<button type="submit" class="btn btn-lg btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
			</form>
			<div class="basket_info d-none d-md-block searchbar__basket--outline">
				<a href="{link_to namespace="" action="baskets/edit"}">
					{!"shopping-cart"|icon} {t}Košík{/t}
					{if !$basket->isEmpty()}
					<span class="cart-num-items">{$basket->getItems()|sizeof}</span>
					{/if}
				</a>
			</div>
		</div>
	</div>
</div>
