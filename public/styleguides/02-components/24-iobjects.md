iObjects
========

iObjects are objects placed usually within text content of article, page, product description etc. They may contain images, galleries, embedded videos, links, product ads etc.

## Picture iObject

[example]
<div class="iobject iobject--picture">
	<figure>
		<a class="iobject--picture__link" href="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_2000x1333_8169f34e013586fc.jpg" title="Obrázek vložený do textu" data-size="2000x1333">
			<img class="iobject--picture__img img-fluid" src="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_1100x733_5a6bf349ab8d1fc2.jpg" width="1100" height="733" class="img-responsive" alt="Obrázek vložený do textu" srcset="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_600x399_2e393aa27e479f82.jpg 600w, http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_800x533_881624f39158db46.jpg 800w, http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_1100x733_5a6bf349ab8d1fc2.jpg 1100w" sizes="100vw">
		</a>
		<figcaption class="iobject__caption">
			<div class="iobject__title"><a class="iobject--picture__link" href="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_2000x1333_8169f34e013586fc.jpg" title="Obrázek vložený do textu" data-size="2000x1333"><span class="fas fa-search-plus"></span></a> <span class="iobject__title__separator">|</span> Obrázek vložený do textu</div>
		</figcaption>
	</figure>
</div>
[/example]

## Gallery iObject
There is Gallery component inside. It may contain various types of [gallery component](/styleguides/components%3Aimage-galleries/) (except Product Galleries).

[example]
<div class="iobject iobject--gallery">

	<section class="photo-gallery">
		<div class="gallery__images">
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_2000x1352_0279a0bc3c8af769.jpg" title="Popisek ukázkového obrázku" data-size="2000x1352">
					<img src="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_295x200_5483742e7606eb68.jpg" width="295" height="200" alt="Název obrázku" class="">
				</a>
				<figcaption>
					<div><strong>Název obrázku</strong></div>
					<div>Popisek ukázkového obrázku</div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_2000x608_4e580a3dde574a15.jpg" title="" data-size="2000x608">
					<img src="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_657x200_eabe43b407198f43.jpg" width="657" height="200" alt="Kolo" class="">
				</a>
				<figcaption>
					<div><strong>Kolo</strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_1066x1600_960ea7861464db46.jpg" title="" data-size="1066x1600">
					<img src="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_133x200_dd6ab44e70d32bcb.jpg" width="133" height="200" alt="Medůza" class="">
				</a>
				<figcaption>
					<div><strong>Medůza</strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_2000x1419_25cfc5a13c3023fd.jpg" title="Přístroj pro instantní fotogalerie" data-size="2000x1419">
					<img src="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_281x200_2cd192f792d4794a.jpg" width="281" height="200" alt="Polaroid" class="">
				</a>
				<figcaption>
					<div><strong>Polaroid</strong></div>
					<div>Přístroj pro instantní fotogalerie</div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_2000x1600_7928c249ff7cbd5e.jpg" title="" data-size="2000x1600">
					<img src="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_250x200_aa25e7fe3d59bf41.jpg" width="250" height="200" alt="" class="">
				</a>
				<figcaption>
					<div><strong></strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_2000x1333_901b4905f313ce37.jpg" title="" data-size="2000x1333">
					<img src="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_300x200_32c13cf1d2aa6029.jpg" width="300" height="200" alt="" class="">
				</a>
				<figcaption>
					<div><strong></strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_1271x1600_48076dbb3bee2310.jpg" title="" data-size="1271x1600">
					<img src="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_158x200_9c81ac08fb818c76.jpg" width="158" height="200" alt="" class="">
				</a>
				<figcaption>
					<div><strong></strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_1066x1600_ef071295f3623f92.jpg" title="" data-size="1066x1600">
					<img src="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_133x200_0035d611048d1886.jpg" width="133" height="200" alt="" class="">
				</a>
				<figcaption>
					<div><strong></strong></div>
					<div></div>
				</figcaption>
			</figure>
			<figure class="gallery__item">
				<a href="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_1066x1600_fba8195b3229b1fe.jpg" title="" data-size="1066x1600">
					<img src="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_133x200_caec64189ba3e9d2.jpg" width="133" height="200" alt="" class="">
				</a>
				<figcaption>
					<div><strong></strong></div>
					<div></div>
				</figcaption>
			</figure>
		</div>
		<div class="gallery__caption iobject__caption">
			<div class="gallery__title iobject__title">Vložená fotogalerie</div>
			<div class="gallery__description iobject__description">Toto je ukázka galerie vložené do stránky.</div>
		</div>
	</section>

</div>
[/example]


## Video iObject

By default, markup expects movie aspect ratio to be 16:9.

[example]
<div class="iobject iobject--video">
	<div class="embed-responsive embed-responsive-16by9">
		<iframe width="825" height="464" src="https://www.youtube.com/embed/dcsiIoQody4?feature=oembed" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
	<div class="iobject__caption">
		<div class="iobject__title">Earth Views from the International Space Station</div>
	</div>
</div>
[/example]


## Audio iObject

Audio iObject uses default browser styling of controls so it may look different across browsers. This iObject is intended for self-hosted audio files.  
(not yet supported by ATK14Eshop)

[example]
<div class="iobject iobject--audio">
	<audio controls>
		<source src="https://www.w3schools.com/html/horse.ogg" type="audio/ogg">
	</audio>
	<div class="iobject__caption">
    <div class="iobject__title">This is how horse sounds.</div>
  </div>
</div>
[/example]

For audio embedded from sites like SoundCloud, simply use their own embed code.
(not yet supported by ATK14Eshop)

[example]
<div class="iobject iobject--audio">
	<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/809320675&color=%23ff5500&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/wereus" title="wereus" target="_blank" style="color: #cccccc; text-decoration: none;">wereus</a> · <a href="https://soundcloud.com/wereus/lockdown" title="Lockdown" target="_blank" style="color: #cccccc; text-decoration: none;">Lockdown</a></div>
	<div class="iobject__caption">
    <div class="iobject__title">This is just generic iframe embed.</div>
  </div>
</div>
[/example]

## File iObject
[example]
<div class="iobject iobject--file">
	<a href="#">
		<span>
			<span class="fileicon fileicon-pdf fileicon-color"></span>
			<span class="file-name">dummy.pdf</span>
		</span>
		<span class="iobject--file__meta">(PDF, 13,0 kB)</span>
	</a>
</div>

<p>Two or more File iObjects stacked:</p>

<div class="iobject iobject--file">
	<a href="#">
		<span>
			<span class="fileicon fileicon-pdf fileicon-color"></span>
			<span class="file-name">dummy.pdf</span>
		</span>
		<span class="iobject--file__meta">(PDF, 13,0 kB)</span>
	</a>
</div>

<div class="iobject iobject--file">
	<a href="#">
		<span>
			<span class="fileicon fileicon-zip fileicon-color"></span>
			<span class="file-name">dummy.zip</span>
		</span>
		<span class="iobject--file__meta">(ZIP, 18,0 kB)</span>
	</a>
</div>
[/example]

## Product Promotion iObject

Creates link to product with image, basic description and price.

[example]

<div class="iobject iobject--card_promotion">
	<a href="/produkt/brasna-na-fotak/" class="iobject__content">

		<div class="iobject__image">
			<img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/aca/2daca/2886x2165/Kaog3H_800x800xc_b90061d2b99471d3.jpg" alt="Brašna na foťák" width="800" height="800">
			<div class="iobject__flags">
				<div class="product__flag product__flag--sale product__flag--sm">
					<span class="product__flag__title">Sleva</span> <span class="product__flag__number">15&nbsp;%</span>
				</div>
			</div>
		</div>

		<div class="iobject__body">

			<div>
				<h4 class="iobject__title">
					Brašna na foťák
				</h4>

				<div class="iobject__description">
					<p>Kvalitní kožená brašna.</p>
				</div>
			</div>

			<div class="iobject__footer">
				<div class="card-price">
					<span class="price--before-discount"><span class="currency_main"><span class="currency_main__price">23,14</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">bez DPH</span></span>
					<div class="price--primary"><span class="currency_main"><span class="currency_main__price">19,67</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">bez DPH</span></div>
					<div class="price--incl-vat"><span class="currency_main"><span class="currency_main__price">23,80</span>&nbsp;<span class="currency_main__currency">EUR</span><span class="currency_main__ordering-unit"></span></span> <span class="vat_label">vč. DPH</span></div>
				</div>

				<span class="card-footer-icon"><span class="fas fa-chevron-right"></span></span>
			</div>

		</div>

	</a>
</div>
[/example]

## Contact Card iObject

Simple contact card. When using more than one Contact Card iObjects together, they should be wrapped in Contact card group iObject (see below).

[example]
<div class="iobject--contact">
	<div class="iobject__image">
		<img src="http://i.pupiq.net/i/6a/6a/91f/2f91f/1000x1249/pJ2r1i_100x100xc_ecbfd7b2fd239518.jpg" alt="Ellen Ripley" width="100" height="100">
	</div>
	<div class="iobject__body">
		<h4 class="iobject__title">
			Ellen Ripley <span>warrant officer</span>
		</h4>
		<div class="iobject__description">
			<p>Beginning her career as a&nbsp;warrant officer with Weyland‑Yutani's&nbsp;commercial freight operations, she was assigned to the USCSS Nostromo in 2122.</p>
			<ul class="list--icons">
				<li>
					<span class="list--icons__icon"><span class="fas fa-envelope"></span></span>
					<span class="list--icons__value"><a href="mailto:ripley@weyland-yutani.com">ripley@weyland‑yutani.com</a></span>
				</li>
				<li>
					<span class="list--icons__icon"><i class="fas fa-mobile-alt"></i></span>
					<span class="list--icons__value"><a href="#">+420 123 456 789</a></span>
				</li>
				<li>
					<span class="list--icons__icon"><span class="fas fa-globe"></span></span>
					<span class="list--icons__value"><a href="https://avp.fandom.com/wiki/Ellen_Ripley">avp.fandom.com/wiki/Ellen_Ripley</a></span>
				</li>
			</ul>

		</div>
		<div class="iobject__body-bottom">
			<div>
				<a href="#person_qr_5f57a6054b046" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="person_qr_5f57a6054b046" class="qr-code-link">
					<ul class="list--icons mb-0">
						<li>
							<span class="list--icons__icon"><span class="fas fa-qrcode"></span></span>
							<span class="list--icons__value">QR code <span class="icon-down"><i class="fas fa-chevron-down"></i></span></span>
						</li>
					</ul>
				</a>
				<div class="collapse" id="person_qr_5f57a6054b046">
					<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=https%3A%2F%2Fsnapps.eu&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="QR kód" class="iobject__qr-code">
				</div>
			</div>
			<div class="text-right align-self-start">
				<a href="#" class="btn btn-sm btn-outline-primary">Více… <i class="fas fa-chevron-right"></i></a>
			</div>
		</div>
	</div>
</div>
[/example]

## Contact Card Group iObject

Contact card group is responsive wrapper for multiple Contact Card iObjects.

[example]
<div class="iobject--contact-group">

	<div class="iobject__heading">Seznam více osob</div>

	<div class="iobject__cards">

		<div class="iobject--contact">
			<div class="iobject__image">
				<img src="http://i.pupiq.net/i/6a/6a/912/2f912/204x229/f2vTD5_100x100xc_a8fa2904097863f9.jpg" alt="Fantomas" width="100" height="100">
			</div>
			<div class="iobject__body">
				<h4 class="iobject__title">
					Fantomas <span>Globální superzločinec</span>
				</h4>
				<div class="iobject__description">
					<p>Ano, jsem to já, Fantomas. Mou pravou tvář nikdy nepoznáš.</p>

					<ul class="list--icons">
						<li>
							<span class="list--icons__icon"><span class="fab fa-facebook"></span></span>
							<span class="list--icons__value"><a href="https://facebook.com/">facebook.com</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fab fa-twitter"></span></span>
							<span class="list--icons__value"><a href="https://twitter.com/">twitter.com</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-envelope"></span></span>
							<span class="list--icons__value"><a href="mailto:fantomas@fantomas.com">fantomas@fantomas.com</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-mobile-alt"></span></span>
							<span class="list--icons__value"><a href="tel:+420123456789">+420&nbsp;123&nbsp;456&nbsp;789</a></span>
						</li>
					</ul>

				</div>
				<div class="iobject__body-bottom">
					<div>
						<a href="#person_qr_5f57a6052ad34" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="person_qr_5f57a6052ad34" class="qr-code-link">
							<ul class="list--icons mb-0">
								<li>
									<span class="list--icons__icon"><span class="fas fa-qrcode"></span></span>
									<span class="list--icons__value">QR code <span class="icon-down"><i class="fas fa-chevron-down"></i></span></span>
								</li>
							</ul>
						</a>
						<div class="collapse" id="person_qr_5f57a6052ad34">
							<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=https%3A%2F%2Fsnapps.eu&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="QR kód" class="iobject__qr-code">
						</div>
					</div>
					<div class="text-right align-self-start">
					</div>
				</div>
			</div>
		</div>

		<div class="iobject--contact">
			<div class="iobject__image">
				<img src="http://i.pupiq.net/i/6a/6a/91e/2f91e/2000x1125/zTUyiW_100x100xc_67da62e4693f925d.jpg" alt="The Slečna" width="100" height="100">
			</div>
			<div class="iobject__body">
				<h4 class="iobject__title">
					The Slečna <span></span>
				</h4>
				<div class="iobject__description">


					<ul class="list--icons">
						<li>
							<span class="list--icons__icon"><span class="fas fa-envelope"></span></span>
							<span class="list--icons__value"><a href="mailto:slecna@email.email">slecna@email.email</a></span>
						</li>
					</ul>

				</div>
				<div class="iobject__body-bottom">
					<div>
						<a href="#person_qr_5f57a60538abd" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="person_qr_5f57a60538abd" class="qr-code-link">
							<ul class="list--icons mb-0">
								<li>
									<span class="list--icons__icon"><span class="fas fa-qrcode"></span></span>
									<span class="list--icons__value">QR code <span class="icon-down"><i class="fas fa-chevron-down"></i></span></span>
								</li>
							</ul>
						</a>
						<div class="collapse" id="person_qr_5f57a60538abd">
							<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=https%3A%2F%2Fsnapps.eu&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="QR kód" class="iobject__qr-code">
						</div>
					</div>
					<div class="text-right align-self-start">
					</div>
				</div>
			</div>
		</div>

		<div class="iobject--contact">
			<div class="iobject__image">
				<img src="/public/dist/images/styleguides-demo-face.jpg" alt="Mrs. Paní" width="100" height="100">
			</div>
			<div class="iobject__body">
				<h4 class="iobject__title">
					Charlie Root <span>Evil Admin</span>
				</h4>
				<div class="iobject__description">
					<p>Quinoa pabst four loko, pour‑over bespoke truffaut tumblr forage.</p>

					<ul class="list--icons">
						<li>
							<span class="list--icons__icon"><span class="fab fa-facebook"></span></span>
							<span class="list--icons__value"><a href="https://facebook.com/">facebook.com</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-envelope"></span></span>
							<span class="list--icons__value"><a href="mailto:email@email.email">email@email.email</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-mobile-alt"></span></span>
							<span class="list--icons__value"><a href="tel:+420123456789">+420&nbsp;123&nbsp;456&nbsp;789</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-globe"></span></span>
							<span class="list--icons__value"><a href="https://tkk.cz/">tkk.cz</a></span>
						</li>
					</ul>

				</div>
				<div class="iobject__body-bottom">
					<div>
						<a href="#person_qr_5f57a6053ff53" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="person_qr_5f57a6053ff53" class="qr-code-link">
							<ul class="list--icons mb-0">
								<li>
									<span class="list--icons__icon"><span class="fas fa-qrcode"></span></span>
									<span class="list--icons__value">QR code <span class="icon-down"><i class="fas fa-chevron-down"></i></span></span>
								</li>
							</ul>
						</a>
						<div class="collapse" id="person_qr_5f57a6053ff53">
							<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=https%3A%2F%2Fsnapps.eu&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="QR kód" class="iobject__qr-code">
						</div>
					</div>
					<div class="text-right align-self-start">
					</div>
				</div>
			</div>
		</div>

		<div class="iobject--contact">
			<div class="iobject__image">
				<img src="http://i.pupiq.net/i/6a/6a/91f/2f91f/1000x1249/pJ2r1i_100x100xc_ecbfd7b2fd239518.jpg" alt="Ellen Ripley" width="100" height="100">
			</div>
			<div class="iobject__body">
				<h4 class="iobject__title">
					Ellen Ripley <span>warrant officer</span>
				</h4>
				<div class="iobject__description">
					<p>Beginning her career as a&nbsp;warrant officer with Weyland‑Yutani's&nbsp;commercial freight operations, she was assigned to the USCSS Nostromo in 2122.</p>
					<ul class="list--icons">
						<li>
							<span class="list--icons__icon"><span class="fas fa-envelope"></span></span>
							<span class="list--icons__value"><a href="mailto:ripley@weyland-yutani.com">ripley@weyland‑yutani.com</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><i class="fas fa-mobile-alt"></i></span>
							<span class="list--icons__value"><a href="#">+420 123 456 789</a></span>
						</li>
						<li>
							<span class="list--icons__icon"><span class="fas fa-globe"></span></span>
							<span class="list--icons__value"><a href="https://avp.fandom.com/wiki/Ellen_Ripley">avp.fandom.com/wiki/Ellen_Ripley</a></span>
						</li>
					</ul>

				</div>
				<div class="iobject__body-bottom">
					<div>
						<a href="#person_qr_5f57a6054b046" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="person_qr_5f57a6054b046"  class="qr-code-link">
							<ul class="list--icons mb-0">
								<li>
									<span class="list--icons__icon"><span class="fas fa-qrcode"></span></span>
									<span class="list--icons__value">QR code <span class="icon-down"><i class="fas fa-chevron-down"></i></span></span>
								</li>
							</ul>
						</a>
						<div class="collapse" id="person_qr_5f57a6054b046">
							<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=https%3A%2F%2Fsnapps.eu&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="QR kód" class="iobject__qr-code">
						</div>
					</div>
					<div class="text-right align-self-start">
						<a href="#" class="btn btn-sm btn-outline-primary">Více… <i class="fas fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
[/example]

## Making iObjects span full width of a page

iObjects (or any other HTML elements) that are direct children of <code>.article__body</code> or <code>.page__body</code> elements may be make full width simply by adding <code>fullwidth</code> class.

[example]
<div class="iobject iobject--picture fullwidth">
	<figure>
		<a class="iobject--picture__link" href="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_2000x1333_8169f34e013586fc.jpg" title="Obrázek vložený do textu" data-size="2000x1333">
			<img class="iobject--picture__img img-fluid" src="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_1100x733_5a6bf349ab8d1fc2.jpg" width="1100" height="733" class="img-responsive" alt="Obrázek vložený do textu" srcset="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_600x399_2e393aa27e479f82.jpg 600w, http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_800x533_881624f39158db46.jpg 800w, http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_1100x733_5a6bf349ab8d1fc2.jpg 1100w" sizes="100vw">
		</a>
		<figcaption class="iobject__caption">
			<div class="iobject__title"><a class="iobject--picture__link" href="http://i.pupiq.net/i/6f/6f/ab5/2dab5/2000x1333/VmExjD_2000x1333_8169f34e013586fc.jpg" title="Obrázek vložený do textu" data-size="2000x1333"><span class="fas fa-search-plus"></span></a> <span class="iobject__title__separator">|</span> Obrázek vložený do textu</div>
		</figcaption>
	</figure>
</div>
[/example]