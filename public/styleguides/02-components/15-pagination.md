Pagination
==========

### Basic pagination
Based on Bootstrap Pagination component.

[example]
<div class="pagination-container">
	<ul class="pagination">
		<li class="page-item first-child prev"><a class="page-link" href="#" rel="nofollow"><i class="fas fa-chevron-left" title="%s"></i> <span class="sr-only">Předchozí</span></a></li>
		<li class="page-item"><a class="page-link" href="#" rel="nofollow">1</a></li>
		<li class="page-item active"><a class="page-link" href="#" rel="nofollow">2</a></li>
		<li class="page-item"><a class="page-link" href="#" rel="nofollow">3</a></li>
		<li class="page-item"><a class="page-link" href="#" rel="nofollow">4</a></li>
		<li class="page-item last-child next"><a class="page-link" href="#" rel="nofollow"><span class="sr-only">Následující</span> <i class="fas fa-chevron-right"></i></a></li>
	</ul>
	<p><span class="badge badge-secondary">21</span> položek celkem</p>
</div>
[/example]

### Ajax pagination
Used on product list pages

[example]
<div class="pagination-container">
	<div class="pager-buttons js--pager-buttons">
		<div class="">
			<a href="" class="list__item js--first btn btn-default disabled" rel="nofollow"> První strana</a>
			<a href="" class="list__item js--previous btn btn-primary disabled" rel="nofollow"> Předchozí strana</a>
			<a href="#" class="list__item js--next btn btn-primary next-items" rel="nofollow">Dalších 21 produktů</a>
		</div>
		<div class="pagination-info js--remains">Zbývá 21 položek z 45</div>
	</div>
</div>

<h6 class="my-4">Ajax pagination after reaching limit for ajax loading</h6>

<div class="pagination-container">
	<div class="pager-buttons js--pager-buttons">
		<div class="">
			<a class="list__item js--first btn btn-default disabled" rel="nofollow"> První strana</a>
			<a href="#" class="list__item js--previous btn btn-primary" rel="nofollow"> Předchozí strana</a>
			<a href="#" class="list__item js--next btn btn-primary next-page" rel="nofollow">Další strana</a>
		</div>
		<div class="pagination-info js--remains">Zbývá 15 položek z 207</div>
	</div>
</div>
[/example]

### Articles prev / next pagination

Previous / next article link with thumbnail images. Background color is automatically taken from images.

[example]
<div class="pager--rich">
	<a class="pager__item" href="#" style="background-color: #45434F;">
		<div class="pager__item__text">
			<p class="pager__item__title">Článek s vloženými objekty</p>
		</div>
		<div class="pager__item__image" style="background-image: url(http://i.pupiq.net/i/6f/6f/ab4/2dab4/2000x1333/zsQ2NJ_300x300xc_a66a5601fc9b9fbd.jpg);"></div>
	</a>
	<a class="pager__item" href="#" style="background-color: #1E2B39;">
		<div class="pager__item__text">
			<p class="pager__item__title">Šťastné 21. století</p>
		</div>
		<div class="pager__item__image" style="background-image: url(http://i.pupiq.net/i/6f/6f/ab3/2dab3/2000x1333/qJ7Bjw_300x300xc_852bcc0f67992d5d.jpg);"></div>
	</a>
</div>
[/example]