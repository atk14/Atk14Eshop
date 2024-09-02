Navbars
=======

Navbars are based on Bootstrap Navbar component.
There are two navbars in the site header. On narrow screens there is only one collapsed navbar containing items from both navbars to avoid multiple hamburger menus (try to resize this browser window to see it in action).

For styling dropdowns, see [Dropdowns](../components:dropdowns). In general, background color of dropdowns used in navbars should match background color of the parent navbar (with optional transparency effect).

(Note: some recent changes in header markup not yet shown in this guide.)

## Top navbar

There are two instances of top navbar in the header - one for desktop view and another one for mobile displays. Most of the markup are shared btween both of them.  Use <code>div.menu-separator</code> to separate navbar elements. Text and border colors is determined by <code>navbar-dark</code> or <code>navbar-light</code> classes of parent navbar component. If different color scheme for collapsing part of navbar is needed, use bg color <code>bg-*</code> utility classes and <code>navbar-dark</code> or <code>navbar-light</code> on <code>.navbar-collapse</code> element.


### Top navbar on desktop

[example]
<p class="d-block d-md-none"><small>Resize browser window to see this example</small></p>

<header class="header-main">

	<nav class="navbar navbar-dark bg-dark navbar-expand-md d-none d-md-block navbar-top navbar-top--desktop">

		<div class="container-fluid">

			<div class="collapse navbar-collapse" id="navTopDesktopNavDropdown">

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O nás</a>
						<div class="dropdown-menu dropdown-menu--dark dropdown-menu--transparent bg-dark">
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
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu--dark dropdown-menu--transparent bg-dark">
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
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e11f66f1ee" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu--dark dropdown-menu--transparent bg-dark" aria-labelledby="regionswitch_5f6e11f66f1ee">

							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> EU
							</a>
						</div>
					</li>

					<li class="nav-item dropdown langswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="langswitch_5f6e11f66feb5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Změnit jazyk">
							<img src="/public//dist/images/languages/cs.svg" class="langswitch-flag" alt="Česky" width="24" height="15">
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu--dark dropdown-menu--transparent bg-dark" aria-labelledby="langswitch_5f6e11f66feb5">
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

	<h5 class="mt-3">Light variant</h5>

	<nav class="navbar navbar-light bg-light navbar-expand-md d-none d-md-block navbar-top navbar-top--desktop">

		<div class="container-fluid">

			<div class="collapse navbar-collapse" id="navTopDesktopNavDropdown">

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="/o-nas/" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O nás</a>
						<div class="dropdown-menu bg-light dropdown-menu--transparent">
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
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right bg-light dropdown-menu--transparent">
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

				<div class="menu-separator"></div>

				<ul class="navbar-nav">

					<li class="nav-item dropdown regionswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e11f66f1ee" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
							Česká republika
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu bg-light dropdown-menu--transparent" aria-labelledby="regionswitch_5f6e11f66f1ee">

							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> Slovensko
							</a>
							<a data-method="post" class="dropdown-item" rel="nofollow" href="#"> EU
							</a>
						</div>
					</li>

					<li class="nav-item dropdown langswitch">
						<a href="#" class="nav-link dropdown-toggle" role="button" id="langswitch_5f6e11f66feb5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Změnit jazyk">
							<img src="/public//dist/images/languages/cs.svg" class="langswitch-flag" alt="Česky" width="24" height="15">
							<span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right bg-light dropdown-menu--transparent" aria-labelledby="langswitch_5f6e11f66feb5">
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

</header>
[/example]

### Top navbar on small devices

[example]
<p class="d-none d-md-block"><small>Resize browser window to see this example</small></p>

<header class="header-main">

	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-md-none navbar-top navbar-top--mobile">

		<div class="container-fluid">

			<div class="nav__mobile-items d-md-none">

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTopMobileNavDropdown1" aria-controls="navTopMobileNavDropdown1" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars"><span class="fas fa-bars"></span></span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close"><span class="fas fa-times"></span></span>
				</button>
				<a class="navbar-brand" href="/"> <img src="/public/dist/images/header-logo--mobile.svg" alt="ATK14 Eshop" width="220" height="80">
				</a>

				<ul class="navbar-nav">
					<li class="nav-item"><a href="" class="nav-link js--search-toggle"><span class="fas fa-search"></span></a></li>
				</ul>

				<ul class="navbar-nav user-menu">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
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

				<ul class="navbar-nav basket_info">

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
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e175c5f0da" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
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

	<h5 class="mt-3">Light variant</h5>

	<header class="header-main">

	<nav class="navbar navbar-light bg-light navbar-expand-md d-md-none navbar-top navbar-top--mobile">

		<div class="container-fluid">

			<div class="nav__mobile-items d-md-none">

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTopMobileNavDropdown2" aria-controls="navTopMobileNavDropdown2" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars"><span class="fas fa-bars"></span></span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close"><span class="fas fa-times"></span></span>
				</button>
				<a class="navbar-brand" href="/"> <img src="/public/dist/images/header-logo.svg" alt="ATK14 Eshop" width="220" height="80">
				</a>

				<ul class="navbar-nav">
					<li class="nav-item"><a href="" class="nav-link js--search-toggle"><span class="fas fa-search"></span></a></li>
				</ul>

				<ul class="navbar-nav user-menu">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="fas fa-user"></span><span class="d-none d-sm-inline"> admin </span></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu--dark">
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

				<ul class="navbar-nav basket_info">

					<li class="nav-item">

						<a href="#" class="nav-link">
							<span class="fas fa-shopping-cart"></span><span class="d-none d-sm-inline"> Košík</span>
							<span class="cart-num-items">1</span>
							<div class="cart__price"><span class="currency_main"><span class="price">15</span>&nbsp;Kč</span></div>
						</a>
					</li>

				</ul>

			</div>

			<div class="collapse navbar-collapse" id="navTopMobileNavDropdown2">

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
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e175c5f0da" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
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
	
	<h5 class="mt-3">Combine Dark and Light variant</h5>

	<nav class="navbar navbar-dark bg-dark navbar-expand-md d-md-none navbar-top navbar-top--mobile">

		<div class="container-fluid">

			<div class="nav__mobile-items d-md-none">

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTopMobileNavDropdown3" aria-controls="navTopMobileNavDropdown3" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars"><span class="fas fa-bars"></span></span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close"><span class="fas fa-times"></span></span>
				</button>
				<a class="navbar-brand" href="/"> <img src="/public/dist/images/header-logo--mobile.svg" alt="ATK14 Eshop" width="220" height="80">
				</a>

				<ul class="navbar-nav">
					<li class="nav-item"><a href="" class="nav-link js--search-toggle"><span class="fas fa-search"></span></a></li>
				</ul>

				<ul class="navbar-nav user-menu">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
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

				<ul class="navbar-nav basket_info">

					<li class="nav-item">

						<a href="#" class="nav-link">
							<span class="fas fa-shopping-cart"></span><span class="d-none d-sm-inline"> Košík</span>
							<span class="cart-num-items">1</span>
							<div class="cart__price"><span class="currency_main"><span class="price">15</span>&nbsp;Kč</span></div>
						</a>
					</li>

				</ul>

			</div>

			<div class="collapse navbar-collapse navbar-light bg-light" id="navTopMobileNavDropdown3">

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
						<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_5f6e175c5f0da" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Select selling region">
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

</header>
[/example]

### Top navbar navs

Navs are main building component of navbars. For top navbar we have several nav layouts created by adding <code>nav--*</code> modifier class to <code>navbar-nav component</code>, all variants are derived from Bootstrap nav component. Text and border colors is determined by <code>navbar-dark</code> or <code>navbar-light</code> classes of parent navbar component.


#### Plain Bootstrap nav

[example]
<header class="header-main">
	<div class="navbar navbar-dark bg-brand navbar-expand-md navbar-top">
		<div class="navbar-collapse">
			<ul class="navbar-nav">
				<li class="nav-item"><a href="#" class="nav-link">Item 1</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 2</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 3</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 4</a></li>
			</ul>
		</div>
	</div>
</header>

[/example]

#### Nav with 2 column grid on mobile

Useful for mobile variant of top navbar.
On very small viewports items are stacked into sigle column. View in small window to see the effect.

[example]
<header class="header-main">
	<div class="navbar navbar-dark bg-brand navbar-expand-md navbar-top">
		<div class="navbar-collapse">
			<ul class="navbar-nav nav--2col">
				<li class="nav-item"><a href="#" class="nav-link">Item 1</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 2</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 3</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 4</a></li>
			</ul>
		</div>
	</div>
</header>
[/example]

#### Scrollable horizontal nav on mobile

Useful for mobile variant of top navbar. This nav should be not used for primary navigation menus as all items may not be visible. View in small window to see the effect.

[example]
<header class="header-main">
	<div class="navbar navbar-dark bg-brand navbar-expand-md navbar-top">
		<div class="navbar-collapse">
			<ul class="navbar-nav nav--scrollable">
				<li class="nav-item"><a href="#" class="nav-link">Item 1</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 2</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 3</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 4</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 5</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 6</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 7</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 8</a></li>
			</ul>
		</div>
	</div>
</header>
[/example]


#### Nav with inline items on mobile

Useful for mobile variant of top navbar.
Items are displayed inline even on mobile viewport. Use only with small number items with short link texts or icons. View in small window to see the effect.

[example]
<header class="header-main">
	<div class="navbar navbar-dark bg-brand navbar-expand navbar-top">
		<div class="navbar-collapse">
			<ul class="navbar-nav nav--inline">
				<li class="nav-item"><a href="#" class="nav-link">Item 1</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 2</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 3</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Item 4</a></li>
			</ul>
		</div>
	</div>
</header>
[/example]



## Main navbar

There are different instances of main navbar for mobile and destop view. Color styling is easily adjusted by <code>navbar-light</code> or <code>navbar-dark</code> class and <code>bg-*</code> background utility classes.

### Main navbar on large screens
Note that on small screen this navbar is hidden and its links are visible in top navbar.  
Class <code>navbar--hoverable-dropdowns</code> makes dropdowns behaving different than default Bootstrap dropdowns - they open on mouse over and parent link is clickable. To revert dropdowns to standard Bootstrap behavior, simply remove <code>navbar--hoverable-dropdowns</code> class.

[example]
<p class="d-block d-md-none"><small>Resize browser window to see this example</small></p>

<header class="header-main">

	<nav class="navbar navbar-dark bg-brand navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
		<div class="container-fluid">

			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Obchod</a>
						<div class="dropdown-menu dropdown-menu--dark bg-brand dropdown-menu--transparent">
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

	<h5 class="mt-3">Light variant</h5>

	<nav class="navbar navbar-light bg-light navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
		<div class="container-fluid">

			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">

				<ul class="navbar-nav">

					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Obchod</a>
						<div class="dropdown-menu bg-light dropdown-menu--transparent">
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

</header>
[/example]

### Main navbar on small screens

This navbar is shown on small screens, typically only on homepage. Links are displayed in four, two columns or in single column depending on viewport width. Do not use dropdowns.

[example]
<p class="d-none d-md-block"><small>Resize browser window to see this example</small></p>

<header class="header-main">

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

	<h5 class="mt-3">Light variant</h5>

	<nav class="navbar navbar-light bg-light navbar-expand d-md-none navbar-main--mobile">
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
