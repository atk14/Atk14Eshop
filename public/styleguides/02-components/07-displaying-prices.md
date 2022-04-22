Displaying prices
=================

This should be used for displaying all prices on cards to achieve consistent look and markup and easy maintentance across entire site. Note that price itself is in span tag with <code>currency_main</code> class.

### Markup structure of price display widget output (modifier.display_price.php)
<pre>
 |---.currency_main
 |     |----.currency_main__price         "8,23"
 |     |----.currency_main__currency      "EUR"
 |     |----.currency_main__ordering-unit " za kus"
 |
 |---.vat_label                           "bez DPH"
</pre>

### Markup structure on card (also search suggestions, card iobject):
<pre>
.card-price
 |---.card-price--before-discount
 |    |---.currency_main
 |    |    |--- ...
 |    |
 |    |---.vat_label "bez DPH"
 |
 |---.price--primary
 |    |---.currency_main
 |    |    ...
 |
 |---.vat_label "bez DPH"
 |
 |---.price--incl-vat
      |---.currency_main
      |    |--- ...
      |
      |---.vat_label "vč. DPH"
</pre>

### Markup structure on product detail:

<pre>
.prices 
 |---.price--main
      |---.price--before-discount
      |    |---.currency_main
      |    |    ...
      |
      |---.price--primary
      |    |---.currency_main
      |    |    ...
      |
      |---.price--incl-vat
      |    |---.currency_main
      |    |    ...
      |
      |---.price--recommended
           |---"Běžná cena:"
           |---.currency_main
           |    ...
           |---"Ušetříte:"
           |---.moneysaved
           |    |---.currency_main
           |    |    ...
</pre>  

## Simple single price

[example]
<div class="card-price">
	<div class="price--primary">
		<span class="currency_main">
			<span class="currency_main__price">260,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit">/ks</span>
		</span>
	</div>
</div>
[/example]		

## Two prices (e.g. for products with two variants). 

Prices are in <code>ul</code> list. If there are more than two prices, "From" price should be used.
		
[example]
<span class="card-price">
	<ul class="list-unstyled">
		<li>
			<div class="price--primary">
				<span class="currency_main"><span class="currency_main__price">129,00</span>&nbsp;<span class="currency_main__currency">Kč</span></span>
			</div>
		</li>
		<li>
			<div class="price--primary">
				<span class="currency_main"><span class="currency_main__price">10,00</span>&nbsp;<span class="currency_main__currency">Kč</span></span>
			</div>
		</li>
	</ul>
</span>
[/example]

## If product has more than two price variants, use "From" price
[example]
<span class="card-price">
	cena od 
	<div class="price--primary">
		<span class="currency_main"><span class="currency_main__price">35,00</span>&nbsp;<span class="currency_main__currency">Kč</span></span>
	</div>
</span>
[/example]

## Single price with discounted and original price and with secondary price ("without VAT" in this example)

[example]
<span class="card-price">
	<span class="price--before-discount">
		<span class="currency_main"><span class="currency_main__price">700,00</span>&nbsp;<span class="currency_main__currency">Kč</span></span>
	</span>
	<div class="price--primary">
		<span class="currency_main"><span class="currency_main__price">595,00</span>&nbsp;<span class="currency_main__currency">Kč</span></span>
		<span class="vat_label">incl. VAT</span>
	</div>
	<span class="price--secondary">
		<span class="currency_main__price">595,00</span>&nbsp;<span class="currency_main__currency">Kč</span>
		<span class="vat_label">without VAT</span>
	</span>
</span>
[/example]