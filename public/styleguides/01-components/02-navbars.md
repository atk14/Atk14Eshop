Navbars
=======

Navbars are based on Bootstrap Navbar component.
				
### Top navbar. Note that in collapsed state it includes also links from main navbar.

[example]

<nav class="navbar navbar-dark bg-dark navbar-expand-md nav-top">
	<div class="container-fluid">

		<div class="nav__mobile-items d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="icon-bars"><span class="fas fa-bars"></span></span>
				<span class="icon-close"><span class="fas fa-times"></span></span>
			</button>
			<div class="nav__mobile__right">
				<ul class="navbar-nav js--basket_info">
					<li class="nav-item">
						<a href="/cs/baskets/edit/" class="nav-link">
							<span class="fas fa-shopping-cart"></span> Košík </a>
					</li>
				</ul>

			</div>
		</div>

		<div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item"><a href="/cs/logins/create_new/" class="nav-link"><span class="fas fa-key"></span> Přihlásit se</a></li>
				<li class="nav-item"><a href="/cs/users/create_new/" class="nav-link">Registrovat</a></li>


			</ul>

			<hr class="mobile-separator">

			<form class="form-inline navbar-search" action="/vyhledavani/">
				<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="Hledat">
				<button type="submit" class="btn btn-sm btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>


			<ul class="navbar-nav navbar-nav-main-mobile d-block d-md-none">
				<li class="nav-item"><a href="/obchod/" class="nav-link">Obchod</a></li>
				<li class="nav-item"><a href="/" class="nav-link">Úvod</a></li>
				<li class="nav-item"><a href="/o-nas/" class="nav-link">O nás</a></li>
				<li class="nav-item"><a href="/prodejny/" class="nav-link">Prodejny</a></li>
				<li class="nav-item"><a href="/o-nas/kontaktni-udaje/" class="nav-link">Kontakt</a></li>
			</ul>

		</div>
		<div class="nav__desktop-items">
			<ul class="navbar-nav js--basket_info">
				<li class="nav-item">
					<a href="/cs/baskets/edit/" class="nav-link">
						<span class="fas fa-shopping-cart"></span> Košík </a>
				</li>
			</ul>

		</div>
	</div>
</nav>

[/example]
		
### Main navbar. Note that on small screen this navbar is hidden and its links are visible in top navbar.

[example]

<nav class="navbar navbar-dark bg-brand navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
	<div class="container-fluid">

		<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">

			<ul class="navbar-nav">

				<li class="nav-item dropdown">
					<a href="/obchod/" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Obchod</a>
					<div class="dropdown-menu">
						<a href="/obchod/kvetiny/" class="dropdown-item">Květiny</a>
						<a href="/obchod/retro/" class="dropdown-item">Retro</a>
						<a href="/obchod/krabice-krabicky/" class="dropdown-item">Krabice, krabičky</a>
						<a href="/obchod/material/" class="dropdown-item">Materiál</a>
						<a href="/obchod/zazitky/" class="dropdown-item">Zážitky</a>
						<a href="/obchod/barva/" class="dropdown-item">Barva</a>
						<a href="/obchod/knihy/" class="dropdown-item">Knihy</a>
					</div>
				</li>

				<li class="nav-item">
					<a href="/" class="nav-link">Úvod</a>
				</li>

				<li class="nav-item dropdown">
					<a href="/o-nas/" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O nás</a>
					<div class="dropdown-menu">
						<a href="/o-nas/pro-media/" class="dropdown-item">Pro média</a>
						<a href="/o-nas/kontaktni-udaje/" class="dropdown-item">Kontaktní údaje</a>
					</div>
				</li>

				<li class="nav-item">
					<a href="/prodejny/" class="nav-link">Prodejny</a>
				</li>

				<li class="nav-item">
					<a href="/o-nas/kontaktni-udaje/" class="nav-link">Kontakt</a>
				</li>

			</ul>

		</div>
	</div>
</nav>

[/example]
