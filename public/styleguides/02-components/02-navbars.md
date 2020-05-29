Navbars
=======

Navbars are based on Bootstrap Navbar component.
				
### Top navbar. 

Top navbar with user
Note that in collapsed state it includes also links from main navbar.

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
						<a href="#" class="nav-link">
							<span class="fas fa-shopping-cart"></span> Košík </a>
					</li>
				</ul>

			</div>
		</div>

		<div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item"><a href="#" class="nav-link"><span class="fas fa-key"></span> Přihlásit se</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Registrovat</a></li>

			</ul>

			<hr class="mobile-separator">

			<form class="form-inline navbar-search" action="/vyhledavani/">
				<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="Hledat">
				<button type="submit" class="btn btn-sm btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>


			<ul class="navbar-nav navbar-nav-main-mobile d-block d-md-none">
				<li class="nav-item"><a href="#" class="nav-link">Obchod</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Úvod</a></li>
				<li class="nav-item"><a href="#" class="nav-link">O nás</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Prodejny</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Kontakt</a></li>
			</ul>

		</div>
		<div class="nav__desktop-items">
			<ul class="navbar-nav js--basket_info">
				<li class="nav-item">
					<a href="#" class="nav-link">
						<span class="fas fa-shopping-cart"></span> Košík 
					</a>
				</li>
			</ul>

		</div>
	</div>
</nav>
[/example]

The same nevbar when user is logged in and with indicator of item number in cart

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
						<a href="#" class="nav-link">
							<span class="fas fa-shopping-cart"></span> Košík <span class="cart-num-items">3</span>
						</a>
					</li>
				</ul>

			</div>
		</div>

		<div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-user"></span> admin
					</a>
					<div class="dropdown-menu">
						<a href="#" class="dropdown-item">Profil</a>
						<a href="#" class="dropdown-item">Moje objednávky</a>
						<a href="#" class="dropdown-item">Dodací adresy</a>
						<div class="dropdown-divider"></div>
						<a data-method="post" class="dropdown-item" href="#">Odhlásit se</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Administrace</a> </li>
			</ul>

			<hr class="mobile-separator">

			<form class="form-inline navbar-search" action="/vyhledavani/">
				<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="Hledat">
				<button type="submit" class="btn btn-sm btn-primary" title="Hledat"><span class="fas fa-search"></span></button>
			</form>

			<ul class="navbar-nav navbar-nav-main-mobile d-block d-md-none">
				<li class="nav-item"><a href="#" class="nav-link">Obchod</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Úvod</a></li>
				<li class="nav-item"><a href="#" class="nav-link">O nás</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Prodejny</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Kontakt</a></li>
			</ul>

		</div>
		<div class="nav__desktop-items">
			<ul class="navbar-nav js--basket_info">
				<li class="nav-item">
					<a href="#" class="nav-link">
						<span class="fas fa-shopping-cart"></span> Košík <span class="cart-num-items">3</span>
					</a>
				</li>
			</ul>

		</div>
	</div>
</nav>

[/example]
		
### Main navbar. 
Note that on small screen this navbar is hidden and its links are visible in top navbar.  
Class <code>navbar--hoverable-dropdowns</code> makes dropdowns behaving different than default Bootstrap dropdowns - they open on mouse over and parent link is clickable. To revert dropdowns to standard Bootstrap behavior, simply remove <code>navbar--hoverable-dropdowns</code> class.

[example]

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
						<a href="#" class="dropdown-item">Materiál</a>
						<a href="#" class="dropdown-item">Zážitky</a>
						<a href="#" class="dropdown-item">Barva</a>
						<a href="#" class="dropdown-item">Knihy</a>
					</div>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">Úvod</a>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O nás</a>
					<div class="dropdown-menu">
						<a href="#" class="dropdown-item">Pro média</a>
						<a href="#" class="dropdown-item">Kontaktní údaje</a>
					</div>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">Prodejny</a>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">Kontakt</a>
				</li>

			</ul>

		</div>
	</div>
</nav>

[/example]
