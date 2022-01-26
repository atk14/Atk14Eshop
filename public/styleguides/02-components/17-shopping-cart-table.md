Shopping Cart Table
===================

Fully featured editable shopping cart table:

[example]
<table class="table-products table-products--main">
	
	<thead>
		<tr>
			<th class="table-products__image"><span class="sr-only">Obrázek</span></th>
			<th class="table-products__title">Produkt<span class="d-block d-lg-none">Kód</span></th>
			<th class="table-products__id"><span class="d-none d-lg-inline">Kód</span></th>
			<th class="table-products__unit-price">Jedn. cena</th>
			<th class="table-products__amount">Množství</th>
			<th class="table-products__price">Celkem</th>
			<th class="table-products__actions"><span class="sr-only">Actions</span></th>
		</tr>
	</thead>

	<tbody class="table-products__list">

		<tr class="table-products__item">
			<td class="table-products__image"><a href="#"><img src="http://i.pupiq.net/i/6f/6f/aca/2daca/2886x2165/Kaog3H_120x120xffffff_cbdd0820323d5eb4.jpg" alt="" width="120" height="120"></a></td>
			<td class="table-products__title">
				<a href="#">Brašna na foťák</a> <span class="d-block d-lg-none table-products__id"><span class="property__key">Kód</span>BRASNA</span>
			</td>
			<td class="table-products__id"><span class="d-none d-lg-inline">BRASNA</span></td>
			<td class="js--unit_price table-products__unit-price"><span class="property__key">Jedn. cena</span> <span class="table-products__unit-price-before-sale" data-title="ks"><s><span class="currency_main"><span class="price">700,00</span>&nbsp;Kč</span></s></span>
				<span class="table-products__unit-price-after-sale" data-title="ks"><span class="currency_main"><span class="price">595,00</span>&nbsp;Kč</span></span>
				<span class="table-products__unit-price-sale">Sleva&nbsp;15&nbsp;%</span>
			</td>
			<td class="table-products__amount" data-url="/api/cs/basket_items/add/?product=24&amp;format=json">
				<span class="property__key">Množství</span>
				<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="0" max="2" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" data-initial="1" tabindex="100" type="number" name="i49" id="id_i49" value="1"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>
			</td>
			<td class="js--price table-products__price">
				<span class="property__key">Celkem</span><span class="currency_main"><span class="price">595,00</span>&nbsp;Kč</span>
			</td>
			<td class="table-products__item-actions">
				<a data-method="post" data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-url="/api/cs/basket_items/destroy/?product=24&amp;format=json" title="odstranit z košíku" class="js--basket-destroy" href="#"><span class="fas fa-times"></span></a> </td>
		</tr>
		<tr class="table-products__item">
			<td class="table-products__image"><a href="#"><img src="http://i.pupiq.net/i/6f/6f/bb7/2dbb7/800x800/CRFjDM_120x120xffffff_a5edc907c202f446.jpg" alt="" width="120" height="120"></a></td>
			<td class="table-products__title">
				<a href="#">Violator (download)</a> <br><small><span class="badge badge-pill badge-secondary">digitální produkt</span></small>
				<span class="d-block d-lg-none table-products__id"><span class="property__key">Kód</span>4646DL</span>
			</td>
			<td class="table-products__id"><span class="d-none d-lg-inline">4646DL</span></td>
			<td class="js--unit_price table-products__unit-price"><span class="property__key">Jedn. cena</span> <span class="currency_main"><span class="price">250,00</span>&nbsp;Kč</span>
			</td>
			<td class="table-products__amount" data-url="/api/cs/basket_items/add/?product=52&amp;format=json">
				<span class="property__key">Množství</span>
				<div class="quantity-widget js-spinner js-stepper"><button tabindex="-1" type="button" data-spinner-button="down" class="btn btn-secondary" title="Sniž objednané množství">-</button><input step="1" min="0" max="999999" class="form-control form-control-number order-quantity-input js-order-quantity-input" required="required" data-initial="4" tabindex="100" type="number" name="i47" id="id_i47" value="4"><button tabindex="-1" type="button" data-spinner-button="up" class="btn btn-secondary" title="Zvyš objednané množství">+</button>&nbsp;ks</div>
			</td>
			<td class="js--price table-products__price">
				<span class="property__key">Celkem</span><span class="currency_main"><span class="price">1&nbsp;000,00</span>&nbsp;Kč</span>
			</td>
			<td class="table-products__item-actions">
				<a data-method="post" data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-url="/api/cs/basket_items/destroy/?product=52&amp;format=json" title="odstranit z košíku" class="js--basket-destroy" href="#"><span class="fas fa-times"></span></a> </td>
		</tr>

	</tbody>

	<tbody class="table-products__discounts">
		<tr class="table-products__item table-products__item--sale" id="vouchers">
			<td class="table-products__icon"><span class="fas fa-percentage"></span></td>
			<td colspan="2" class="table-products__title">Slevový kupón</td>
			<td colspan="2" class="table-products__id">slevový kód č.&nbsp;<strong>DOPRAVA</strong></td>
			<td class="table-products__price text-success"><span class="currency_main"><span class="price">0,00</span>&nbsp;Kč</span></td>
			<td class="table-products__item-actions">
				<a data-method="post" data-confirm="Opravdu chcete odstranit tento slevový kupón z nákupního košíku?" title="odstranit z košíku" href="#"><span class="fas fa-times"></span></a> </td>
		</tr>
	</tbody>

	<tfoot>

		<tr class="table-products__tfootstart">
			<td colspan="4" class="text-center table-products__free-shipping">
				<div class="sticker sticker--free-shipping">
					<div class="sticker__icon"><span class="fas fa-truck"></span></div>
					<h4 class="sticker__title">Doprava</h4>
					<div class="sticker__text">
						Zdarma </div>
					<div class="sticker__icon"><span class="fas fa-check"></span></div>
				</div>
			</td>
			<td colspan="2" class="text-right table-products__price-summary" id="js--basket_price_summarization">
				<table>
					<tbody>
						<tr>
							<th class="text--nowrap">Cena za zboží<span class="text-muted"> vč. DPH</span></th>
							<td class="text-right"><span class="currency_main"><span class="price">1&nbsp;700</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th class="text--red">Slevy celkem</th>
							<td class="text-right text--red"><span class="currency_main"><span class="price">-105</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th>Cena zboží celkem</th>
							<td class="text-right"><span class="currency_main"><span class="price">1&nbsp;595</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th class="text-success">Doprava</th>
							<td class="text-right text-success"><span class="currency_main"><span class="price">0</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th class="table-products__pricetopay">Cena celkem</th>
							<td class="table-products__pricetopay"><span class="currency_main"><span class="price">1&nbsp;595</span>&nbsp;Kč</span></td>
						</tr>
					</tbody>
				</table>
			</td>
			<td class="table-products__item-actions"></td>
		</tr>

		<tr>
			<td colspan="7" class="table-products__addvoucher">
				<div class="vouchers" id="vouchers">
					<h4>Slevové kupóny / dárkové poukazy</h4>
					<div class="input-group input-group--voucher">
						<input maxlength="50" type="text" name="voucher" class="text form-control" id="id_voucher">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary text--nowrap">Použít kód</button>
						</span>
					</div>
				</div>
			</td>
		</tr>

	</tfoot>

</table>
[/example]

The same table is used for non-ediatble order overview:

[example]
<table class="table-products table-products--main">
	<caption class="sr-only">Objednávané zboží</caption>
	<thead>
		<tr>
			<th class="table-products__image"><span class="sr-only">Obrázek</span></th>
			<th class="table-products__title">Produkt<span class="d-block d-lg-none">Kód</span></th>
			<th class="table-products__id">Kód</th>
			<th class="table-products__unit-price">Jedn. cena</th>
			<th class="table-products__amount">Množství</th>
			<th class="table-products__price">Celkem</th>
		</tr>
	</thead>
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

	<tbody class="table-products__discounts">
		<tr class="table-products__item table-products__item--sale">
			<td class="table-products__icon"><span class="fas fa-percentage"></span></td>
			<td class="table-products__title">Slevový kupón</td>
			<td colspan="3" class="table-products__id">DOPRAVA</td>
			<td class="table-products__price"><span class="currency_main"><span class="price">0,00</span>&nbsp;Kč</span></td>
		</tr>
	</tbody>

	<tbody class="table-products__delivery-payment">
		<tr class="table-products__item">
			<td class="table-products__icon"><span class="fas fa-truck"></span></td>
			<td class="table-products__title">Doprava:</td>
			<td colspan="3" class="table-products__id">Česká pošta (platba předem) </td>
			<td class="table-products__price"><span class="currency_main"><span class="price">0,00</span>&nbsp;Kč</span></td>
		</tr>

		<tr class="table-products__item">
			<td class="table-products__icon"><span class="fas fa-wallet"></span></td>
			<td class="table-products__title">Platba:</td>
			<td colspan="3">Bankovní převod</td>
			<td class="table-products__price"><span class="currency_main"><span class="price">0,00</span>&nbsp;Kč</span></td>
		</tr>
	</tbody>

	<tfoot>
		<tr class="table-products__tfootstart">
			<td colspan="3" class="table-products__note"></td>
			<td colspan="3" class="text-right table-products__price-summary">
				<table>
					<tbody>
						<tr>
							<th>Cena za zboží<span class="text-muted"> vč. DPH</span></th>
							<td class="text-right"><span class="currency_main"><span class="price">1&nbsp;595,00</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th>Doprava a platba</th>
							<td class="text-right"><span class="currency_main"><span class="price">0,00</span>&nbsp;Kč</span></td>
						</tr>
						<tr>
							<th class="table-products__pricetopay">Cena celkem</th>
							<td class="table-products__pricetopay text-right"><span class="currency_main"><span class="price">1&nbsp;595</span>&nbsp;Kč</span></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tfoot>
</table>
[/example]

## Mini shopping cart table

Used in popover cart preview on hover on small cart info. The markup is the same as products section in cart overview table above (only <code>tbody.table-products__list</code> part is used. VAT, unit price etc. may be omited). 

[example]

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

[/example]