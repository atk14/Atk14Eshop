Search results formatting
=========================

##List of search results
Markup of list items differs by type of object (product contains price, store contains address etc.). If object has image, it should be shown here. There is also indication of object type. Searched phrase is highlighted where possible. 

[example]
<div class="card-grid card-grid--cols-4">

	<div class="card card--search card--search--store">
		<div class="card__image">
			<a href="#"> <img class="card-img-top"
					src="http://i.pupiq.net/i/6f/6f/ac3/2dac3/5472x3648/lcMqx7_400x300xffffff_c3b91dd42604fd0b.jpg" alt=""
					width="400" height="300">
			</a>
			<div class="card__label">
				Prodejna
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title">
				<a href="#">Showroom Praha</a>
			</h4>
			<p><span class="is-open"><span class="badge badge-success">Právě otevřeno</span></span></p>
			<div class="card-text">
				<p>
					Korunní 970/72, Praha 2<br>
					tel: +420.123456789<br>
					e-mail: email@email.email
				</p>
			</div>
		</div>
		<div class="card-footer">
			<a class="btn btn-primary btn-sm" href="#">Informace o prodejně <i class="icon ion-ios-arrow-forward"></i>
			</a>
		</div>
	</div>

	<div class="card card--search card--search--category">
		<div class="card__image">
			<a href="#"> <img src="/public/dist/images/default_category_400x300.svg" width="400" height="300"
					title="bez obrázku" alt="" class="card-img-top default-image">
			</a>
			<div class="card__label">
				Kategorie
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title">
				<a href="#">Obchod</a>
			</h4>
			<div class="card-text">
				<p>
					Nam mollis facilisis dignissim. In vitae libero tortor. Praesent pretium consequat eros eleifend eleifend. In
					ac gravida tortor. Maecenas auctor dui sapien, vitae gravida turpis imperdiet quis. Ut vitae tellus quis leo
					condimentum dictum a eu nulla. In hac habitasse platea dictumst. Donec...
				</p>
				<ul class="list--categories-mini">
					<li><a href="#">Květiny</a></li>
					<li><a href="#">Retro</a></li>
					<li><a href="#">Krabice, krabičky</a></li>
					<li><a href="#">Zážitky</a></li>
					<li class="list-item--more"><span class="text-muted">a další...</span></li>
				</ul>
			</div>
		</div>
		<div class="card-footer">
			<a class="btn btn-primary btn-sm" href="#">Zobrazit kategorii</a>
		</div>
	</div>

	<div class="card card--search card--search--page">
		<div class="card__image">
			<a href="#"> <img
					src="http://i.pupiq.net/i/6f/6f/916/30916/2000x3000/M81rTN_400x300xffffff_834457e446705db2.jpg" width="400"
					height="300" alt="Widebody" class="card-img-top">
			</a>
			<div class="card__label">
				Informace
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title">
				<a href="#">Page</a> </h4>
			<div class="card-text">
				<p>
					Search result example for page
				</p>
			</div>
		</div>
		<div class="card-footer">
			<a class="btn btn-primary btn-sm" href="#">Zobrazit stránku</a>
		</div>
	</div>


	<div class="card card--search card--search--creator">
		<div class="creator_profile">
			<div class="card__image">
				<a href="#"> <img
						src="http://i.pupiq.net/i/6f/6f/bba/2dbba/1024x673/C3xVIH_400x300xffffff_0255652f5921d6aa.jpg" width="400"
						height="300" alt="Depeche Mode" class="card-img-top">
				</a>
				<div class="card__label">
					Profil
				</div>
			</div>
			<div class="card-body">
				<h4 class="card-title">
					<a href="#">Autoři</a> /
					<a href="#"><mark>Depech</mark>e Mode</a> </h4>
				<div class="card-text">
					<p>
						<mark>Depech</mark>e Mode are an English electronic music band. David Gahan Martin Gore Fletch
					</p>
				</div>
			</div>
			<div class="card-footer">
				<a class="btn btn-primary btn-sm" href="#">Zobrazit profil</a> </div>
		</div>
		<div class="creator_works">
			<h5><mark>Depech</mark>e Mode: Autor</h5>
			<div class="card-deck card-deck--micro">
				<a class="card card--micro" href="#"> <img title="Spirit" class="card-img-top"
						src="http://i.pupiq.net/i/6f/6f/850/2f850/1500x1500/xzeu1M_90x90xffffff_63422ba10ca1e185.jpg" alt=""
						width="90" height="90">
					<div class="card-body">
						<h5 class="card-title">Spirit</h5>
					</div>
				</a>
				<a class="card card--micro" href="#"> <img title="Construction Time Again"
						class="card-img-top"
						src="http://i.pupiq.net/i/6f/6f/84f/2f84f/1000x1000/DTAnxf_90x90xffffff_23dfed95d6afa167.jpg" alt=""
						width="90" height="90">
					<div class="card-body">
						<h5 class="card-title">Construction Time Again</h5>
					</div>
				</a>
				<a class="card card--micro" href="#"> <img title="A Broken Frame - download"
						class="card-img-top"
						src="http://i.pupiq.net/i/6f/6f/843/2f843/1500x1500/wLNfQm_90x90xffffff_0d7e2c1dc818c37c.jpg" alt=""
						width="90" height="90">
					<div class="card-body">
						<h5 class="card-title">A Broken Frame - download</h5>
					</div>
				</a>
				<a class="card card--micro" href="#"> <img title="Black Celebration - download"
						class="card-img-top"
						src="http://i.pupiq.net/i/6f/6f/83f/2f83f/1500x1500/7mdlq4_90x90xffffff_1ca1ed42126b1991.jpg" alt=""
						width="90" height="90">
					<div class="card-body">
						<h5 class="card-title">Black Celebration - download</h5>
					</div>
				</a>
				<a title="a další" class="card card--micro card--link-more" href="#">
					<div class="card-body">
						<span class="fas fa-plus"></span> a další <span class="fas fa-chevron-right"></span>
					</div>
				</a> </div>
			<h5><mark>Depech</mark>e Mode: Producent</h5>
			<div class="card-deck card-deck--micro">
				<a class="card card--micro" href="#"> <img title="Violator (download)"
						class="card-img-top"
						src="http://i.pupiq.net/i/6f/6f/bb7/2dbb7/800x800/CRFjDM_90x90xffffff_987ef68d26fe5a38.jpg" alt="" width="90"
						height="90">
					<div class="card-body">
						<h5 class="card-title">Violator (download)</h5>
					</div>
				</a> </div>
		</div>
	</div>

	<div class="card card--search card--search--article">
		<div class="card__image">
			<a href="#"> <img
					src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_400x300xffffff_21afd71675b428df.jpg" width="400"
					height="300" alt="Curabitur et ex fringilla" class="card-img-top">
			</a>

			<div class="card__label">
				Aktuality
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title"><a href="#">Curabitur et ex fringilla</a></h4>
			<div class="card-text">
				Aenean finibus erat et sollicitudin ultricies
			</div>
			<p class="card-meta">Zveřejněno dne 24.&nbsp;1.&nbsp;2020</p>
		</div>

		<div class="card-footer">
			<a class="btn btn-primary btn-sm" href="#">Celý článek</a> </div>

	</div>

	<div class="card card--search card--search--article">
		<div class="card__image">
			<a href="#"> <img
					src="http://i.pupiq.net/i/6f/6f/ab4/2dab4/2000x1333/zsQ2NJ_400x300xffffff_57503fdcedbd4ff8.jpg" width="400"
					height="300" alt="Článek s vloženými objekty" class="card-img-top">
			</a>
			<div class="card__label">
				Aktuality
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title"><a href="#">Článek s vloženými objekty</a></h4>
			<div class="card-text">
				<mark>Lorem</mark> ipsum dolor sit amet, consectetur adipiscing elit
			</div>
			<p class="card-meta">Zveřejněno dne 23.&nbsp;1.&nbsp;2020</p>
		</div>
		<div class="card-footer">
			<a class="btn btn-primary btn-sm" href="#">Celý článek</a>
		</div>
	</div>

	<div class="card card--search card--search--card card--search--card--id-49">
		<div class="card__image">
			<a href="#"> <img
					src="http://i.pupiq.net/i/6f/6f/83f/2f83f/1500x1500/7mdlq4_400x300xffffff_fa77e17c2dc5dec1.jpg" width="400"
					height="300" class="card-img-top" alt="Black Celebration - download">
			</a>
			<div class="card__flags">
			</div>
			<div class="card__tags">
				<span class="badge tag-item tag--digital-product tag--bg-purple"><span class="fas fa-tag"></span> digitální
					produkt</span>
			</div>
			<div class="card__label">
				Hudba
			</div>
			<div class="card__icons">
				<span class="card-icon card-icon--favourite" title="Váš oblíbený produkt"><span
						class="fas fa-heart"></span></span>
			</div>
		</div>
		<div class="card-body">
			<h4 class="card-title"><a href="#">Black Celebration - download</a></h4>
			<div class="card-author">
				<mark>Depech</mark>e Mode</div>
			<div class="card-text">Flannel meditation raw denim hexagon microdosing crucifix cold-pressed, synth coloring book
			</div>
		</div>
		<div class="card-footer">
			<div class="card-price">
				<small>Hudba</small><br>
				<div class="price--primary"><span class="currency_main"><span
							class="currency_main__price">200,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
							class="currency_main__ordering-unit"></span></span></div>
			</div>
			<span class="card-footer__icon"><a href="/hudba/black-celebration-download/"><span
						class="fas fa-shopping-cart"></span> <span class="fas fa-chevron-right"></span></a></span>
			<div class="w-100 mt-2"><a class="btn btn-primary btn-sm" href="#">Zobrazit
					produkt</a></div>
		</div>
	</div>
</div>
[/example]

