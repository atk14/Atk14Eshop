Shopping Cart Modals
====================

## Basic "Added to cart" Modal Dialog

[example]
<div class="modal fade show" id="product_added_modal" tabindex="-1" role="dialog" aria-labelledby="product_added_modalLabel" style="padding-right: 12px; display: block; position: static;" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="product_added_modalLabel">Produkt byl přidán do košíku</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="zavřít">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="section__surface">
					<p>Do košíku jste úspěšně přidali produkt "Osobní kachnička".</p>
					<p>
						Nakupte ještě za <span class="currency_main"><span class="price">751</span>&nbsp;Kč</span> a dostanete dopravu zdarma.
					</p>
				</div>
				<div class="section__navigation">
					<button class="btn btn-secondary btn--back" data-dismiss="modal">Vybrat další produkt</button>
					<a href="#" class="btn btn-primary btn--cta">K pokladně</a>
				</div>
			</div>
		</div>
	</div>
</div>
[/example]

## "Add Same Product" Confirmation Modal Dialog

[example]
<div class="modal fade show" id="product_added_modal" tabindex="-1" role="dialog" aria-labelledby="product_added_modalLabel" style="padding-right: 12px; display: block; position: static;" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="product_added_modalLabel">Produkt byl přidán do košíku</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="zavřít">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="section__surface">
					<p>Do košíku jste úspěšně přidali produkt "Osobní kachnička".</p>
					<p class="modal__quantity-change">
						<span class="quantity"><span class="badge badge-secondary rounded-pill">2&nbsp;ks</span> <i class="fas fa-arrow-right"></i> <span class="badge badge-primary rounded-pill">3&nbsp;ks</span> </span><a href="" class="quantity-edit-link">Upravit počet</a>
					</p>
					<p>
						Nakupte ještě za <span class="currency_main"><span class="price">751</span>&nbsp;Kč</span> a dostanete dopravu zdarma.
					</p>
				</div>
				<div class="section__navigation">
					<button class="btn btn-secondary btn--back" data-dismiss="modal">Vybrat další produkt</button>
					<a href="#" class="btn btn-primary btn--cta">K pokladně</a>
				</div>
			</div>
		</div>
	</div>
</div>
[/example]

## "Added to Cart" modal dialog with cart overview

[example]
<div class="modal fade show" id="product_added_modal" tabindex="-1" role="dialog" aria-labelledby="product_added_modalLabel" style="padding-right: 12px; display: block; position: static;" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="product_added_modalLabel">Produkt byl přidán do košíku</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="zavřít">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
			<table class="table-products table-products--mini">
				<tbody class="table-products__list">
					<tr class="table-products__item">
						<td class="table-products__image"><a href="/produkt/brasna-na-fotak/"><img src="http://i.pupiq.net/i/6f/6f/aca/2daca/2886x2165/Kaog3H_120x120xffffff_cbdd0820323d5eb4.jpg" alt="" width="120" height="120"></a></td>
						<td class="table-products__title">
							<a href="/produkt/brasna-na-fotak/">Brašna na foťák</a> <span class="d-block d-lg-none table-products__id"><span class="property__key">Kód</span>BRASNA</span>
						</td>
						<td class="table-products__id"><span class="d-none d-lg-inline">BRASNA</span></td>
						<td class="table-products__unit-price"><span class="property__key">Jedn. cena</span> <span class="currency_main"><span class="price">595,00</span>&nbsp;Kč</span></td>
						<td class="table-products__amount"><span class="property__key">Množství</span>1</td>
						<td class="table-products__price"><span class="property__key">Celkem</span><span class="currency_main"><span class="price">595,00</span>&nbsp;Kč</span></td>
					</tr>
					<tr class="table-products__item">
						<td class="table-products__image"><a href="/produkt/violator-download/"><img src="http://i.pupiq.net/i/6f/6f/bb7/2dbb7/800x800/CRFjDM_120x120xffffff_a5edc907c202f446.jpg" alt="" width="120" height="120"></a></td>
						<td class="table-products__title">
							<a href="/produkt/violator-download/">Violator (download)</a> <br><small><span class="badge badge-pill badge-secondary">digitální produkt</span></small>
							<span class="d-block d-lg-none table-products__id"><span class="property__key">Kód</span>4646DL</span>
						</td>
						<td class="table-products__id"><span class="d-none d-lg-inline">4646DL</span></td>
						<td class="table-products__unit-price"><span class="property__key">Jedn. cena</span> <span class="currency_main"><span class="price">250,00</span>&nbsp;Kč</span></td>
						<td class="table-products__amount"><span class="property__key">Množství</span>4</td>
						<td class="table-products__price"><span class="property__key">Celkem</span><span class="currency_main"><span class="price">1&nbsp;000,00</span>&nbsp;Kč</span></td>
					</tr>
				</tbody>
			</table>

			<div class="modal-body">

				

				<div class="section__surface">
					<p>Do košíku jste úspěšně přidali produkt "Osobní kachnička".</p>
					<p>
						Nakupte ještě za <span class="currency_main"><span class="price">751</span>&nbsp;Kč</span> a dostanete dopravu zdarma.
					</p>
				</div>
				<div class="section__navigation">
					<button class="btn btn-secondary btn--back" data-dismiss="modal">Vybrat další produkt</button>
					<a href="#" class="btn btn-primary btn--cta">K pokladně</a>
				</div>
			</div>
		</div>
	</div>
</div>
[/example]