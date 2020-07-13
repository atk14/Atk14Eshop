Search results formatting
=========================

##List of search results
Markup of list items differs by type of object (product contains price, store contains address etc.). If object has image, it should be shown here. There is also indication of object type. 

[example]
<ul class="search-results-list">

	<li class="search-results-item">
		<div class="search-results-item--image">
			<a href="#"> <img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/ac3/2dac3/5472x3648/lcMqx7_600x400_f56e70d9c82d7d54.jpg" alt="" width="600" height="400">
			</a>
		</div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Showroom Praha</a><br>
				</h4>
				<span class="is-open"><span class="badge badge-success">Právě otevřeno</span></span>
				<p class="search-result-description">
					Korunní 970/72, Praha 2<br>
					tel: +420.123456789<br>
					e-mail:
				</p>
			</div>
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="/prodejny/showroom-praha/">Informace o prodejně <i class="icon ion-ios-arrow-forward"></i></a> </div>
		</div>
		<div class="search-results-item--tag">Prodejna</div>
	</li>

	<li class="search-results-item">
		<div class="search-results-item--image">
		</div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Vítejte v ATK14 E-shopu</a> </h4>
				<p class="search-result-description">ATK14 E-shop je aplikační kostra vhodná pro e-shopy, která je postavena na ATK14 Katalogu.</p>
			</div>
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="#">Zobrazit stránku</a> </div>
		</div>
		<div class="search-results-item--tag">Stránka</div>
	</li>

	<li class="search-results-item">
		<div class="search-results-item--image">
		</div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Obchod</a><br>
				</h4>
				<p class="search-result-description"></p>
			</div>
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="#">Zobrazit kategorii</a> </div>
		</div>
		<div class="search-results-item--tag">Kategorie produktů</div>
	</li>

	<li class="search-results-item">
		<div class="search-results-item--image">
			<a href="#"> <img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/ac6/2dac6/2400x1800/euQFGB_600x450_789851afd45c0449.jpg" alt="" width="600" height="450">
			</a>
			<div class="flags">
			</div>
		</div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Foto film</a><br>
				</h4>

				<div class="search-result-description">
					<p>Negativní film.</p>
				</div>

				<div class="card-price">
					<span class="currency_main"><span class="price">40,00</span>&nbsp;Kč</span>
				</div>

			</div>
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="#">Informace o produktu <i class="icon ion-ios-arrow-forward"></i></a> </div>
		</div>
		<div class="search-results-item--tag">Produkt</div>
	</li>

	<li class="search-results-item">
		<div class="search-results-item--image">
			<a href="#"> <img src="http://i.pupiq.net/i/6f/6f/ad9/2dad9/2000x1333/ed8BI4_600x399_29d35a2b41882332.jpg" alt="Curabitur et ex fringilla" class="img-fluid" width="600" height="399">
			</a> </div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Curabitur et ex fringilla</a><br>
				</h4>
				<small>Zveřejněno dne 24.&nbsp;1.&nbsp;2020</small>
				<p class="search-result-description">Aenean finibus erat et sollicitudin ultricies</p>
			</div>
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="#">Celý článek</a> </div>
		</div>
		<div class="search-results-item--tag">Článek</div>
	</li>
	
	<li class="search-results-item">
		<div class="search-results-item--image">
			<a href="#">
				<img src="https://placekitten.com/600/600" alt="" class="img-fluid" width="600" height="600">
			</a>
		</div>
		<div class="search-results-item--body">
			<div>
				<h4 class="search-result-title">
					<a href="#">Autoři</a> /
					<a href="#">Charlie Root</a>
				</h4>
				<p class="search-result-description">Polaroid kogi lyft distillery selvage. Skateboard hella crucifix, live-edge edison bulb neutra taxidermy drinking vinegar photo booth vinyl tilde.</p>

				<h5>Autor</h5>
				
				<div class="card-deck card-deck--micro">

					<a class="card card--micro" href="#">
						<img title="Druhá derivace touhy AUDIO" class="card-img-top" src="https://placekitten.com/100/100" alt="" width="100" height="100">
						<div class="card-body">
							<h5 class="card-title">Messenger bag man</h5>
						</div>
					</a>
					
					<a class="card card--micro" href="#">
						<img title="Economics of Good and Evil" class="card-img-top" src="https://placekitten.com/100/100" alt="" width="100" height="100">
						<div class="card-body">
							<h5 class="card-title">Thundercats disrupt kitsch</h5>
						</div>
					</a>
					
					<a class="card card--micro" href="#">
						<img title="Ekonómia dobra a zla" class="card-img-top" src="https://placekitten.com/100/100" alt="" width="100" height="100">
						<div class="card-body">
							<h5 class="card-title">Viral 90's flexitarian edison</h5>
						</div>
					</a>

					<a title="a další" class="card card--micro card--link-more" href="#">
						<div class="card-body">
							<span class="fas fa-plus"></span> a další <span class="fas fa-chevron-right"></span>
						</div>
					</a>

				</div>
				<h5>Interpret</h5>
				<div class="card-deck card-deck--micro">

					<a class="card card--micro" href="#">
						<img title="Ekonomie dobra a zla AUDIO" class="card-img-top" src="https://placekitten.com/100/100" alt="" width="100" height="100">
						<div class="card-body">
							<h5 class="card-title">Tattooed enamel pin</h5>
						</div>
					</a> </div>

			</div>
			
			<div class="search-results-item--actions">
				<a class="btn btn-primary btn-sm" href="#">Zobrazit profil</a> 
			</div>
			
		</div>
		
		<div class="search-results-item--tag">
			Profil
		</div>
		
	</li>

</ul>
[/example]