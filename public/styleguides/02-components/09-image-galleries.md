Image galleries
===============

Various types of image galleries. All galleries are designed to work with our implementation of [PhotoSwipe](https://photoswipe.com/) viewer.

Max-width inline styles in examples are for illustration purposes only. In live use gallery width is constrained typically by their placement in layout.

## Basic image gallery
With optional gallery caption. It works with our PhotoSwipe implementation. Invisible <code>figcaption</code> is used by PhotoSwipe to display image caption. Images are displayed uncropped (aspect ratio is preserved) with the same heights (only really wide panoramic images are cropped by CSS). This gallery may be used in [Gallery iObject](/styleguides/components%3Aiobjects/).

[example]
<section class="photo-gallery">
	<div class="gallery__images" data-pswp-uid="2">
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_2000x1352_0279a0bc3c8af769.jpg" title="Popisek ukázkového obrázku" data-size="2000x1352">
				<img src="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_295x200_5483742e7606eb68.jpg" alt="Název obrázku" class="" width="295" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Název obrázku</div>
				<div class="gallery-item__description">Popisek ukázkového obrázku</div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_2000x608_4e580a3dde574a15.jpg" title="" data-size="2000x608">
				<img src="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_657x200_eabe43b407198f43.jpg" alt="Kolo" class="" width="657" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Název obrázku</div>
				<div class="gallery-item__description">Popisek ukázkového obrázku</div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_1066x1600_960ea7861464db46.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_133x200_dd6ab44e70d32bcb.jpg" alt="Medůza" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Medůza</div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_2000x1419_25cfc5a13c3023fd.jpg" title="Přístroj pro instantní fotogalerie" data-size="2000x1419">
				<img src="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_281x200_2cd192f792d4794a.jpg" alt="Polaroid" class="" width="281" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Polaroid</div>
				<div class="gallery-item__description">Přístroj pro instantní fotogalerie</div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_2000x1600_7928c249ff7cbd5e.jpg" title="" data-size="2000x1600">
				<img src="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_250x200_aa25e7fe3d59bf41.jpg" alt="" class="" width="250" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_2000x1333_901b4905f313ce37.jpg" title="" data-size="2000x1333">
				<img src="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_300x200_32c13cf1d2aa6029.jpg" alt="" class="" width="300" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_1271x1600_48076dbb3bee2310.jpg" title="" data-size="1271x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_158x200_9c81ac08fb818c76.jpg" alt="" class="" width="158" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_1066x1600_ef071295f3623f92.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_133x200_0035d611048d1886.jpg" alt="" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_1066x1600_fba8195b3229b1fe.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_133x200_caec64189ba3e9d2.jpg" alt="" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Vložená fotogalerie</div>
		<div class="gallery__description iobject__description">Toto je ukázka galerie vložené do stránky.</div>
	</div>
</section>
[/example]

Basic image gallery made smaller with <code>photo-gallery--compact</code> class:

[example]
<section class="photo-gallery photo-gallery--compact">
	<div class="gallery__images" data-pswp-uid="2">
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_2000x1352_0279a0bc3c8af769.jpg" title="Popisek ukázkového obrázku" data-size="2000x1352">
				<img src="http://i.pupiq.net/i/6f/6f/ab6/2dab6/2000x1352/TmC2q7_295x200_5483742e7606eb68.jpg" alt="Název obrázku" class="" width="295" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Název obrázku</div>
				<div class="gallery-item__description">Popisek ukázkového obrázku</div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_2000x608_4e580a3dde574a15.jpg" title="" data-size="2000x608">
				<img src="http://i.pupiq.net/i/6f/6f/ab7/2dab7/2000x608/DHcISy_657x200_eabe43b407198f43.jpg" alt="Kolo" class="" width="657" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Kolo</div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_1066x1600_960ea7861464db46.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/ab8/2dab8/2000x3000/87VB9L_133x200_dd6ab44e70d32bcb.jpg" alt="Medůza" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Medůza</div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_2000x1419_25cfc5a13c3023fd.jpg" title="Přístroj pro instantní fotogalerie" data-size="2000x1419">
				<img src="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_281x200_2cd192f792d4794a.jpg" alt="Polaroid" class="" width="281" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title">Polaroid</div>
				<div class="gallery-item__description">Přístroj pro instantní fotogalerie</div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_2000x1600_7928c249ff7cbd5e.jpg" title="" data-size="2000x1600">
				<img src="http://i.pupiq.net/i/6f/6f/aba/2daba/2000x1600/pTaSqm_250x200_aa25e7fe3d59bf41.jpg" alt="" class="" width="250" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_2000x1333_901b4905f313ce37.jpg" title="" data-size="2000x1333">
				<img src="http://i.pupiq.net/i/6f/6f/abb/2dabb/2000x1333/n7kaTb_300x200_32c13cf1d2aa6029.jpg" alt="" class="" width="300" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_1271x1600_48076dbb3bee2310.jpg" title="" data-size="1271x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abc/2dabc/2000x2517/wV2FOg_158x200_9c81ac08fb818c76.jpg" alt="" class="" width="158" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_1066x1600_ef071295f3623f92.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abd/2dabd/2000x3000/jQA7c3_133x200_0035d611048d1886.jpg" alt="" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_1066x1600_fba8195b3229b1fe.jpg" title="" data-size="1066x1600">
				<img src="http://i.pupiq.net/i/6f/6f/abe/2dabe/2000x3000/WI98Sx_133x200_caec64189ba3e9d2.jpg" alt="" class="" width="133" height="200">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>
	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Vložená fotogalerie</div>
		<div class="gallery__description iobject__description">Toto je ukázka galerie vložené do stránky.</div>
	</div>
</section>
[/example]

## Product gallery
This gallery component is used as main imagery on product detail page. Note that first image is larger than others.

[example]
<section class="photo-gallery photo-gallery--product product-gallery product-gallery--no-variants" style="max-width:600px;">

	<div class="gallery__images" data-pswp-uid="1">

		<figure class="gallery__item" data-id="16">
			<a href="https://i.pupiq.net/i/6f/6f/ad5/2dad5/3000x2250/TIwztc_2000x1500_e7757a3270287914.jpg" title="" data-size="2000x1500" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/ad5/2dad5/3000x2250/TIwztc_800x600_ce9f9a6ead0a6853.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="800" height="600">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="55">
			<a href="https://i.pupiq.net/i/6f/6f/adc/2dadc/5062x3416/Gxzwaj_2000x1349_a995ba0e13675c0e.jpg" title="" data-size="2000x1349" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/adc/2dadc/5062x3416/Gxzwaj_222x150_2fe2d1933aa1017a.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="222" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="56">
			<a href="https://i.pupiq.net/i/6f/6f/add/2dadd/1920x1280/xRLueJ_1920x1280_7a5bfa6cbddd455d.jpg" title="" data-size="1920x1280" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/add/2dadd/1920x1280/xRLueJ_225x150_60eb74b92ea70650.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="225" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
</section>		
[/example]
		
### Product gallery for product with variants
Markup is slightly more complex, fist image is outide gallery__images and its src is swapped by JavaScript when switching between variants in Add to cart widget.

[example]
<section class="photo-gallery photo-gallery--product product-gallery product-gallery--with-variants" style="max-width:600px;">

	<figure class="gallery__preview js_gallery_trigger">
		<a href="https://i.pupiq.net/i/6f/6f/adb/2dadb/1920x1486/kpRLTo_1920x1485_461ad79bef8dfa3c.jpg" title="" data-size="1920x1485" itemprop="contentUrl" data-preview_for="57">
			<img src="https://i.pupiq.net/i/6f/6f/adb/2dadb/1920x1486/kpRLTo_775x600_7180ce1a6ba4c1e2.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="775" height="600">
		</a>
	</figure>

	<div class="gallery__images" data-pswp-uid="1">

		<figure class="gallery__item" data-id="57" data-product_id="6" data-preview_image_url="https://i.pupiq.net/i/6f/6f/adb/2dadb/1920x1486/kpRLTo_775x600_7180ce1a6ba4c1e2.jpg" data-preview_image_width="775" data-preview_image_height="600">
			<a href="https://i.pupiq.net/i/6f/6f/adb/2dadb/1920x1486/kpRLTo_1920x1485_461ad79bef8dfa3c.jpg" title="" data-size="1920x1485" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/adb/2dadb/1920x1486/kpRLTo_193x150_0992657ccffcc085.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="193" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="58" data-product_id="25" data-preview_image_url="https://i.pupiq.net/i/6f/6f/ade/2dade/1920x1080/SOJGz5_1066x600_3692a2190237ef4b.jpg" data-preview_image_width="1066" data-preview_image_height="600">
			<a href="https://i.pupiq.net/i/6f/6f/ade/2dade/1920x1080/SOJGz5_1920x1080_ed5bef51fc287a5b.jpg" title="" data-size="1920x1080" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/ade/2dade/1920x1080/SOJGz5_266x150_fa259df95b9c2b30.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="266" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="60" data-product_id="26" data-preview_image_url="https://i.pupiq.net/i/6f/6f/ae0/2dae0/1920x1280/x7dzCj_900x600_96fbcd60e6ce0962.jpg" data-preview_image_width="900" data-preview_image_height="600">
			<a href="https://i.pupiq.net/i/6f/6f/ae0/2dae0/1920x1280/x7dzCj_1920x1280_f9199fdd174e5451.jpg" title="" data-size="1920x1280" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/ae0/2dae0/1920x1280/x7dzCj_225x150_3f7547969d4c80b7.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="225" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="61" data-product_id="27" data-preview_image_url="https://i.pupiq.net/i/6f/6f/adf/2dadf/5616x3744/WfCRM2_900x600_cfc05aebded5d74a.jpg" data-preview_image_width="900" data-preview_image_height="600">
			<a href="https://i.pupiq.net/i/6f/6f/adf/2dadf/5616x3744/WfCRM2_2000x1333_1e2e64f9338d9ccf.jpg" title="" data-size="2000x1333" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/adf/2dadf/5616x3744/WfCRM2_225x150_4e46f4154aa20ff9.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="225" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item" data-id="20">
			<a href="https://i.pupiq.net/i/6f/6f/ad6/2dad6/3000x2250/qQ0D2A_2000x1500_c318c2adc99bb6f6.jpg" title="" data-size="2000x1500" itemprop="contentUrl">
				<img src="https://i.pupiq.net/i/6f/6f/ad6/2dad6/3000x2250/qQ0D2A_200x150_00e0127009ac300e.jpg" alt="" class="img-fluid" itemprop="thumbnail" width="200" height="150">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
</section>
[/example]

## Squarebox galleries
These beautiful galleries are always displayed in same square layout with size adjusted to actual viewport or container width.

Markup and layout depends on number of visible images and on orientation of the first image. Visible images are cropped and must have exact aspect ratios. Invisible images (5th image and beyond) have hidden thumbnails with size fitting in 32&nbsp;&times;&nbsp;32&nbsp;px - this is required for PhotoSwipe to work properly.

This gallery may be used in [Gallery iObject](/styleguides/components%3Aiobjects/).

### Squarebox gallery with 4 or more images, first image is landscape

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-landscape num-4" data-pswp-uid="2">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/b7b/29b7b/2000x1281/PdG7LS_1600x1024_f3a10a9bfec87b44.jpg" title="" data-size="1600x1024" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b7b/29b7b/2000x1281/PdG7LS_300x192_b427e3c5781091e1.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b7b/29b7b/2000x1281/PdG7LS_900x600xc_f696ff59a59d5e59.jpg" alt="" class="img-fluid" width="900" height="600">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/b7c/29b7c/2000x454/GAWzhe_1600x363_b101de2956b5e009.jpg" title="Jak to jen bude vypadat?" data-size="1600x363" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b7c/29b7c/2000x454/GAWzhe_300x68_ee326505656dd399.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b7c/29b7c/2000x454/GAWzhe_300x300xc_ea03c81ca2551316.jpg" alt="Dlouhá fotka" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title">Dlouhá fotka</div>
				<div class="gallery-item__description">Jak to jen bude vypadat?</div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/b7d/29b7d/2000x1333/spG0RP_1600x1066_76e8d78669d8439e.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b7d/29b7d/2000x1333/spG0RP_300x199_ef2e73d6353f69e1.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b7d/29b7d/2000x1333/spG0RP_300x300xc_4d0be275a83cc2fb.jpg" alt="" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/b7e/29b7e/2000x3006/Hryf1u_1600x2404_09396c6f61220b3d.jpg" title="" data-size="1600x2404" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b7e/29b7e/2000x3006/Hryf1u_199x300_87123a03f1cb2a12.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b7e/29b7e/2000x3006/Hryf1u_300x300xc_cf801a601358d81f.jpg" alt="" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
			<div class="num-remaining"><span>+17</span></div>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b74/29b74/2000x1333/lur1j2_1600x1066_7c514be466bc639d.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b74/29b74/2000x1333/lur1j2_300x199_584cb745bc8bcddc.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b74/29b74/2000x1333/lur1j2_32x21_7c6a5f3de38cad8b.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b6c/29b6c/2000x1334/Fumafz_1600x1067_3483843db13d545f.jpg" title="" data-size="1600x1067" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b6c/29b6c/2000x1334/Fumafz_300x200_bf87eda32bacfb88.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b6c/29b6c/2000x1334/Fumafz_32x21_796ccb788c877407.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b76/29b76/2000x3000/zFmWbh_1600x2400_6526c9e0744493fd.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b76/29b76/2000x3000/zFmWbh_200x300_8541dd0518ea4495.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b76/29b76/2000x3000/zFmWbh_21x32_6c8922194def3cc3.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b7f/29b7f/2000x851/uVKQRq_1600x680_213d78a4969e0d65.jpg" title="" data-size="1600x680" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b7f/29b7f/2000x851/uVKQRq_300x127_ce64053a028b52e6.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b7f/29b7f/2000x851/uVKQRq_32x13_69a978ea76b19df5.png" alt="" class="img-fluid" width="32" height="13">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b6d/29b6d/2000x1333/ALrTRB_1600x1066_506178cd69272c14.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b6d/29b6d/2000x1333/ALrTRB_300x199_2aa013361f6127af.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b6d/29b6d/2000x1333/ALrTRB_32x21_82dd5fa59e4903b8.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b75/29b75/2000x2500/6JcrlT_1600x2000_db8cbb60dd9aefe0.jpg" title="" data-size="1600x2000" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b75/29b75/2000x2500/6JcrlT_240x300_b9317ba44b3c8d24.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b75/29b75/2000x2500/6JcrlT_25x32_b3e998b3f66a1804.png" alt="" class="img-fluid" width="25" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b80/29b80/2000x1076/Pu8A3O_1600x860_c75228b74ad64cb4.jpg" title="" data-size="1600x860" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b80/29b80/2000x1076/Pu8A3O_300x161_dffc53168d03488e.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b80/29b80/2000x1076/Pu8A3O_32x17_e44c9720663cc997.png" alt="" class="img-fluid" width="32" height="17">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b81/29b81/2000x3000/USbwyc_1600x2400_0ba731f9eae6beec.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b81/29b81/2000x3000/USbwyc_200x300_0357c7a386b7036c.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b81/29b81/2000x3000/USbwyc_21x32_c244d19b3574f8ba.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b82/29b82/2000x1788/akI9UT_1600x1430_08ccc55684431d3b.jpg" title="" data-size="1600x1430" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b82/29b82/2000x1788/akI9UT_300x268_ce9a5369b0439e92.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b82/29b82/2000x1788/akI9UT_32x28_302b81752a0d68d0.png" alt="" class="img-fluid" width="32" height="28">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b83/29b83/2000x1586/rpmKVz_1600x1268_576160ad34b4fee3.jpg" title="" data-size="1600x1268" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b83/29b83/2000x1586/rpmKVz_300x237_d2307fdf94a86045.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b83/29b83/2000x1586/rpmKVz_32x25_25f7f87769f2ea46.png" alt="" class="img-fluid" width="32" height="25">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b85/29b85/2000x1333/nJqUw7_1600x1066_df24b9a7a826d5ee.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b85/29b85/2000x1333/nJqUw7_300x199_5e6f8bb08b1d4832.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b85/29b85/2000x1333/nJqUw7_32x21_4f2ba73d6c636cd7.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b86/29b86/2000x1331/vrc4J7_1600x1064_b34ec57dc5ed1e5b.jpg" title="" data-size="1600x1064" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b86/29b86/2000x1331/vrc4J7_300x199_98d58d65ec2ad1b6.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b86/29b86/2000x1331/vrc4J7_32x21_ea8e0aaeb7d10e09.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b6f/29b6f/2000x3005/ouDAOW_1600x2404_b4694ba28419f798.jpg" title="" data-size="1600x2404" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b6f/29b6f/2000x3005/ouDAOW_199x300_9e329ba6c1a29b3f.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b6f/29b6f/2000x3005/ouDAOW_21x32_41833ff32265b359.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b88/29b88/2000x1125/kOFSoc_1600x900_841a27214cd0c860.jpg" title="" data-size="1600x900" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b88/29b88/2000x1125/kOFSoc_300x168_143d56684c9cff1c.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b88/29b88/2000x1125/kOFSoc_32x18_3b65b48e09bfb784.png" alt="" class="img-fluid" width="32" height="18">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b87/29b87/2000x3000/BsKfq2_1600x2400_abf4b99f391100e5.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b87/29b87/2000x3000/BsKfq2_200x300_d496bc4db62445e4.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b87/29b87/2000x3000/BsKfq2_21x32_f0a0f88bb1c5c248.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_1600x662_54850e52e1155cf4.jpg" title="" data-size="1600x662" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_300x124_6c62faef71adedad.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_32x13_8b2395bd3ed6aa01.png" alt="" class="img-fluid" width="32" height="13">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/b6a/29b6a/2000x2000/1UdJpm_1600x1600_4b09d878381752c9.jpg" title="" data-size="1600x1600" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b6a/29b6a/2000x2000/1UdJpm_300x300_8c4e7e401844fa19.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b6a/29b6a/2000x2000/1UdJpm_32x32_9a5367ba7f33e204.png" alt="" class="img-fluid" width="32" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Galerie u&nbsp;článku</div>
		<div class="gallery__description iobject__description">Testovací galerie</div>
	</div>
</section>
[example]

### Squarebox gallery with 4 or more images, first image is portrait

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-portrait num-4" data-pswp-uid="2">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/cc7/2dcc7/2000x3000/4ji2uc_1600x2400_963f552f06bc08b5.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cc7/2dcc7/2000x3000/4ji2uc_200x300_02565490c8fda1ec.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cc7/2dcc7/2000x3000/4ji2uc_600x900xc_5c879955ee9ffb8b.jpg" alt="" class="img-fluid" width="600" height="900">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/cc8/2dcc8/2000x1333/Nh28tD_1600x1066_9edfbf903add84bd.jpg" title="Popisek ukázkového obrázku" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cc8/2dcc8/2000x1333/Nh28tD_300x199_ea0e7c1a8f5cc95a.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cc8/2dcc8/2000x1333/Nh28tD_300x300xc_98cb9355af8fb591.jpg" alt="Test obrázek" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title">Test obrázek</div>
				<div class="gallery-item__description">Popisek ukázkového obrázku</div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/cc9/2dcc9/2000x1333/3ysV7l_1600x1066_dfc59bb541952f40.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cc9/2dcc9/2000x1333/3ysV7l_300x199_bed7830d79cb7019.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cc9/2dcc9/2000x1333/3ysV7l_300x300xc_cc710c33906b51c0.jpg" alt="" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_1600x2434_34a77b071ea69808.jpg" title="" data-size="1600x2434" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_197x300_8f0091df9941702e.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_300x300xc_6666d3a327334ed3.jpg" alt="" class="img-fluid" width="300" height="300">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
			<div class="num-remaining"><span>+4</span></div>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/ccb/2dccb/2000x1331/U4LBiD_1600x1064_ed70214f125c7bf6.jpg" title="" data-size="1600x1064" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/ccb/2dccb/2000x1331/U4LBiD_300x199_8e1695b0c5727615.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/ccb/2dccb/2000x1331/U4LBiD_32x21_ecd1190149f06a99.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/ccc/2dccc/2000x3001/H9VgFd_1600x2400_788d66d656d06734.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/ccc/2dccc/2000x3001/H9VgFd_199x300_0bf01248e03ac8c2.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/ccc/2dccc/2000x3001/H9VgFd_21x32_7148109fc9906d98.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/ccd/2dccd/2000x1330/BLrAC9_1600x1064_e0a9211e56445086.jpg" title="" data-size="1600x1064" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/ccd/2dccd/2000x1330/BLrAC9_300x199_4dcb13d86be93cef.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/ccd/2dccd/2000x1330/BLrAC9_32x21_dd05774b7f288204.png" alt="" class="img-fluid" width="32" height="21">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item d-none">
			<a href="http://i.pupiq.net/i/6a/6a/cce/2dcce/2000x3000/zAyN8U_1600x2400_f8cdb7261d42ce20.jpg" title="" data-size="1600x2400" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cce/2dcce/2000x3000/zAyN8U_200x300_810fb214e8ff818f.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cce/2dcce/2000x3000/zAyN8U_21x32_b7fa53f4173513a3.png" alt="" class="img-fluid" width="21" height="32">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Testovací fotogalerie</div>
		<div class="gallery__description iobject__description">Popisek ukázkové fotogalerie</div>
	</div>
</section>
[/example]

### Squarebox gallery with 3 images, first image horizontal

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-landscape num-3" data-pswp-uid="3">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_1600x662_54850e52e1155cf4.jpg" title="" data-size="1600x662" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_300x124_6c62faef71adedad.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/b89/29b89/2000x828/JoCWQ4_900x450xc_82dc700291f0bff6.jpg" alt="" class="img-fluid" width="900" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5e7/2f5e7/2000x1333/skaRKv_1600x1066_32d3d3a7475d7ed0.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5e7/2f5e7/2000x1333/skaRKv_300x199_f891729571a1b354.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5e7/2f5e7/2000x1333/skaRKv_450x450xc_2c7f90d3db62a0b3.jpg" alt="" class="img-fluid" width="450" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5e8/2f5e8/2000x2500/JeGSbx_1600x2000_35c9767c2d3af80e.jpg" title="" data-size="1600x2000" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5e8/2f5e8/2000x2500/JeGSbx_240x300_8763bb06bc24d0e9.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5e8/2f5e8/2000x2500/JeGSbx_450x450xc_f08d72af5926c352.jpg" alt="" class="img-fluid" width="450" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">3&nbsp;images, first is horizontal</div>
	</div>
</section>
[/example]

### Squarebox gallery with 3 images, first image vertical

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-portrait num-3" data-pswp-uid="4">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5e9/2f5e9/2000x2500/5Ls3Un_1600x2000_84e3dc7bc0d7c17a.jpg" title="" data-size="1600x2000" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5e9/2f5e9/2000x2500/5Ls3Un_240x300_a970e1b0655b644a.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5e9/2f5e9/2000x2500/5Ls3Un_450x900xc_7051006252f3b13b.jpg" alt="" class="img-fluid" width="450" height="900">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_1600x1066_9aeadaca65c15bd1.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_300x199_f12161704cf51a33.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_450x450xc_46030de7445f5cd8.jpg" alt="" class="img-fluid" width="450" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5eb/2f5eb/2000x1500/tA0dRw_1600x1200_7385bdf064d25cd3.jpg" title="" data-size="1600x1200" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5eb/2f5eb/2000x1500/tA0dRw_300x225_323ed3913d9668ac.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5eb/2f5eb/2000x1500/tA0dRw_450x450xc_c2c7323d4d648947.jpg" alt="" class="img-fluid" width="450" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Three images, first one has portrait orientation</div>
	</div>
</section>
[/example]
		
### Squarebox gallery with 2 images, first image horizontal

Shown without optional gallery caption.

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-landscape num-2" data-pswp-uid="1">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/926/2e926/2000x1333/h8y3wC_1600x1066_79bedfd1538ebaa0.jpg" title="Popis obrázku" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/926/2e926/2000x1333/h8y3wC_300x199_a5a5a95abe88088e.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/926/2e926/2000x1333/h8y3wC_900x450xc_4fbf5024fc0e20b6.jpg" alt="Titulek obrázku" class="img-fluid" width="900" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title">Titulek obrázku</div>
				<div class="gallery-item__description">Popis obrázku</div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/92d/2e92d/2000x1440/3IS09p_1600x1152_bb1f706cc469b9a5.jpg" title="" data-size="1600x1152" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/92d/2e92d/2000x1440/3IS09p_300x216_990703b9421c917f.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/92d/2e92d/2000x1440/3IS09p_900x450xc_5cdfbecd85018510.jpg" alt="" class="img-fluid" width="900" height="450">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
</section>
[/example]

### Squarebox gallery with 2 images, first image vertical

[example]
<section class="photo-gallery photo-gallery--square" style="max-width:600px;">
	<div class="gallery__images orientation-portrait num-2" data-pswp-uid="2">

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_1600x2434_34a77b071ea69808.jpg" title="" data-size="1600x2434" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_197x300_8f0091df9941702e.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/cca/2dcca/2000x3043/InaFJh_450x900xc_004126fa96595151.jpg" alt="" class="img-fluid" width="450" height="900">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

		<figure class="gallery__item">
			<a href="http://i.pupiq.net/i/6a/6a/5e6/2f5e6/2000x2997/zmlC6R_1600x2397_28e614601cb10b51.jpg" title="" data-size="1600x2397" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5e6/2f5e6/2000x2997/zmlC6R_200x300_ca755d3f4bebc77d.jpg">
				<img src="http://i.pupiq.net/i/6a/6a/5e6/2f5e6/2000x2997/zmlC6R_450x900xc_0c1cc2d45ff8dc42.jpg" alt="" class="img-fluid" width="450" height="900">
			</a>
			<figcaption>
				<div class="gallery-item__title"></div>
				<div class="gallery-item__description"></div>
			</figcaption>
		</figure>

	</div>
	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">2&nbsp;photos vertical</div>
		<div class="gallery__description iobject__description">Two photos, first one is horizontal</div>
	</div>
</section>
[/example]

## Slider galleries

Slider galleries use [slider component](/styleguides/components%3Aslider/).

This gallery may be used in [Gallery iObject](/styleguides/components%3Aiobjects/).

### Basic slider gallery

[example]
<section class="section--slider">

	<div class="swiper swiper--images gallery__images swiper-initialized swiper-horizontal swiper-pointer-events"
		data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="619e438677728" id="swiper_619e438677728"
		data-pswp-uid="9">
		<div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(-1700px, 0px, 0px);"
			id="swiper-wrapper-27d9f13c0a5d9883" aria-live="off">
			<div class="swiper-slide slider-item--1 swiper-slide-duplicate" style="width: 850px;" data-swiper-slide-index="3"
				role="group" aria-label="4 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36b/3136b/2000x1504/8DwSTd_2000x1504_16b0485bc8c6642e.jpg" title=""
						data-size="2000x1504" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36b/3136b/2000x1504/8DwSTd_531x400_10f8fbed817133a0.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="531" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-prev" style="width: 850px;" data-swiper-slide-index="0"
				role="group" aria-label="1 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/cbe/2dcbe/2000x1333/9qQh7u_2000x1333_754c2c2a539299af.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/cbe/2dcbe/2000x1333/9qQh7u_600x400_121e0cac7a10c34b.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="600" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-active" style="width: 850px;" data-swiper-slide-index="1"
				role="group" aria-label="2 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/369/31369/2000x1379/BAWnqs_2000x1379_6a1ed62a019609b9.jpg" title=""
						data-size="2000x1379" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/369/31369/2000x1379/BAWnqs_580x400_5f0d4933414344b2.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="580" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-next" style="width: 850px;" data-swiper-slide-index="2"
				role="group" aria-label="3 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36a/3136a/2000x1335/WcVUCE_2000x1335_b4b4269ee8f6b0c2.jpg" title=""
						data-size="2000x1335" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36a/3136a/2000x1335/WcVUCE_599x400_880e8fd45aa1ad41.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="599" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" data-swiper-slide-index="3" role="group"
				aria-label="4 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36b/3136b/2000x1504/8DwSTd_2000x1504_16b0485bc8c6642e.jpg" title=""
						data-size="2000x1504" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36b/3136b/2000x1504/8DwSTd_531x400_10f8fbed817133a0.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="531" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-duplicate swiper-slide-duplicate-prev" style="width: 850px;"
				data-swiper-slide-index="0" role="group" aria-label="1 / 4">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/cbe/2dcbe/2000x1333/9qQh7u_2000x1333_754c2c2a539299af.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/cbe/2dcbe/2000x1333/9qQh7u_600x400_121e0cac7a10c34b.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="600" height="400">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>
		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_619e438677728" tabindex="0" role="button"
			aria-label="Previous slide" aria-controls="swiper-wrapper-27d9f13c0a5d9883"><span class="sr-only">Předchozí</span>
		</div>
		<div class="swiper-button-next" id="swiper_button_next_619e438677728" tabindex="0" role="button"
			aria-label="Next slide" aria-controls="swiper-wrapper-27d9f13c0a5d9883"><span class="sr-only">Následující</span>
		</div>
		<div
			class="container-fluid--fullwidth swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"
			id="swiper_pagination_619e438677728"><span class="swiper-pagination-bullet" tabindex="0" role="button"
				aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"
				tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0"
				role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0"
				role="button" aria-label="Go to slide 4"></span></div>
		<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
	</div>

	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Galerie</div>
		<div class="gallery__description iobject__description">Popis galerie</div>
	</div>
</section>
[/example]

### Dark larger slider gallery

[example]
<section class="section--slider">

	<div
		class="swiper swiper--images gallery__images swiper--images--dark swiper-initialized swiper-horizontal swiper-pointer-events"
		data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="619e438687afe" id="swiper_619e438687afe"
		data-pswp-uid="10">
		<div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(-2550px, 0px, 0px);"
			id="swiper-wrapper-ce91072444b6918ed" aria-live="off">
			<div class="swiper-slide slider-item--1 swiper-slide-duplicate" style="width: 850px;" data-swiper-slide-index="4"
				role="group" aria-label="5 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36f/3136f/2000x1222/OmAsnW_2000x1222_9ba54b968b965b17.jpg" title=""
						data-size="2000x1222" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36f/3136f/2000x1222/OmAsnW_981x600_98e7014436f4ec98.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="981" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" data-swiper-slide-index="0" role="group"
				aria-label="1 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36c/3136c/2000x1333/nb0ANM_2000x1333_ac928c3de9539b07.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36c/3136c/2000x1333/nb0ANM_900x600_8e329860eb0c3864.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="900" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-prev" style="width: 850px;" data-swiper-slide-index="1"
				role="group" aria-label="2 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36d/3136d/2000x1076/741nMw_2000x1076_e44dbb0d4096cd50.jpg" title=""
						data-size="2000x1076" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36d/3136d/2000x1076/741nMw_1115x600_fcaaeb5313389941.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="1115" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-active" style="width: 850px;" data-swiper-slide-index="2"
				role="group" aria-label="3 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36e/3136e/2000x1333/DVsi9E_2000x1333_1691aa6ef7e7f433.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36e/3136e/2000x1333/DVsi9E_900x600_1fe70ef4d26cb8cd.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="900" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-next" style="width: 850px;" data-swiper-slide-index="3"
				role="group" aria-label="4 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36e/3136e/2000x1333/DVsi9E_2000x1333_1691aa6ef7e7f433.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36e/3136e/2000x1333/DVsi9E_900x600_1fe70ef4d26cb8cd.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="900" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" data-swiper-slide-index="4" role="group"
				aria-label="5 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36f/3136f/2000x1222/OmAsnW_2000x1222_9ba54b968b965b17.jpg" title=""
						data-size="2000x1222" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36f/3136f/2000x1222/OmAsnW_981x600_98e7014436f4ec98.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="981" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-duplicate" style="width: 850px;" data-swiper-slide-index="0"
				role="group" aria-label="1 / 5">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/36c/3136c/2000x1333/nb0ANM_2000x1333_ac928c3de9539b07.jpg" title=""
						data-size="2000x1333" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/36c/3136c/2000x1333/nb0ANM_900x600_8e329860eb0c3864.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="900" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>
		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_619e438687afe" tabindex="0" role="button"
			aria-label="Previous slide" aria-controls="swiper-wrapper-ce91072444b6918ed"><span
				class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_619e438687afe" tabindex="0" role="button"
			aria-label="Next slide" aria-controls="swiper-wrapper-ce91072444b6918ed"><span class="sr-only">Následující</span>
		</div>
		<div
			class="container-fluid--fullwidth swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"
			id="swiper_pagination_619e438687afe"><span class="swiper-pagination-bullet" tabindex="0" role="button"
				aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button"
				aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"
				tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0"
				role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0"
				role="button" aria-label="Go to slide 5"></span></div>
		<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
	</div>

	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Galerie</div>
		<div class="gallery__description iobject__description">Popis galerie</div>
	</div>
</section>
[/example]

### Slider gallery with thumbnails

[example]
<section class="section--slider section--slider--thumbnails">

	<div class="swiper swiper--thumbnails swiper-initialized swiper-horizontal swiper-pointer-events swiper-thumbs"
		data-slides_per_view="auto" data-loop="" data-autoplay="false" data-slider_id="t_619e438666e23"
		id="swiper_t_619e438666e23" data-spacebetween="5">
		<div class="swiper-wrapper" id="swiper-wrapper-a676a9dbde6a10e20" aria-live="polite"
			style="transform: translate3d(0px, 0px, 0px);">

			<div class="swiper-slide slider-item-0 swiper-slide-visible swiper-slide-active swiper-slide-thumb-active"
				style="width: auto; margin-right: 5px;" role="group" aria-label="1 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/263/30263/2000x1500/liuQp3_90x90xc_142be6622c0ccce1.jpg" alt="Test title"
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-1 swiper-slide-visible swiper-slide-next"
				style="width: auto; margin-right: 5px;" role="group" aria-label="2 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/231/30231/2000x1499/cteyQv_90x90xc_2a418b7f53440785.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-2 swiper-slide-visible" style="width: auto; margin-right: 5px;" role="group"
				aria-label="3 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/239/30239/2000x1500/Pq5EWl_90x90xc_4529ab599ea6b1d2.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-3 swiper-slide-visible" style="width: auto; margin-right: 5px;" role="group"
				aria-label="4 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/234/30234/2000x1500/ra8N0E_90x90xc_27f5b6684cd78711.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-4 swiper-slide-visible" style="width: auto; margin-right: 5px;" role="group"
				aria-label="5 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/244/30244/2000x1499/f7erPH_90x90xc_a5c983130bd5ee88.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-5 swiper-slide-visible" style="width: auto; margin-right: 5px;" role="group"
				aria-label="6 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/255/30255/2000x1500/j64iHy_90x90xc_67a134b07bbea1cd.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

			<div class="swiper-slide slider-item-6 swiper-slide-visible" style="width: auto; margin-right: 5px;" role="group"
				aria-label="7 / 7">
				<img src="http://i.pupiq.net/i/6f/6f/254/30254/2000x1500/TO4kNR_90x90xc_abf2ae85ac29c517.jpg" alt=""
					class="img-fluid" width="90" height="90">
			</div>

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev swiper-button-disabled swiper-button-lock" id="swiper_button_prev_t_619e438666e23"
			tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-a676a9dbde6a10e20"
			aria-disabled="true"><span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next swiper-button-disabled swiper-button-lock" id="swiper_button_next_t_619e438666e23"
			tabindex="-1" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-a676a9dbde6a10e20"
			aria-disabled="true"><span class="sr-only">Následující</span></div>
		<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
	</div>

	<div class="swiper swiper--images gallery__images swiper--images--dark swiper-initialized swiper-horizontal swiper-pointer-events"
		data-slides_per_view="1" data-loop="" data-autoplay="false" data-slider_id="619e438666e23" id="swiper_619e438666e23"
		data-thumbs="#swiper_t_619e438666e23" data-pswp-uid="8">
		<div class="swiper-wrapper" id="swiper-wrapper-1df10442396a610d4b" aria-live="polite"	style="transform: translate3d(0px, 0px, 0px);">

			<div class="swiper-slide slider-item--1 swiper-slide-active" style="width: 850px;" role="group"
				aria-label="1 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/263/30263/2000x1500/liuQp3_2000x1500_cedacb90b8a90a6f.jpg"
						title="Test title" data-size="2000x1500" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/263/30263/2000x1500/liuQp3_800x600_2a89079145d0420c.jpg"
							alt="Test title" class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption>
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1 swiper-slide-next" style="width: 850px;" role="group" aria-label="2 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/231/30231/2000x1499/cteyQv_2000x1499_63aa6a1f0bbc4330.jpg" title=""
						data-size="2000x1499" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/231/30231/2000x1499/cteyQv_800x600_1b94b0a8f9ddf545.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" role="group" aria-label="3 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/239/30239/2000x1500/Pq5EWl_2000x1500_d74e64df83a544c6.jpg" title=""
						data-size="2000x1500" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/239/30239/2000x1500/Pq5EWl_800x600_10dae982b0f89728.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" role="group" aria-label="4 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/234/30234/2000x1500/ra8N0E_2000x1500_8e506e296b63b97f.jpg" title=""
						data-size="2000x1500" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/234/30234/2000x1500/ra8N0E_800x600_8cbf0b22babb9afe.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" role="group" aria-label="5 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/244/30244/2000x1499/f7erPH_2000x1499_1ec1b0ba79e3c727.jpg" title=""
						data-size="2000x1499" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/244/30244/2000x1499/f7erPH_800x600_115a91ea3c7d0346.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

			<div class="swiper-slide slider-item--1" style="width: 850px;" role="group" aria-label="6 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/255/30255/2000x1500/j64iHy_2000x1500_de84ab24c121eff2.jpg" title=""
						data-size="2000x1500" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/255/30255/2000x1500/j64iHy_800x600_11a4124aa4413211.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>
			
			<div class="swiper-slide slider-item--1" style="width: 850px;" role="group" aria-label="7 / 7">
				<figure class="gallery__item" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
					<a href="http://i.pupiq.net/i/6f/6f/254/30254/2000x1500/TO4kNR_2000x1500_62e6500052a7b041.jpg" title=""
						data-size="2000x1500" itemprop="contentUrl">
						<img src="http://i.pupiq.net/i/6f/6f/254/30254/2000x1500/TO4kNR_800x600_789db1504feeef60.jpg" alt=""
							class="img-fluid" itemprop="thumbnail" width="800" height="600">
					</a>
					<figcaption class="d-none">
						<div class="gallery-item__title"></div>
						<div class="gallery-item__description"></div>
					</figcaption>
				</figure>
			</div>

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev swiper-button-disabled" id="swiper_button_prev_619e438666e23" tabindex="-1"
			role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-1df10442396a610d4b" aria-disabled="true">
			<span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_619e438666e23" tabindex="0" role="button"
			aria-label="Next slide" aria-controls="swiper-wrapper-1df10442396a610d4b" aria-disabled="false"><span
				class="sr-only">Následující</span></div>
		<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
	</div>



	<div class="gallery__caption iobject__caption">
		<div class="gallery__title iobject__title">Test: Slider Gallery</div>
	</div>
</section>
[/example]
		
## Note for developers about PhotoSwipe

Basic markup necessary to build zoomable Photoswipe gallery or single image:

[example]
<!-- Container for gallery instance .gallery__images or .iobject--picture -->
<div class="gallery__images">
	<!-- figure element wraps every single image -->
	<figure>
		<!-- link to large image with some special attributes -->
		<a href="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_1600x1066_9aeadaca65c15bd1.jpg" title="" data-size="1600x1066" itemprop="contentUrl" data-minithumb="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_300x199_f12161704cf51a33.jpg">
			<!-- Thumbnail image -->
			<img src="http://i.pupiq.net/i/6a/6a/5ea/2f5ea/2000x1333/PgHtWe_450x450xc_46030de7445f5cd8.jpg" alt="" class="img-fluid" width="450" height="450">
			<!-- optional Figcaption with text used by Photoswipe as image caption -->
			<figcaption>
				<div><strong>Image title</strong></div>
				<div>Image description</div>
			</figcaption>
		</a>
	</figure>
	<!-- Photoswipe happily ignores any other content than FIGURE tags in .gallery__images -->
	<p>Any other content inside gallery__images is allowed</p>
</div>
[/example]
		
Gallery or image is wraped in element with<code>.gallery__images</code> or <code>.iobject--picture</code> class. If other class is used, <code>initPhotoSwipeFromDOM</code> parameters in application.js must be adjusted. Multiple gallery instances are allowed.
		
Each image is wraped in <code>figure</code> element (<code>figure</code> may be nested within another elements) which includes link, thumbnail image and optional figcaption. Link tag contains some additional attributes:

- <code>data-size</code> (required): [width]x[height] size of large image, for example <code>data-size="1800x1235"</code>
- <code>data-minithumb</code> (optional): URL of very small (such as 32&nbsp;px) thumbnail used for zooming animation. It has the same aspect ratio as large image. Recommended in cases when normal thumbnail has different aspect ratio than large image.