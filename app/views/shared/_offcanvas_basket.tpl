<div id="offcanvas-basket" class="xbs-offcanvas xbs-offcanvas-right bg-light xxxx offcanvas offcanvas-end">
	<header class="xbs-offcanvas-header xbs-offcanvas-header--fixed-top xxxx offcanvas-header">
		<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		<div class="h4 bs-offcanvas-title"><a href="{link_to action="baskets/edit"}">{!"shopping-cart"|icon}{t}Basket{/t}<span class="cart-num-items js--cart-num-items">0</span></a></div>
	</header>
	<div class="bs-offcanvas-content">
		<div class="basket-content">

		</div>
		<div class="basket-loading">
			<div class="spinner-border text-secondary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<p>{t}Loading{/t}</p>			
		</div>
		<div class="basket-error js--basket-error">
			Error
		</div>
		<div class="basket-link">
			<a href="{link_to action="baskets/edit"}" class="btn btn-primary">{t}To the checkout{/t} {!"angle-right"|icon}</a>
		</div>
	</div>    
</div>
