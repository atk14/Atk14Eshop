Page Header
===========

Page header usually consists of Top Navbar (separate variants for desktop and mobile screens), Mainbar with logo and search field, and Main Navbar (separate variants for desktop and mobile screens). Navbars are described in [separate document](/styleguides/components%3Anavbars/).

## Complete header

Complete header with desktop and mobile navbars, mainbar and with optional large search bar. To make header spanning full width of viewport, add class <code>.header-main--fullwidth</code> to <code>header.header-main</code> element.

(Note: some recent changes in header markup not yet shown in this guide.)

[example]
<header class="header-main" id="header-main">

	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-md-none navbar-top navbar-top--mobile">
		<div class="container-fluid">

			<div class="nav__mobile-items d-md-none">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navTopMobileNavDropdown"
					aria-controls="navTopMobileNavDropdown" aria-expanded="false" aria-label="Přepnout navigaci">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars"><span class="fas fa-bars"></span></span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close"><span class="fas fa-times"></span></span>
				</button>
				<div class="navbar-brand">
					<a class="d-flex" href="/"> <img src="/public/dist/images/header-logo--mobile.svg" alt="ATK14 Eshop"
							height="80">
					</a> </div>
				<ul class="navbar-nav">
					<li class="nav-item"><a href="" class="nav-link js--search-toggle" aria-label="Hledat"><span
								class="fas fa-search"></span></a></li>
				</ul>
				<ul class="navbar-nav user-menu">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
							aria-expanded="false" aria-label="admin">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right ">
							<a class="dropdown-item" href="/admin/"><span class="fas fa-wrench"></span> Administrace</a>
							<div class="dropdown-divider"></div>
							<a href="/cs/users/detail/" class="dropdown-item">Profil</a>
							<a href="/cs/orders/" class="dropdown-item">Moje objednávky</a>
							<a href="/cs/delivery_addresses/" class="dropdown-item">Dodací adresy</a>
							<a href="/cs/favourite_products/" class="dropdown-item"><span class="fas fa-heart"></span>&nbsp;Oblíbené
								produkty</a>
							<div class="dropdown-divider"></div>
							<a data-method="post" class="dropdown-item" href="/odhlaseni/">Odhlásit se</a>
							<div class="dropdown-divider"></div>
						</div>
					</li>
				</ul>

				<a class="nav-link header-favourites js--header-favourites" rel="nofollow" title="Oblíbené položky"
					aria-label="Oblíbené položky" href="/cs/favourite_products/"> <span class="header-favourites__icon">
						<span class="fas fa-heart"></span><span class="header-favourites__icon__text">9</span>
					</span>
				</a>

				<ul class="navbar-nav basket_info">
					<li class="nav-item">
						<a href="/cs/baskets/edit/" class="nav-link" rel="nofollow" data-toggle="offcanvas"
							data-target="#offcanvas-basket" aria-expanded="false" aria-controls="offcanvas-basket">
							<div class="js--basket_info_content">
								<span class="cart__icon"><span class="fas fa-shopping-cart"></span></span><span
									class="d-none d-sm-inline cart__name"> Košík</span>
								<span class="cart-num-items">1</span>
								<div class="cart__price"><span class="currency_main"><span
											class="currency_main__price">40</span>&nbsp;<span class="currency_main__currency">Kč</span><span
											class="currency_main__ordering-unit"></span></span></div>
							</div>
						</a>
					</li>
				</ul>
			</div>

			<form class="form-inline search-form-mobile " action="/vyhledavani/" id="js--mobile_search_field">
				<input name="q" type="text" class="form-control js--search" placeholder="Hledat" aria-label="Hledat"
					autocomplete="off">
				<button type="submit" class="btn btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>

			<div class="collapse navbar-collapse" id="navTopMobileNavDropdown">
				<ul class="navbar-nav nav--2col">
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
				<div class="menu-separator"></div>
				<ul class="navbar-nav nav--scrollable">
					<li class="nav-item">
						<a href="/o-nas/" class="nav-link">O nás</a>
					</li>
					<li class="nav-item">
						<a href="/prodejny/" class="nav-link">Prodejny</a>
					</li>
					<li class="nav-item">
						<a href="/o-nas/kontaktni-udaje/" class="nav-link">Kontakt</a>
					</li>
					<li class="nav-item">
						<a href="/clanky/" class="nav-link">Blog</a>
					</li>
					<li class="nav-item">
						<a href="/o-nas/pro-media/" class="nav-link">Pro média</a>
					</li>
				</ul>
				<div class="menu-separator"></div>
				<ul class="navbar-nav nav--inline">
					<li class="nav-item langswitch">
						<a href="//localhost:3000/styleguides/components%3Aheader/" class="nav-link active">
							<img src="/public//dist/images/languages/cs.svg" class="langswitch__flag" alt="Česky" width="24"
								height="15">
							<span class="langswitch__lang-name--small">Česky</span>
						</a>
					</li>
					<li class="nav-item langswitch">
						<a href="//localhost:3000/en/styleguides/detail/?id=components%3Aheader" class="nav-link">
							<img src="/public//dist/images/languages/en.svg" class="langswitch__flag" alt="English" width="24"
								height="15">
							<span class="langswitch__lang-name--small">English</span>
						</a>
					</li>
				</ul>
				<div class="menu-separator"></div>
				<ul class="navbar-nav">
					<li class="nav-item dropdown regionswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_651eb03e8c4d9"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Vyberte prodejní oblast">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu " aria-labelledby="regionswitch_651eb03e8c4d9">
							<a data-method="post" class="dropdown-item" rel="nofollow" href="/cs/regions/set_region/?id=11"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="/cs/regions/set_region/?id=12"> EU
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
					<li class="nav-item">
						<a href="/o-nas/" class="nav-link">O nás</a>
					</li>
					<li class="nav-item">
						<a href="/o-nas/kontaktni-udaje/" class="nav-link">Kontakt</a>
					</li>
					<li class="nav-item">
						<a href="/prodejny/" class="nav-link">Prodejny</a>
					</li>
					<li class="nav-item">
						<a href="/clanky/" class="nav-link">Blog</a>
					</li>
				</ul>
				<div class="menu-separator"></div>
				<ul class="navbar-nav user-menu">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
							aria-expanded="false" aria-label="admin">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu--dark dropdown-menu--transparent bg-dark">
							<a class="dropdown-item" href="/admin/"><span class="fas fa-wrench"></span> Administrace</a>
							<div class="dropdown-divider"></div>
							<a href="/cs/users/detail/" class="dropdown-item">Profil</a>
							<a href="/cs/orders/" class="dropdown-item">Moje objednávky</a>
							<a href="/cs/delivery_addresses/" class="dropdown-item">Dodací adresy</a>
							<a href="/cs/favourite_products/" class="dropdown-item"><span class="fas fa-heart"></span>&nbsp;Oblíbené
								produkty</a>
							<div class="dropdown-divider"></div>
							<a data-method="post" class="dropdown-item" href="/odhlaseni/">Odhlásit se</a>
							<div class="dropdown-divider"></div>
						</div>
					</li>
				</ul>
				<div class="menu-separator"></div>
				<ul class="navbar-nav">
					<li class="nav-item dropdown regionswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_651eb03e932e1"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Vyberte prodejní oblast">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu--dark dropdown-menu--transparent bg-dark"
							aria-labelledby="regionswitch_651eb03e932e1">

							<a data-method="post" class="dropdown-item" rel="nofollow" href="/cs/regions/set_region/?id=11"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="/cs/regions/set_region/?id=12"> EU
							</a>
						</div>
					</li>
					<li class="nav-item dropdown langswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="langswitch_651eb03e93d30"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Změnit jazyk">
							<img src="/public/dist/images/languages/cs.svg" class="langswitch-flag" alt="Česky" width="24"
								height="15">
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu--dark dropdown-menu--transparent bg-dark"
							aria-labelledby="langswitch_651eb03e93d30">
							<a href="//localhost:3000/en/styleguides/detail/?id=components%3Aheader" class="dropdown-item">
								<img src="/public/dist/images/languages/en.svg" class="langswitch-flag" alt="English" width="24"
									height="15">
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
				<form class="form-inline" action="/vyhledavani/" id="js--main_search_field">
					<input name="q" type="text" class="form-control js--search" placeholder="Hledat" autocomplete="off">
					<button type="submit" class="btn btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
				</form>
				<a class="nav-link header-favourites js--header-favourites" rel="nofollow" title="Oblíbené položky"
					aria-label="Oblíbené položky" href="/cs/favourite_products/"> <span class="header-favourites__icon">
						<span class="fas fa-heart"></span><span class="header-favourites__icon__text">9</span>
					</span>
				</a>
				<div class="mainbar__cartinfo js--mainbar__cartinfo">
					<ul class="nav navbar-nav basket_info">
						<li class="nav-item">
							<a href="/cs/baskets/edit/" class="nav-link" rel="nofollow" data-toggle="offcanvas"
								data-target="#offcanvas-basket" aria-expanded="false" aria-controls="offcanvas-basket">
								<div class="js--basket_info_content">
									<span class="cart__icon"><span class="fas fa-shopping-cart"></span></span><span
										class="d-none d-sm-inline cart__name"> Košík</span>
									<span class="cart-num-items">1</span>
									<div class="cart__price"><span class="currency_main"><span
												class="currency_main__price">40</span>&nbsp;<span class="currency_main__currency">Kč</span><span
												class="currency_main__ordering-unit"></span></span></div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="mainbar__bottom">
			</div>
		</div>
		<div class="logospace">
			<a class="logospace__logo" href="/"><img src="/public/dist/images/header-logo.svg" alt="ATK14 Eshop"
					height="80"></a>
		 </div>
	</div>

	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
		<div class="container-fluid">
			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a href="/obchod/" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
							aria-haspopup="true" aria-expanded="false">Obchod</a>
						<div class="dropdown-menu dropdown-menu--dark bg-brand dropdown-menu--transparent">
							<a href="/obchod/kvetiny/" class="dropdown-item">Květiny</a>
							<a href="/obchod/retro/" class="dropdown-item">Retro</a>
							<a href="/obchod/krabice-krabicky/" class="dropdown-item">Krabice, krabičky</a>
							<a href="/obchod/zazitky/" class="dropdown-item">Zážitky</a>
							<a href="/obchod/knihy/" class="dropdown-item">Knihy</a>
							<a href="/obchod/hudba/" class="dropdown-item">Hudba</a>
							<a href="/obchod/syntezatory/" class="dropdown-item">Syntezátory</a>
							<a href="/obchod/grooveboxy/" class="dropdown-item">Grooveboxy</a>
							<a href="/obchod/tereminy/" class="dropdown-item">Tereminy</a>
							<a href="/obchod/modularni-systemy/" class="dropdown-item">Modulární systémy</a>
							<a href="/obchod/vokodery/" class="dropdown-item">Vokodéry</a>
						</div>
					</li>
					<li class="nav-item">
						<a href="/obchod/retro/" class="nav-link">Retro</a>
					</li>
					<li class="nav-item dropdown">
						<a href="/obchod/hudba/" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
							aria-haspopup="true" aria-expanded="false">Hudba</a>
						<div class="dropdown-menu dropdown-menu--dark bg-brand dropdown-menu--transparent">
							<a href="/obchod/hudba/techno/" class="dropdown-item">Techno</a>
							<a href="/obchod/hudba/electro/" class="dropdown-item">Electro</a>
							<a href="/obchod/hudba/ambient/" class="dropdown-item">Ambient</a>
							<a href="/obchod/hudba/ebm/" class="dropdown-item">EBM</a>
						</div>
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
		</div>
	</nav>

</header>
[/example]