Dropdowns
=========

Dropdowns are basically standard Bootstrap dropdowns extended with our own color theming system. It enables to easily alter dropdown background, highlight colors and it is also capable to make dropdowns semi-transparent with backdrop blur (on supported browsers). All of this styling is done simply by adding some modifier classes to <code>.dropdown-menu</code> element.

By default (without adding modifier classes), dropdowns have white background and primary color is used to highlight items. And of course you may use all of the standard features and classes of mighty Bootstrap dropdowns as described in Bootstrap docs.

## Default dropdown

Default styling without any of modifier classes

[example]
<div class="dropdown-menu" style="position:static; display:block;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="clearfix"></div>
[/example]

## Altering background color

You may use any of <code>.bg-*</code> background utility classes, like <code>.bg-light</code>, <code>.bg-brand</code>, <code>.bg-success</code> etc. Another useful modifier class is <code>.dropdown-menu--dark</code> which makes text and divider colors light. It should be used every time when intended background color is dark.

[example]
<div class="dropdown-menu bg-light" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="dropdown-menu dropdown-menu--dark" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="dropdown-menu dropdown-menu--dark bg-brand" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="dropdown-menu bg-warning" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="clearfix"></div>
[/example]

## Altering highlight color

Highlight color is easily customised by adding <code>.dropdown-highlight-* </code> classes. <code> * </code> stands for any of the theme colors. Text color is adjusted automatically for good contrast.


[example]
<div class="dropdown-menu dropdown-highlight-brand" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="dropdown-menu dropdown-menu--dark bg-primary dropdown-highlight-light" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
  <a class="dropdown-item" href="#">Regular link</a>
  <a class="dropdown-item active" href="#">Active link</a>
  <a class="dropdown-item" href="#">Another link</a>
	<div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Another link</a>
</div>

<div class="clearfix"></div>
[/example]


## Semi-transparent dropdowns

Transparency effect is achieved by adding <code>.dropdown-menu--transparent</code> modifier class. Effect is very subtle to not affect readibility of text. IMPORTANT: This class MUST be used together with <code>.bg-*</code> background utility class, otherwise it would not work. In supported browsers dropdown backdrop is blurred with slightly bigger amount of transparency.

[example]
<div style="padding: 1rem; background-image: linear-gradient(45deg, #808080 25%, transparent 25%), linear-gradient(-45deg, #808080 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #808080 75%), linear-gradient(-45deg, transparent 75%, #808080 75%); background-size: 40px 40px; background-position: 0 0, 0 20px, 20px -20px, -20px 0px;">

	<div class="dropdown-menu bg-light dropdown-menu--transparent" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
		<a class="dropdown-item" href="#">Regular link</a>
		<a class="dropdown-item active" href="#">Active link</a>
		<a class="dropdown-item" href="#">Another link</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">Another link</a>
	</div>

	<div class="dropdown-menu dropdown-menu--dark bg-brand dropdown-menu--transparent" style="position:static; display:block; margin-right: 0.5rem; margin-bottom: 0.5rem;">
		<a class="dropdown-item" href="#">Regular link</a>
		<a class="dropdown-item active" href="#">Active link</a>
		<a class="dropdown-item" href="#">Another link</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">Another link</a>
	</div>

	<div class="clearfix"></div>

</div>
[/example]
