Shopping Cart Modals
====================

## Basic "Added to cart" Modal Dialog

[example]
<div class="modal fade show" id="basket_modal_dialog" tabindex="-1" role="dialog" aria-labelledby="basket_modal_dialogLabel" style="padding-right: 12px; display: block; position: static;" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="basket_modal_dialogLabel">Produkt byl přidán do košíku</h5>
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
<div class="modal fade show" id="basket_modal_dialog" tabindex="-1" role="dialog" aria-labelledby="basket_modal_dialogLabel" style="padding-right: 12px; display: block; position: static;" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="basket_modal_dialogLabel">Produkt byl přidán do košíku</h5>
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
