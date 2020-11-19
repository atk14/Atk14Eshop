Page Header
===========

Page header usually consists of Top Navbar (separate variants for desktop and mobile screens), Mainbar with logo and search field, and Main Navbar (separate variants for desktop and mobile screens). Navbars are described in [separate document](/styleguides/components%3Anavbars/).

## Complete header

Complete header with desktop and mobile navbars, mainbar and with optional large search bar

[example]
<header class="header-main">

	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-md-none navbar-top navbar-top--mobile">

		<div class="container-fluid">

			<div class="nav__mobile-items d-md-none">

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navTopMobileNavDropdown1" aria-controls="navTopMobileNavDropdown1" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars"><span class="fas fa-bars"></span></span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close"><span class="fas fa-times"></span></span>
				</button>
				<a class="navbar-brand" href="/"> <img src="/public/dist/images/atk14-eshop--inverse.svg" alt="ATK14 Eshop" width="220" height="80">
				</a>

				<ul class="navbar-nav">
					<li class="nav-item"><a href="" class="nav-link js--search-toggle"><span class="fas fa-search"></span></a></li>
				</ul>

				<ul class="navbar-nav user-menu">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="/admin/"><span class="fas fa-wrench"></span> Administrace</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">Profil</a>
							<a href="#" class="dropdown-item">Moje objednávky</a>
							<a href="#" class="dropdown-item">Dodací adresy</a>
							<div class="dropdown-divider"></div>
							<a data-method="post" class="dropdown-item" href="#">Odhlásit se</a>
							<div class="dropdown-divider"></div>
						</div>
					</li>

				</ul>

				<ul class="navbar-nav js--basket_info">

					<li class="nav-item">

						<a href="#" class="nav-link">
							<span class="fas fa-shopping-cart"></span><span class="d-none d-sm-inline"> Košík</span>
							<span class="cart-num-items">1</span>
							<div class="cart__price"><span class="currency_main"><span class="price">15</span>&nbsp;Kč</span></div>
						</a>
					</li>

				</ul>

			</div>

			<div class="collapse navbar-collapse" id="navTopMobileNavDropdown1">

				<ul class="navbar-nav nav--2col">

					<li class="nav-item">
						<a href="#" class="nav-link">Obchod</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Retro</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Hudba</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Zážitky</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Krabice</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Knihy</a>
					</li>

				</ul>

				<div class="menu-separator"></div>

				<ul class="navbar-nav nav--scrollable">

					<li class="nav-item">
						<a href="#" class="nav-link">O nás</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Prodejny</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Kontakt</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Blog</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Pro média</a>
					</li>

				</ul>

				<div class="menu-separator"></div>

				<ul class="navbar-nav nav--inline">

					<li class="nav-item langswitch">
						<a href="#" class="nav-link active">
							<img src="/public//dist/images/languages/cs.svg" class="langswitch__flag" alt="Česky" width="24" height="15">
							<span class="langswitch__lang-name--small">Česky</span>
						</a>
					</li>

					<li class="nav-item langswitch">
						<a href="#" class="nav-link">
							<img src="/public//dist/images/languages/en.svg" class="langswitch__flag" alt="English" width="24" height="15">
							<span class="langswitch__lang-name--small">English</span>
						</a>
					</li>

				</ul>

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown regionswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e175c5f0da" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu" aria-labelledby="regionswitch_5f6e175c5f0da">

							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> EU
							</a>
						</div>
					</li>

				</ul>

			</div>

		</div>

	</nav>

	<nav class="navbar navbar-dark bg-dark navbar-expand-md d-none d-md-block navbar-top navbar-top--desktop">

		<div class="container-fluid">

			<div class="collapse navbar-collapse" id="navTopDesktopNavDropdown">

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O nás</a>
						<div class="dropdown-menu">
							<a href="#" class="dropdown-item">Pro média</a>
							<a href="#" class="dropdown-item">Kontaktní údaje</a>
						</div>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Kontakt</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Prodejny</a>
					</li>

				</ul>

				<div class="menu-separator"></div>

				<ul class="navbar-nav user-menu">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="#"><span class="fas fa-wrench"></span> Administrace</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">Profil</a>
							<a href="#" class="dropdown-item">Moje objednávky</a>
							<a href="#" class="dropdown-item">Dodací adresy</a>
							<div class="dropdown-divider"></div>
							<a data-method="post" class="dropdown-item" href="#">Odhlásit se</a>
							<div class="dropdown-divider"></div>
						</div>
					</li>

				</ul>

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown regionswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e11f66f1ee" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu" aria-labelledby="regionswitch_5f6e11f66f1ee">

							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> EU
							</a>
						</div>
					</li>

					<li class="nav-item dropdown langswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="langswitch_5f6e11f66feb5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Změnit jazyk">
							<img src="/public//dist/images/languages/cs.svg" class="langswitch-flag" alt="Česky" width="24" height="15">
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="langswitch_5f6e11f66feb5">
							<a href="#" class="dropdown-item">
								<img src="/public//dist/images/languages/en.svg" class="langswitch-flag" alt="English" width="24" height="15">
								English
							</a>
						</div>
					</li>

				</ul>

			</div>

		</div>

	</nav>



	<div class="container-fluid header-main__mainbar">
		<div class="mainbar__controls">
			<div class="mainbar__top mainbar__links">
			</div>
			<div class="mainbar__middle mainbar__search_cart">
				<form class="form-inline d-none d-md-flex" action="/vyhledavani/" id="js--main_search_field">
					<input name="q" type="text" class="form-control" placeholder="Hledat">
					<button type="submit" class="btn btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
				</form>
				<div class="mainbar__cartinfo">
					<ul class="nav navbar-nav js--basket_info">
						<li class="nav-item">
							<a href="#" class="nav-link">
								<span class="fas fa-shopping-cart"></span><span class="d-none d-sm-inline"> Košík</span>
								<span class="cart-num-items">1</span>
								<div class="cart__price"><span class="currency_main"><span class="price">15</span>&nbsp;Kč</span></div>
							</a>
						</li>
					</ul>

				</div>
			</div>
			<div class="mainbar__bottom">
			</div>
		</div>
		<div class="logospace">
			<a class="logospace__logo" href="/"><img src="/public/dist/images/atk14-eshop.svg" alt="ATK14 Eshop" class="img-fluid" width="220" height="80"></a>
		</div>
	</div>



	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
		<div class="container-fluid">

			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Obchod</a>
						<div class="dropdown-menu">
							<a href="#" class="dropdown-item">Květiny</a>
							<a href="#" class="dropdown-item">Retro</a>
							<a href="#" class="dropdown-item">Krabice, krabičky</a>
							<a href="#" class="dropdown-item">Zážitky</a>
							<a href="#" class="dropdown-item">Knihy</a>
						</div>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Hudba</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Květiny</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Retro</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Knihy</a>
					</li>

					<li class="nav-item">
						<a href="#" class="nav-link">Zážitky</a>
					</li>

				</ul>

			</div>
		</div>
	</nav>

	<nav class="navbar navbar-dark bg-brand navbar-expand d-md-none navbar-main--mobile">
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav">

				<li class="nav-item">
					<a href="/obchod/" class="nav-link">Obchod</a>
				</li>

				<li class="nav-item">
					<a href="/obchod/retro/" class="nav-link">Retro</a>
				</li>

				<li class="nav-item">
					<a href="/obchod/hudba/" class="nav-link">Hudba</a>
				</li>

				<li class="nav-item">
					<a href="/obchod/zazitky/" class="nav-link">Zážitky</a>
				</li>

				<li class="nav-item">
					<a href="/obchod/krabice-krabicky/" class="nav-link">Krabice</a>
				</li>

				<li class="nav-item">
					<a href="/obchod/knihy/" class="nav-link">Knihy</a>
				</li>

			</ul>
		</div>
	</nav>

</header>
[/example]