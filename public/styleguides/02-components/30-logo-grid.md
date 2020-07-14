Logo Grid
=========

Logo grid displays grid of logotypes. Padding around logo is set individually for each item based on its aspect ratio to make percepted logo sizes roughly equal. This is done automatically when using <code>shared/logo_grid</code> template.

Logos may have either percentage or fixed size. For best results, use of SVG or PNG+alpha images is recommended. Note that logo wrappers have either <code>logo--horizontal</code> or <code>logo--vertical</code> class depending on image aspect ratio.

**Important**: Logo images should have tight crop, otherwise calculated padding would be weird.
	
![How to crop logo image](/public/dist/images/logo-crop.png)
	
## Basic logo grid with variable logo sizes

[example]
<section class="section--logo-grid">

	<header class="content-header">
		<div class="content-header__text">
			<h2 class="h1">Značky</h2>
		</div>
	</header>

	<div class="logo-grid">

		<a href="#" title="Cottyshop" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 14.545454545455%;">
					<img src="http://i.pupiq.net/i/6f/6f/854/2f854/767x192/Bcv6ir_400x100_a2ccebf2d1796f8a.svg" alt="Cottyshop">
				</span>
			</span>
		</a>

		<a href="#" title="Circle" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/860/2f860/600x600/oM9rJU_400x400_cdd680c27d001f41.svg" alt="Circle">
				</span>
			</span>
		</a>

		<a href="#" title="Dumb &amp; Dumber" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 21.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/856/2f856/800x518/z5rW2N_400x259_841ee389104972de.svg" alt="Dumb &amp; Dumber">
				</span>
			</span>
		</a>

		<a href="#" title="Superior*Product" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 17.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/857/2f857/800x341/FQiBSh_400x170_277f0f666f8ef41c.svg" alt="Superior*Product">
				</span>
			</span>
		</a>

		<a href="#" title="xY+/-" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 24.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/858/2f858/800x650/vFAr3h_400x325_ba845312678cbf25.svg" alt="xY+/-">
				</span>
			</span>
		</a>

		<a href="#" title="iQ Square" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/859/2f859/800x800/lqUsVv_400x400_27818c5b0b892af7.svg" alt="iQ Square">
				</span>
			</span>
		</a>

		<a href="#" title="Tall Tall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 18.909090909091%;">
					<img src="http://i.pupiq.net/i/6f/6f/85a/2f85a/442x900/NqVulH_196x400_607b611906601861.svg" alt="Tall Tall">
				</span>
			</span>
		</a>

		<a href="#" title="Verticall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 25.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/85b/2f85b/316x365/B5U2lu_346x400_62ed67ba8a02acfe.svg" alt="Verticall">
				</span>
			</span>
		</a>

		<a href="#" title="FAST" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 13.863636363636%;">
					<img src="http://i.pupiq.net/i/6f/6f/85c/2f85c/766x163/C47d1P_400x85_f32f87c7bec098e8.svg" alt="FAST">
				</span>
			</span>
		</a>

		<a href="#" title="Dorty Pejsek a Kočička" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 11.681818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/85e/2f85e/800x75/e1sNjf_400x37_f8acec5462feef75.png" alt="Dorty Pejsek a Kočička">
				</span>
			</span>
		</a>

		<a href="#" title="Snapps" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 15%;">
					<img src="http://i.pupiq.net/i/6f/6f/85d/2f85d/454x125/LqD17E_400x110_b13d0cd817d05f88.svg" alt="Snapps">
				</span>
			</span>
		</a>

	</div>

</section>
[/example]


## Basic logo grid with fixed logo sizes

Just add <code>logo-grid--fixed-size</code> modifier class

[example]
<section class="section--logo-grid">

	<header class="content-header">
		<div class="content-header__text">
			<h2 class="h1">Značky</h2>
		</div>
	</header>

	<div class="logo-grid logo-grid--fixed-size">

		<a href="#" title="Cottyshop" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 14.545454545455%;">
					<img src="http://i.pupiq.net/i/6f/6f/854/2f854/767x192/Bcv6ir_400x100_a2ccebf2d1796f8a.svg" alt="Cottyshop">
				</span>
			</span>
		</a>

		<a href="#" title="Circle" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/860/2f860/600x600/oM9rJU_400x400_cdd680c27d001f41.svg" alt="Circle">
				</span>
			</span>
		</a>

		<a href="#" title="Dumb &amp; Dumber" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 21.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/856/2f856/800x518/z5rW2N_400x259_841ee389104972de.svg" alt="Dumb &amp; Dumber">
				</span>
			</span>
		</a>

		<a href="#" title="Superior*Product" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 17.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/857/2f857/800x341/FQiBSh_400x170_277f0f666f8ef41c.svg" alt="Superior*Product">
				</span>
			</span>
		</a>

		<a href="#" title="xY+/-" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 24.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/858/2f858/800x650/vFAr3h_400x325_ba845312678cbf25.svg" alt="xY+/-">
				</span>
			</span>
		</a>

		<a href="#" title="iQ Square" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/859/2f859/800x800/lqUsVv_400x400_27818c5b0b892af7.svg" alt="iQ Square">
				</span>
			</span>
		</a>

		<a href="#" title="Tall Tall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 18.909090909091%;">
					<img src="http://i.pupiq.net/i/6f/6f/85a/2f85a/442x900/NqVulH_196x400_607b611906601861.svg" alt="Tall Tall">
				</span>
			</span>
		</a>

		<a href="#" title="Verticall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 25.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/85b/2f85b/316x365/B5U2lu_346x400_62ed67ba8a02acfe.svg" alt="Verticall">
				</span>
			</span>
		</a>

		<a href="#" title="FAST" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 13.863636363636%;">
					<img src="http://i.pupiq.net/i/6f/6f/85c/2f85c/766x163/C47d1P_400x85_f32f87c7bec098e8.svg" alt="FAST">
				</span>
			</span>
		</a>

		<a href="#" title="Dorty Pejsek a Kočička" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 11.681818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/85e/2f85e/800x75/e1sNjf_400x37_f8acec5462feef75.png" alt="Dorty Pejsek a Kočička">
				</span>
			</span>
		</a>

		<a href="#" title="Snapps" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 15%;">
					<img src="http://i.pupiq.net/i/6f/6f/85d/2f85d/454x125/LqD17E_400x110_b13d0cd817d05f88.svg" alt="Snapps">
				</span>
			</span>
		</a>

	</div>

</section>
[/example]

## Logo Grid with brand names

[example]
<section class="section--logo-grid">

	<header class="content-header">
		<div class="content-header__text">
			<h2 class="h1">Značky na homepage</h2>
		</div>
	</header>

	<div class="logo-grid logo-grid--fixed-size">

		<a href="#" title="Cottyshop" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 14.545454545455%;">
					<img src="http://i.pupiq.net/i/6f/6f/854/2f854/767x192/Bcv6ir_400x100_a2ccebf2d1796f8a.svg" alt="Cottyshop">
				</span>
			</span>
			<span class="logo-grid__text">
				Cottyshop
			</span>
		</a>

		<a href="#" title="Circle" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/860/2f860/600x600/oM9rJU_400x400_cdd680c27d001f41.svg" alt="Circle">
				</span>
			</span>
			<span class="logo-grid__text">
				Circle
			</span>
		</a>

		<a href="#" title="Dumb &amp; Dumber" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 21.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/856/2f856/800x518/z5rW2N_400x259_841ee389104972de.svg" alt="Dumb &amp; Dumber">
				</span>
			</span>
			<span class="logo-grid__text">
				Dumb &amp; Dumber
			</span>
		</a>

		<a href="#" title="Superior*Product" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 17.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/857/2f857/800x341/FQiBSh_400x170_277f0f666f8ef41c.svg" alt="Superior*Product">
				</span>
			</span>
			<span class="logo-grid__text">
				Superior*Product
			</span>
		</a>

		<a href="#" title="xY+/-" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 24.772727272727%;">
					<img src="http://i.pupiq.net/i/6f/6f/858/2f858/800x650/vFAr3h_400x325_ba845312678cbf25.svg" alt="xY+/-">
				</span>
			</span>
			<span class="logo-grid__text">
				xY+/-
			</span>
		</a>

		<a href="#" title="iQ Square" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 28.181818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/859/2f859/800x800/lqUsVv_400x400_27818c5b0b892af7.svg" alt="iQ Square">
				</span>
			</span>
			<span class="logo-grid__text">
				iQ Square
			</span>
		</a>

		<a href="#" title="Tall Tall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 18.909090909091%;">
					<img src="http://i.pupiq.net/i/6f/6f/85a/2f85a/442x900/NqVulH_196x400_607b611906601861.svg" alt="Tall Tall">
				</span>
			</span>
			<span class="logo-grid__text">
				Tall Tall
			</span>
		</a>

		<a href="#" title="Verticall" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--vertical" style="padding: 25.727272727273%;">
					<img src="http://i.pupiq.net/i/6f/6f/85b/2f85b/316x365/B5U2lu_346x400_62ed67ba8a02acfe.svg" alt="Verticall">
				</span>
			</span>
			<span class="logo-grid__text">
				Verticall
			</span>
		</a>

		<a href="#" title="FAST" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 13.863636363636%;">
					<img src="http://i.pupiq.net/i/6f/6f/85c/2f85c/766x163/C47d1P_400x85_f32f87c7bec098e8.svg" alt="FAST">
				</span>
			</span>
			<span class="logo-grid__text">
				FAST
			</span>
		</a>

		<a href="#" title="Dorty Pejsek a Kočička" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 11.681818181818%;">
					<img src="http://i.pupiq.net/i/6f/6f/85e/2f85e/800x75/e1sNjf_400x37_f8acec5462feef75.png" alt="Dorty Pejsek a Kočička">
				</span>
			</span>
			<span class="logo-grid__text">
				Dorty Pejsek a Kočička
			</span>
		</a>

		<a href="#" title="Snapps" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			<span class="logo-grid__image">
				<span class="logo-grid__logo-wrap logo--horizontal" style="padding: 15%;">
					<img src="http://i.pupiq.net/i/6f/6f/85d/2f85d/454x125/LqD17E_400x110_b13d0cd817d05f88.svg" alt="Snapps">
				</span>
			</span>
			<span class="logo-grid__text">
				Snapps
			</span>
		</a>

	</div>
	
</section>
[/example]