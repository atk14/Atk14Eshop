Add to cart widget
==================

## Add to cart element for product without variants.
Optional discounted and usual prices and secondary price (without VAT) shown.

[example]
<section class="section--add-to-cart">
	<div class="cart-panel">
		<div class="cart-panel__meta">
			<p><span class="text-success">In stock &gt; 10 pcs</span></p>
			<p class="catalog-number">Catalog number: BRASNA</p>
		</div>
		<div class="cart-panel__controls">
			<div class="add-to-cart-widget">
				<div class="prices">
					<div class="price--main">
							<span class="price--before-discount">
								<span class="currency_main"><span class="currency_main__price">23.14</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">excl. VAT</span>
							</span>
							<span class="price--primary">
								<span class="currency_main"><span class="currency_main__price">19.67</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">excl. VAT</span>
							</span>
							<div class="price--incl-vat">
								<span class="currency_main"><span class="currency_main__price">23.80</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">incl. VAT</span>
							</div>										
							<span class="price--recommended">
									Common price: <span class="currency_main"><span class="currency_main__price">28.10</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">excl. VAT</span>
									Ušetříte: <span class="moneysaved"><span class="currency_main"><span class="currency_main__price">8.43</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span></span>
								</span>
							</div>
					</div>
					<form method="post" action="/en/baskets/add_product/" class="form_remote" data-remote="true">
						<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Reduce the ordered quantity">-</button><input step="1" min="1" max="22" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_24" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Increase the ordered quantity">+</button>&nbsp;pcs</div>
						<button type="submit" class="btn btn-primary add-to-cart-submit">Add to cart  <span class="fas fa-cart-plus"></span></button>
						<input type="hidden" name="product_id" value="24">
					</form>
			</div>
			<div class="secondary-controls">
				<div class="secondary-controls__item">
					<a href="/en/favourite_products/create_new/?product_id=24" title="Add to favourites" class="remote_link post link--small fav_status fav_status--not_fav" data-remote="true" data-method="post" rel="nofollow">
						<span class="far fa-heart"></span> <span class="link__text">Add to favourites</span>
					</a>
				</div>
			</div>
		</div>
	</div>	
</section>
[/example]

## Add to cart element with tabs for product variants
Switching vraiants also swaps main image in product gallery.

[example]
<section class="section--add-to-cart">
	<ul class="nav nav-tabs" id="variants-nav" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="tab-variant-6" data-bs-toggle="tab" href="#tab-variant-content-6" role="tab" aria-controls="tab-variant-content-6" aria-selected="true" data-product_id="6">červená</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="tab-variant-25" data-bs-toggle="tab" href="#tab-variant-content-25" role="tab" aria-controls="tab-variant-content-25" aria-selected="false" data-product_id="25">žlutá</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="tab-variant-26" data-bs-toggle="tab" href="#tab-variant-content-26" role="tab" aria-controls="tab-variant-content-26" aria-selected="false" data-product_id="26">růžová</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="tab-variant-27" data-bs-toggle="tab" href="#tab-variant-content-27" role="tab" aria-controls="tab-variant-content-27" aria-selected="false" data-product_id="27">oranžová</a>
		</li>
	</ul>

	<div class="tab-content" id="myTabContent">

		<div class="tab-pane fade active show" id="tab-variant-content-6" role="tabpanel" aria-labelledby="tab-variant-6">
			<div class="cart-panel">
				<div class="cart-panel__meta">
					<p>
						<span class="text-success">Skladem &gt; 10 ks</span>
					</p>
					<p class="catalog-number">
						Katalogové číslo: 0005 </p>
				</div>
				<div class="cart-panel__controls">
					<div class="add-to-cart-widget">
						<div class="prices">
							<div class="price--main">
								<span class="currency_main"><span class="price">37,00</span>&nbsp;Kč</span> <span class="vat_label">vč. DPH</span> </div>
						</div>
						<form method="post" action="/cs/baskets/add_product/" class="form_remote" data-remote="true">

							<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="1" max="100" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_6" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>

							<button type="submit" class="btn btn-primary add-to-cart-submit">Přidat do košíku <span class="fas fa-cart-plus"></span></button>

							<input type="hidden" name="product_id" value="6">
						</form>
					</div>

				</div>
			</div>
		</div>

		<div class="tab-pane fade" id="tab-variant-content-25" role="tabpanel" aria-labelledby="tab-variant-25">
			<div class="cart-panel">
				<div class="cart-panel__meta">
					<p>
						<span class="text-success">Skladem &gt; 10 ks</span>
					</p>
					<p class="catalog-number">
						Katalogové číslo: 0015 </p>
				</div>
				<div class="cart-panel__controls">
					<div class="add-to-cart-widget">
						<div class="prices">
							<div class="price--main">
								<span class="currency_main"><span class="price">35,00</span>&nbsp;Kč</span> <span class="vat_label">vč. DPH</span> </div>
						</div>
						<form method="post" action="/cs/baskets/add_product/" class="form_remote" data-remote="true">

							<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="1" max="100" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_25" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>

							<button type="submit" class="btn btn-primary add-to-cart-submit">Přidat do košíku <span class="fas fa-cart-plus"></span></button>

							<input type="hidden" name="product_id" value="25">
						</form>
					</div>

				</div>
			</div>
		</div>

		<div class="tab-pane fade" id="tab-variant-content-26" role="tabpanel" aria-labelledby="tab-variant-26">
			<div class="cart-panel">
				<div class="cart-panel__meta">
					<p>
						<span class="text-success">Skladem &gt; 10 ks</span>
					</p>
					<p class="catalog-number">
						Katalogové číslo: 0016 </p>
				</div>
				<div class="cart-panel__controls">
					<div class="add-to-cart-widget">
						<div class="prices">
							<div class="price--main">
								<span class="currency_main"><span class="price">39,00</span>&nbsp;Kč</span> <span class="vat_label">vč. DPH</span> </div>
						</div>
						<form method="post" action="/cs/baskets/add_product/" class="form_remote" data-remote="true">

							<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="1" max="80" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_26" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>

							<button type="submit" class="btn btn-primary add-to-cart-submit">Přidat do košíku <span class="fas fa-cart-plus"></span></button>

							<input type="hidden" name="product_id" value="26">
						</form>
					</div>

				</div>
			</div>
		</div>

		<div class="tab-pane fade" id="tab-variant-content-27" role="tabpanel" aria-labelledby="tab-variant-27">
			<div class="cart-panel">
				<div class="cart-panel__meta">
					<p>
						<span class="text-success">Skladem &gt; 10 ks</span>
					</p>
					<p class="catalog-number">
						Katalogové číslo: 0017 </p>
				</div>
				<div class="cart-panel__controls">
					<div class="add-to-cart-widget">
						<div class="prices">
							<div class="price--main">
								<span class="currency_main"><span class="price">49,00</span>&nbsp;Kč</span> <span class="vat_label">vč. DPH</span> </div>
						</div>
						<form method="post" action="/cs/baskets/add_product/" class="form_remote" data-remote="true">

							<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="1" max="80" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" id="id_amount_27" type="number" name="amount" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>

							<button type="submit" class="btn btn-primary add-to-cart-submit">Přidat do košíku <span class="fas fa-cart-plus"></span></button>

							<input type="hidden" name="product_id" value="27">
						</form>
					</div>

				</div>
			</div>
		</div>

	</div>
</section>
[/example]