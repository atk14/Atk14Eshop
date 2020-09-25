Navbars
=======

Navbars are based on Bootstrap Navbar component.
There are two navbars in the site header. On narrow screens there is only one collapsed navbar containing items from both navbars to avoid multiple hamburger menus (try to resize this browser window to see it in action).
				
## Top navbar

There are two instances of top navbar in the header - one for desktop view and another one for mobile displays. Most of the markup are shared btween both of them.

### Top navbar navs

Navs are main building component of navbars. For top navbar we have several nav layouts created by adding <code>nav--*</code> modifier class to <code>navbar-nav component</code>, all variants are derived from Bootstrap nav component. Text and border colors is determined by <code>navbar-dark</code> or <code>navbar-light</code> classes of parent navbar component


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






<hr>

[example]
TODO
[/example]

The same nevbar when user is logged in and with indicator of item number in cart

[example]
TODO
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

	<p class="mt-3">Light variant</p>

	<nav class="navbar navbar-light bg-light navbar-expand-md d-none d-md-flex navbar-main navbar--hoverable-dropdowns">
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

	<p class="mt-3">Light variant</p>

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
