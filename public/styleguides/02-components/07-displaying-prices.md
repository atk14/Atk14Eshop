Displaying prices
=================

This should be used for displaying all prices on cards to achieve consistent look and markup and easy maintentance across entire site. Note that price itself is in span tag with <code>currency_main</code> class.

## Simple single price

[example]
<div class="card-price">
	<span class="currency_main"><span class="price">260,00</span>&nbsp;Kč</span>
</div>
[/example]		

## Two prices (e.g. for products with two variants). 

Prices are in <code>ul</code> list. If there are more than two prices, "From" price should be used.
		
[example]
<span class="card-price">
	<ul class="list-unstyled">
		<li><span class="currency_main"><span class="price">129,00</span>&nbsp;Kč</span></li>
		<li><span class="currency_main"><span class="price">10,00</span>&nbsp;Kč</span></li>
	</ul>
</span>
[/example]

## If product has more than two price variants, use "From" price
[example]
<span class="card-price">
	cena od <span class="currency_main"><span class="price">35,00</span>&nbsp;Kč</span>
</span>
[/example]

## Single price with discounted and original price and with secondary price ("without VAT" in this example)

[example]
<span class="card-price">
	<span class="card-price--before-discount"><span class="currency_main"><span class="price">700,00</span>&nbsp;Kč</span></span>
	<span class="currency_main"><span class="price">595,00</span>&nbsp;Kč</span>
	<span class="card-price--secondary"><span class="price">595,00</span>&nbsp;Kč without VAT</span>
</span>
[/example]