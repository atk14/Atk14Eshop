Cards
=====

Cards are based on Bootstrap Card component. Make sure that card images have the same aspect ratio on all cards. Card element may be <code>div</code>, <code>a</code> or <code>li</code> element type.  
Max-width inline styles in examples are for illustration purposes only. In live use cards are sized by <code>card-deck--sized-[n]</code> classes

###Basic product card with optional tag and discount flag

[example]
<a class="card" href="#" style="max-width:300px;">
	<img src="https://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" class="card-img-top" alt="Foto film" width="400" height="300">
	<div class="card__flags">
		
		<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">Sleva</span> <span class="product__flag__number">50&nbsp;%</span>
		</div>
		
	</div>
	<div class="card__tags">
		<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
	</div>
	<div class="card-body">
		<h4 class="card-title">Foto film</h4>
		<div class="card-text">
			<p>Negativní film.</p>
		</div>
	</div>
	<div class="card-footer">
		<span class="card-price">
			<span class="currency_main"><span class="price">40,00</span>&nbsp;Kč</span>
		</span>
		<span class="card-footer-icon"><span class="fas fa-chevron-right"></span></span>
	</div>
</a>
[/example]

###Basic article card

[example]
<a class="card" href="#" style="max-width:300px;">
	<img src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_400x300xc_c8450b0cd86003da.jpg" class="card-img-top" alt="Curabitur et ex fringilla" width="400" height="300">
	<div class="card-body">
		<h2 class="card-title">Curabitur et ex fringilla</h2>
		<p class="card-meta"> Zaslal <em>Charlie Root</em> dne <time datetime="2020-01-24 13:03:00">24.&nbsp;1.&nbsp;2020</time> </p>
		<div class="card-text"> Aenean finibus erat et sollicitudin ultricies </div>
	</div>
</a>
[/example]

###Horizontal card 
Created by adding <code>card--horizontal</code> class. If you use it with tags or flags, test it thoroughly before production use.

[example]	
<a class="card card--horizontal" href="#" style="max-width:600px">
	<img src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_400x300xc_c8450b0cd86003da.jpg" class="card-img-top" alt="Curabitur et ex fringilla" width="400" height="300">
	<div class="card-body">
		<h2 class="card-title">Curabitur et ex fringilla</h2>
		<p class="card-meta"> Zaslal <em>Charlie Root</em> dne <time datetime="2020-01-24 13:03:00">24.&nbsp;1.&nbsp;2020</time> </p>
		<div class="card-text"> Aenean finibus erat et sollicitudin ultricies </div>
	</div>
</a>
[/example]
		
###Basic card with buttons

[example]
<div class="card" style="max-width:300px;">
	<a href="#"><img class="card-img-top" src="http://i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_400x300xc_a58d61dc4d4f4811.jpg" alt="" width="400" height="300"></a>
	<div class="card-body">
		<h4 class="card-title">Elegantní lékárna</h4>
		<address>Vinohradská 222<br>
			120 00 Praha 2<br>
			Česká republika</address>
		<div class="card-text">Praha</div>
	</div>
	<div class="card-footer card-footer--buttons">
		<a class="btn btn-sm btn-outline-primary" href="#"><span class="card-footer__icon"><span class="fas fa-info-circle"></span></span> <span>Informace o&nbsp;prodejně</span></a> <a href="#allstores_map" class="btn btn-sm btn-outline-primary js-store-mapbtn" data-storeid="1"><span class="card-footer__icon"><span class="fas fa-map"></span></span> <span>Ukázat na&nbsp;mapě</span></a>
	</div>
</div>
[/example]
		
###Basic store card with additional markup required for JavaScript enhancements in store locator

[example]
<div class="card card--store js-store-item" data-storeid="1" style="max-width:300px;">
	<div class="d-none js-search-data">
		Elegantní lékárna Vinohradská 222
		120 00 Praha 2
		Česká republika
	</div>
	<a href="#"><img class="card-img-top" src="http://i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_400x300xc_a58d61dc4d4f4811.jpg" alt="" width="400" height="300"></a>
	<div class="card__flags"><span class="badge badge-success">Právě otevřeno</span></div>
	<div class="card-body">
		<h4 class="card-title">Elegantní lékárna</h4>
		<address>Vinohradská 222<br>
			120 00 Praha 2<br>
			Česká republika</address>
		<div class="card-text">Praha</div>
	</div>
	<div class="card-footer card-footer--buttons">
		<a class="btn btn-sm btn-outline-primary" href="#"><span class="card-footer__icon"><span class="fas fa-info-circle"></span></span> <span>Informace o&nbsp;prodejně</span></a> <a href="#allstores_map" class="btn btn-sm btn-outline-primary js-store-mapbtn" data-storeid="1"><span class="card-footer__icon"><span class="fas fa-map"></span></span> <span>Ukázat na&nbsp;mapě</span></a>
	</div>
</div>
[/example]

### Address cards
[example]
<ul class="card-deck card-deck--sized-4 cards--addresses">
	<li class="card bg-light">
		<div class="card-body js--card-address ">
			James Bond<br>
			MI5<br>
			City<br>
			London<br>
			130 00<br>
			Česko<br>
			telefon: +420.123589654
		</div>
		<div class="card-footer card__actions justify-content-start">
			<a class="card__action btn btn-secondary btn-sm" href="#"><span class="fas fa-edit"></span> <span>upravit</span></a> &nbsp;
			<a data-remote="true" data-confirm="Doručovací adresa bude smazána. Pokračovat?" data-method="post" class="confirm card__action btn btn-secondary btn-sm remote_link post" data-destroying_object="{&quot;class&quot;:&quot;delivery_address&quot;,&quot;id&quot;:2}" href="#"><span class="fas fa-times"></span> <span>smazat</span></a> </div>
	</li>
</ul>
[/example]

###Card deck 
Based on Bootstrap card deck. To control number of cards per row, there are added modifier classes that control card sizing. Cards are responsive so on smallers display they are displayed with reasonable widths.

Available classes for 2, 3, 4 or 6 cards per row:  
<code>card-deck--sized-2</code>  
<code>card-deck--sized-3</code>  
<code>card-deck--sized-4</code>  
<code>card-deck--sized-6</code>

[example]
<div class="card-deck card-deck--sized-3">
	<a class="card" href="#">
		<img src="https://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" class="card-img-top" alt="Foto film" width="400" height="300">
		<div class="card__flags">
		</div>
		<div class="card-body">
			<h4 class="card-title">Foto film</h4>
			<div class="card-text">
				<p>Negativní film.</p>
			</div>
		</div>
		<div class="card-footer">
			<span class="card-price">
				<span class="currency_main"><span class="price">40,00</span>&nbsp;Kč</span>
			</span>
			<span class="card-footer-icon"><span class="fas fa-chevron-right"></span></span>
		</div>
	</a>
	<a class="card" href="#">
		<img src="https://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" class="card-img-top" alt="Foto film" width="400" height="300">
		<div class="card__flags">
		</div>
		<div class="card-body">
			<h4 class="card-title">Foto film</h4>
			<div class="card-text">
				<p>Negativní film.</p>
			</div>
		</div>
		<div class="card-footer">
			<span class="card-price">
				<span class="currency_main"><span class="price">40,00</span>&nbsp;Kč</span>
			</span>
			<span class="card-footer-icon"><span class="fas fa-chevron-right"></span></span>
		</div>
	</a>
	<a class="card" href="#">
		<img src="https://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" class="card-img-top" alt="Foto film" width="400" height="300">
		<div class="card__flags">
		</div>
		<div class="card-body">
			<h4 class="card-title">Foto film</h4>
			<div class="card-text">
				<p>Negativní film.</p>
			</div>
		</div>
		<div class="card-footer">
			<span class="card-price">
				<span class="currency_main"><span class="price">40,00</span>&nbsp;Kč</span>
			</span>
			<span class="card-footer-icon"><span class="fas fa-chevron-right"></span></span>
		</div>
	</a>
</div>
[/example]

####Developers note:

Default ATK14Eshop has cards with zero margins, however with SCSS mixins in our _cards.scss it is easy to create variations with various card spacing. With little effort it is possible to create card with various spacing within single project.
