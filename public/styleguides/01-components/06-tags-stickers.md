Tags, flags and sticker
=======================

###Tags
Tags use Bootsrap badge component wrapped in <code>.tags</code> container which ensures correct positioning and sizing in various contexts. Tags use standard Bootstrap badge component.

[example]
<div class="tags">
	<a href="#">
		<span class="badge tag-item tag--news tag--bg-gray-dark"><span class="fas fa-tag"></span> aktuality</span>
	</a>
	<a href="#">
		<span class="badge tag-item tag--bg-blue"><span class="fas fa-tag"></span> another tag</span>
	</a>
	<a href="#">
		<span class="badge tag-item tag--bg-orange"><span class="fas fa-tag"></span> ve více variantách</span>
	</a>
</div>
[/example]

###Flags
They are used to denote discounts etc. on cards. They are placed over card image or over product main image. <code>.card__flags</code> class ensures correct positioning. Smaller variation is available:

[example]
<div class="card__flags">
	<div class="product__flag product__flag--sale product__flag--lg">
		<span class="product__flag__title">Sleva</span> <span class="product__flag__number">50&nbsp;%</span>
	</div>
</div>
	
<div class="card__flags">
	<div class="product__flag product__flag--sale product__flag--sm">
		<span class="product__flag__title">Sleva</span> <span class="product__flag__number">50&nbsp;%</span>
	</div>
</div>
[/example]
		
###Stickers
Sticker is big round icon consisting of icons and text. Color variations may be created by replacing <code>sticker--free-shipping</code> class with different background styling.

[example]
<div class="sticker sticker--free-shipping">
	<div class="sticker__icon"><span class="fas fa-truck"></span></div>
	<h4 class="sticker__title">Doprava</h4>
	<div class="sticker__text">zdarma</div>
	<div class="sticker__icon"><span class="fas fa-check"></span></div>
</div>
		
<div class="sticker bg-info">
	<div class="sticker__icon"><i class="fas fa-dog"></i> <i class="fas fa-cat"></i></div>
	<h4 class="sticker__title">Pets</h4>
	<div class="sticker__text">welcome</div>
</div>
[/example]
