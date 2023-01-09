Buttons
=======

Buttons are based on standard Bootstrap buttons. Use <code>a</code>, <code>button</code> or other suitable HTML tag to create button. For more options see Bootstrap buttons docs.

[example]
	<button type="button" class="btn btn-primary">Primary</button>
	<button type="button" class="btn btn-secondary">Secondary</button>
	<button type="button" class="btn btn-success">Success</button>
	<button type="button" class="btn btn-danger">Danger</button>
	<button type="button" class="btn btn-warning">Warning</button>
	<button type="button" class="btn btn-info">Info</button>
	<button type="button" class="btn btn-light">Light</button>
	<button type="button" class="btn btn-dark">Dark</button>
	<button type="button" class="btn btn-link">Link</button>
[/example]

## Outline buttons 

[example]
<button type="button" class="btn btn-outline-primary">Primary</button>
<button type="button" class="btn btn-outline-secondary">Secondary</button>
<button type="button" class="btn btn-outline-success">Success</button>
<button type="button" class="btn btn-outline-danger">Danger</button>
<button type="button" class="btn btn-outline-warning">Warning</button>
<button type="button" class="btn btn-outline-info">Info</button>
<button type="button" class="btn btn-outline-light">Light</button>
<button type="button" class="btn btn-outline-dark">Dark</button>
[/example]

## Button sizing
[example]
<button type="button" class="btn btn-primary btn-xs">X-Small</button>
<button type="button" class="btn btn-primary btn-sm">Small</button>
<button type="button" class="btn btn-primary">Normal</button>
<button type="button" class="btn btn-primary btn-lg">Large</button>
[/example]

## Buttons with multiple lines of text

Class <code>.btn--multiline</code> enhances button appearance in case of multiple lines of text. For best results it is highly recommended to wrap each line of text in its own HTML element such as <code>span</code>. Works both for standard and outline buttons in normal, -sm and -lg sizes. With sigle line of text buttons appear the same as ordinary buttons and have the same outer dimensions.

[example]
<button type="button" class="btn btn--multiline btn-primary"><span>Normal</span><small>Some additional text</small></button>
<button type="button" class="btn btn--multiline btn-primary"><span>Normal</span></button>
<hr>
<button type="button" class="btn btn--multiline btn-lg btn-info"><span>Large</span><small>Some additional text</small></button>
<button type="button" class="btn btn--multiline btn-lg btn-info"><span>Large</span></button>
<hr>
<button type="button" class="btn btn--multiline btn-sm btn-outline-danger"><span>Small</span><small>Some additional text</small></button>
<button type="button" class="btn btn--multiline btn-sm btn-outline-danger"><span>Small</span></button>
[/example]
