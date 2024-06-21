Cards
=====

Cards are based on Bootstrap Card component. Make sure that card images have the same aspect ratio on all cards. Card element may be <code>div</code>, <code>a</code> or <code>li</code> element type.

It is recommended to wrap card image in <code>.card__image</code> element for easier placement of absolutely positioned icons, flags, tags etc.

Max-width inline styles in examples are for illustration purposes only. In live use cards are sized by <code>card-deck--sized-[n]</code> classes

## Basic product card with optional tag and discount flag (shown in state when is favourite and is in shopping cart)
[example]
<div class="card card--hoverable card--id-22 card--in-basket" style="max-width:300px;">
	<a class="card__image" href="#"> <img
			src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
			height="300" class="card-img-top" alt="Foto film">
		<div class="card__flags">
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
			</div>
		</div>
		<div class="card__tags">
			<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
		</div>
		<div class="card__icons">
			<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
					class="fas fa-heart"></span></span>
		</div>
	</a>

	<div class="card-body">
		<a class="card-title h4" href="#">Foto film</a>
		<div class="card-text">Negativní film.</div>
	</div>

	<div class="card-footer">
		<div class="card-price card-price--sm">
			<span class="price--before-discount"><span class="currency_main"><span
						class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
						class="currency_main__ordering-unit"></span></span></span>

			<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
						class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>
		</div>
		<a data-remote="true" data-method="post"
			class="btn btn-outline-primary btn-xsm js--card-add-to-cart-btn remote_link post" rel="nofollow"
			href="/cs/baskets/add_card/?card_id=22"><span class="fas fa-shopping-cart"></span> Přidat do košíku</a>
	</div>
</div>
[/example]

Optional product card without Add to Cart button - whole card is a link to detail page.

[example]
<a href="#" class="card card--id-22 card--in-basket"  style="max-width:300px;">
	<div class="card__image"> <img
			src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
			height="300" class="card-img-top" alt="Foto film">
		<div class="card__flags">
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
			</div>
		</div>
		<div class="card__tags">
			<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
		</div>
		<div class="card__icons">
			<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
					class="fas fa-heart"></span></span>
		</div>
	</div>

	<div class="card-body">
		<h4 class="card-title">Foto film</h4>
		<div class="card-text">Negativní film.</div>
	</div>

	<div class="card-footer">
		<div class="card-price">

			<span class="price--before-discount"><span class="currency_main"><span
						class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
						class="currency_main__ordering-unit"></span></span></span>

			<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
						class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>

		</div>

		<span class="card-footer__icon"><span class="fas fa-shopping-cart"></span> <span
				class="fas fa-chevron-right"></span></span>
	</div>
</a>
[/example]

### Small variation

More compact version is created by adding <code>.card--sm</code> modifier class. There is also smaller variation of flag used.

[example]
<div class="d-flex" style="flex-wrap:wrap">
<div class="card card--hoverable card--id-22 card--in-basket card--sm" style="max-width:200px;">
	<a class="card__image" href="#"> <img
			src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
			height="300" class="card-img-top" alt="Foto film">
		<div class="card__flags">
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
			</div>
		</div>
		<div class="card__tags">
			<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
		</div>
		<div class="card__icons">
			<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
					class="fas fa-heart"></span></span>
		</div>
	</a>

	<div class="card-body">
		<a class="card-title h4" href="#">Foto film</a>
		<div class="card-text">Negativní film.</div>
	</div>

	<div class="card-footer">
		<div class="card-price card-price--sm">
			<span class="price--before-discount"><span class="currency_main"><span
						class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
						class="currency_main__ordering-unit"></span></span></span>

			<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
						class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>
		</div>
		<a data-remote="true" data-method="post"
			class="btn btn-outline-primary btn-xsm js--card-add-to-cart-btn remote_link post" rel="nofollow"
			href="/cs/baskets/add_card/?card_id=22"><span class="fas fa-shopping-cart"></span> Přidat do košíku</a>
	</div>
</div>

<a href="#" class="card card--id-22 card--in-basket card--sm"  style="max-width:200px;">
	<div class="card__image"> <img
			src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
			height="300" class="card-img-top" alt="Foto film">
		<div class="card__flags">
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
			</div>
		</div>
		<div class="card__tags">
			<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
		</div>
		<div class="card__icons">
			<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
					class="fas fa-heart"></span></span>
		</div>
	</div>

	<div class="card-body">
		<h4 class="card-title">Foto film</h4>
		<div class="card-text">Negativní film.</div>
	</div>

	<div class="card-footer">
		<div class="card-price">

			<span class="price--before-discount"><span class="currency_main"><span
						class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
						class="currency_main__ordering-unit"></span></span></span>

			<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
						class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>

		</div>

		<span class="card-footer__icon"><span class="fas fa-shopping-cart"></span> <span
				class="fas fa-chevron-right"></span></span>
	</div>
</a>
</div>
[/example]

## Basic article card

[example]
<a class="card" href="#" style="max-width:300px">
	<div class="card__image">
		<img src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_400x300xc_c8450b0cd86003da.jpg" width="400"
			height="300" class="card-img-top" alt="Curabitur et ex fringilla">
	</div>
	<div class="card-body">
		<div class="h2 card-title">Curabitur et ex fringilla</div>
		<div class="card-teaser">Aenean finibus erat et sollicitudin ultricies</div>
	</div>
	<div class="card-footer">
		<p class="card-meta"> Zaslal <em>Charlie Root</em> dne <time
				datetime="2020-01-24 13:03:00">24.&nbsp;1.&nbsp;2020</time> </p>
	</div>
</a>
[/example]

## Horizontal card 
Created by adding <code>card--horizontal</code> class. If you use it with tags or flags, test it thoroughly before production use.

[example]	
<a class="card card--horizontal" href="#" style="max-width:600px">
	<div class="card__image">
		<img src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_400x300xc_c8450b0cd86003da.jpg" width="400"
			height="300" class="card-img-top" alt="Curabitur et ex fringilla">
	</div>
	<div class="card-body">
		<div class="h2 card-title">Curabitur et ex fringilla</div>
		<div class="card-teaser">Aenean finibus erat et sollicitudin ultricies</div>
	</div>
	<div class="card-footer">
		<p class="card-meta"> Zaslal <em>Charlie Root</em> dne <time
				datetime="2020-01-24 13:03:00">24.&nbsp;1.&nbsp;2020</time> </p>
	</div>
</a>
[/example]
		
## Basic card with buttons

[example]
<div class="card" style="max-width:300px;">
	<div class="card__image">
		<a href="#"><img class="card-img-top" src="http://i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_400x300xc_a58d61dc4d4f4811.jpg" alt="" width="400" height="300"></a>
	</div>
	<div class="card-body">
		<h2 class="card-title">Elegantní lékárna</h2>
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
		
## Basic store card with additional markup required for JavaScript enhancements in store locator

[example]
<div class="card card--store js-store-item" data-storeid="1" style="max-width:300px;">
	<div class="d-none js-search-data">
		Elegantní lékárna Vinohradská 222
		120 00 Praha 2
		Česká republika
	</div>
	<div class="card__image">
		<a href="#"><img class="card-img-top" src="http://i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_400x300xc_a58d61dc4d4f4811.jpg" alt="" width="400" height="300"></a>
		<div class="card__flags"><span class="badge badge-success">Právě otevřeno</span></div>
	</div>
	<div class="card-body">
		<h2 class="card-title">Elegantní lékárna</h2>
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

## Address cards
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

## Micro cards

Provides small thumbnail cards with fixed width and link to view more items. Used in search results to show works by author.

[example]
<div class="card-deck card-deck--micro">

	<a class="card card--micro" href="#">
		<div class="card__image">
			<img title="Spirit" class="card-img-top" src="SVGPlaceholder/100/100" alt="" width="100" height="100">
		</div>
		<div class="card-body">
			<div class="h5 card-title">Spirit</div>
		</div>
	</a>

	<a class="card card--micro" href="#">
		<div class="card__image">
			<img title="Construction Time Again" class="card-img-top" src="SVGPlaceholder/100/100" alt="" width="100" height="100">
		</div>
		<div class="card-body">
			<div class="h5 card-title">Construction Time Again</div>
		</div>
	</a>

	<a class="card card--micro" href="#">
		<div class="card__image">
			<img title="A Broken Frame - download" class="card-img-top" src="SVGPlaceholder/100/100" alt="" width="100" height="100">
		</div>
		<div class="card-body">
			<div class="h5 card-title">A Broken Frame - download</div>
		</div>
	</a>

	<a class="card card--micro" href="#">
		<div class="card__image">
			<img title="Black Celebration - download" class="card-img-top" src="SVGPlaceholder/100/100" alt="" width="100" height="100">
		</div>
		<div class="card-body">
			<div class="h5 card-title">Black Celebration - download</div>
		</div>
	</a>

	<a class="card card--micro" href="#">
		<div class="card__image">
			<img title="Violator - Remixes Deluxe Edition" class="card-img-top" src="SVGPlaceholder/100/100" alt="" width="100" height="100">
		</div>
		<div class="card-body">
			<div class="h5 card-title">Violator - Remixes Deluxe Edition</div>
		</div>
	</a>

	<a title="a další" class="card card--micro card--link-more" href="#">
		<div class="card-body">
			<span class="fas fa-plus"></span> a další <span class="fas fa-chevron-right"></span>
		</div>
	</a>

</div>
[/example]


## Card deck 
Based on Bootstrap card deck. To control number of cards per row, there are added modifier classes that control card sizing. Cards are responsive so on smallers display they are displayed with reasonable widths.

Available classes for 2, 3, 4 or 6 cards per row:  
<code>card-deck--sized-2</code>  
<code>card-deck--sized-3</code>  
<code>card-deck--sized-4</code>  
<code>card-deck--sized-6</code>

[example]
<div class="card-deck card-deck--sized-3">
	
	<div class="card card--hoverable card--id-22 card--in-basket">
		<a class="card__image" href="#"> <img
				src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
				height="300" class="card-img-top" alt="Foto film">
			<div class="card__flags">
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
				</div>
			</div>
			<div class="card__tags">
				<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
			</div>
			<div class="card__icons">
				<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
						class="fas fa-heart"></span></span>
			</div>
		</a>

		<div class="card-body">
			<a class="card-title h4" href="#">Foto film</a>
			<div class="card-text">Negativní film.</div>
		</div>

		<div class="card-footer">
			<div class="card-price card-price--sm">
				<span class="price--before-discount"><span class="currency_main"><span
							class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
							class="currency_main__ordering-unit"></span></span></span>

				<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
							class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>
			</div>
			<a data-remote="true" data-method="post"
				class="btn btn-outline-primary btn-xsm js--card-add-to-cart-btn remote_link post" rel="nofollow"
				href="/cs/baskets/add_card/?card_id=22"><span class="fas fa-shopping-cart"></span> Přidat do košíku</a>
		</div>
	</div>
	
	<div class="card card--hoverable card--id-22">
		<a class="card__image" href="#"> <img
				src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
				height="300" class="card-img-top" alt="Foto film">
			<div class="card__flags">
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
				</div>
			</div>
			<div class="card__tags">
				<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
			</div>
			<div class="card__icons">
				<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
						class="fas fa-heart"></span></span>
			</div>
		</a>

		<div class="card-body">
			<a class="card-title h4" href="#">Foto film</a>
			<div class="card-text">Negativní film.</div>
		</div>

		<div class="card-footer">
			<div class="card-price card-price--sm">
				<span class="price--before-discount"><span class="currency_main"><span
							class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
							class="currency_main__ordering-unit"></span></span></span>

				<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
							class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>
			</div>
			<a data-remote="true" data-method="post"
				class="btn btn-outline-primary btn-xsm js--card-add-to-cart-btn remote_link post" rel="nofollow"
				href="/cs/baskets/add_card/?card_id=22"><span class="fas fa-shopping-cart"></span> Přidat do košíku</a>
		</div>
	</div>
	
	<div class="card card--hoverable card--id-22 card">
		<a class="card__image" href="#"> <img
				src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_400x300xffffff_14812c5c3175e9b5.jpg" width="400"
				height="300" class="card-img-top" alt="Foto film">
			<div class="card__flags">
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">Sleva</span> <span class="product__flag__number">5&nbsp;%</span>
				</div>
			</div>
			<div class="card__tags">
				<span class="badge tag-item tag--bg-teal"><span class="fas fa-tag"></span> novinka</span>
			</div>
			<div class="card__icons">
				<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
						class="fas fa-heart"></span></span>
			</div>
		</a>

		<div class="card-body">
			<a class="card-title h4" href="#">Foto film</a>
			<div class="card-text">Negativní film.</div>
		</div>

		<div class="card-footer">
			<div class="card-price card-price--sm">
				<span class="price--before-discount"><span class="currency_main"><span
							class="currency_main__price">40,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
							class="currency_main__ordering-unit"></span></span></span>

				<div class="price--primary"><span class="currency_main"><span class="currency_main__price">38,00</span>&nbsp;<span
							class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span></div>
			</div>
			<a data-remote="true" data-method="post"
				class="btn btn-outline-primary btn-xsm js--card-add-to-cart-btn remote_link post" rel="nofollow"
				href="/cs/baskets/add_card/?card_id=22"><span class="fas fa-shopping-cart"></span> Přidat do košíku</a>
		</div>
	</div>
	
</div>
[/example]

### Developers note:

Default ATK14Eshop has cards with zero margins, however with SCSS mixins in our _cards.scss it is easy to create variations with various card spacing. With little effort it is possible to create card with various spacing within single project.
