Search bar
==========

Full-width large search bar with shopping cart info. Use Bootstrap responsive utitlities to show/hide elements on various viewport sizes.

[example]
<div class="searchbar">
	<div class="container-fluid">
		<div class="row">
			<form class="form-inline searchbar__form" action="/vyhledavani/">
				<input name="q" type="text" class="form-control form-control-lg" placeholder="Hledat" size="10">
				<button type="submit" class="btn btn-lg btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>
			<div class="js--basket_info d-none d-md-block searchbar__basket--outline">
				<a href="/cs/baskets/edit/">
					<span class="fas fa-shopping-cart"></span> Košík <span class="cart-num-items">1</span>
				</a>
			</div>
		</div>
	</div>
</div>
[/example]

Additional content may be added to search bar:

[example]
<div class="searchbar">
	<div class="container-fluid">
		<div class="row">
			<div>
				Additional content
			</div>
			<form class="form-inline searchbar__form" action="/vyhledavani/">
				<input name="q" type="text" class="form-control form-control-lg" placeholder="Hledat" size="10">
				<button type="submit" class="btn btn-lg btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>
			<div class="js--basket_info d-none d-md-block searchbar__basket--outline">
				<a href="/cs/baskets/edit/">
					<span class="fas fa-shopping-cart"></span> Košík <span class="cart-num-items">1</span>
				</a>
			</div>
		</div>
	</div>
</div>
[/example]