Basic lists
===========

## Plain <code>ul</code>/<code>ol</code> lists

Enhanced look of standard HTML lists. When used in page or article content, no class is needed (so they can be easily writen with Markdown). In other contexts use class <code>list--simple</code> or <code>list--ul</code>.

[example]
<h5>Unordered list with <code>list--simple</code> class</h5>
<ul class="list--simple">
	<li>List item</li>
	<li>List item</li>
	<li>List item</li>
</ul>
<div class="article__body" style="max-width:auto;">
	<h5>Unordered list without any class inside article or page content</h5>
	<ul class="list--simple">
		<li>List item</li>
		<li>List item</li>
		<li>List item</li>
	</ul>
</div>
[/example]
[example]
<h5>Ordered list with <code>list--simple</code> class</h5>
<ol class="list--simple">
	<li>List item</li>
	<li>List item</li>
	<li>List item</li>
</ol>
<div class="article__body" style="max-width:auto;">
	<h5>Ordered list without any class inside article or page content</h5>
	<ol class="list--simple">
		<li>List item</li>
		<li>List item</li>
		<li>List item</li>
	</ol>
</div>
[/example]

## Unstyled list

[example]
<ul class="list-unstyled">
	<li>List item</li>
	<li>List item</li>
	<li>List item</li>
</ul>
[/example]

## Inline list

[example]
<ul class="list-inline">
	<li class="list-inline-item">List item</li>
	<li class="list-inline-item">List item</li>
	<li class="list-inline-item">List item</li>
</ul>
[/example]

## Unstyled list with icons

[example]
<ul class="list--icons">
	<li>
		<span class="list--icons__icon"><i class="fas fa-envelope"></i></span>
		<span class="list--icons__value"><a href="#">charlie@demo.com</a></span>
	</li>
	<li>
		<span class="list--icons__icon"><i class="fas fa-mobile-alt"></i></span>
		<span class="list--icons__value"><a href="#">+420 123 456 789</a></span>
	</li>
	<li>
		<span class="list--icons__icon"><i class="fas fa-map-marker-alt"></i></span>
		<span class="list--icons__value">23 Fascination Street<br>Gotham<br>120 00</span>
	</li>
</ul>
[/example]