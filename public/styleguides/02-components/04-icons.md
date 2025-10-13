Icons
=====

All 2025 free icons from FontAwesome are available. See [FontAwesome docs](https://fontawesome.com/) for more info on usage. Note for developers: there is also Smarty tag for this like <code>{!"cat"|icon}</code>.
There are some useful styling classes available - see [FontAwesome styling docs](https://fontawesome.com/docs/web/style/styling).

[example]
<p style="font-size: 2rem">
	<i class="fas fa-cat"></i>
	<i class="fas fa-dog"></i>
	<i class="fas fa-otter"></i>
	<i class="fas fa-kiwi-bird"></i>
	<i class="fas fa-frog"></i>
	<i class="fas fa-crow"></i>
	<i class="fab fa-facebook-f"></i>
	<i class="fab fa-apple-pay"></i>
	<i class="fas fa-arrow-right"></i>
	<i class="fas fa-arrow-left"></i>
	<i class="fas fa-arrow-up"></i>
	<i class="fas fa-arrow-down"></i>
	<i class="fas fa-bone"></i>
	<i class="fas fa-cart-plus"></i>
	<i class="fas fa-blender"></i>
	<i class="fas fa-carrot"></i>
</p>
[/example]

File icons
----------

Flexible utility for creating file icons. 

### Very basic file icon

[example]
<span class="fileicon"></span>
[/example]

### File icon with image

Add modifier class with file type extension like <code>fileicon-zip</code>. Many common file types have special icon, if not, default icon is displayed. Only few of many available file types are displayed here. For best results, use larger font sizes.

[example]
<p style="font-size: 2rem;">
	<span class="fileicon fileicon-folder"></span>
	<span class="fileicon fileicon-epub"></span>
	<span class="fileicon fileicon-pdf"></span>
	<span class="fileicon fileicon-docx"></span>
	<span class="fileicon fileicon-xlsx"></span>
	<span class="fileicon fileicon-pptx"></span>
	<span class="fileicon fileicon-zip"></span>
	<span class="fileicon fileicon-mp3"></span>
	<span class="fileicon fileicon-mpg"></span>
	<span class="fileicon fileicon-abc"></span>
</p>
[/example]

### File icon with color

Add <code>fileicon-color</code> class and many common file type icons will be colored with its typical color. If color for given file type is not found, default dark gray color is used.

[example]
<p style="font-size: 2rem;">
	<span class="fileicon fileicon-epub fileicon-folder"></span>
	<span class="fileicon fileicon-epub fileicon-color"></span>
	<span class="fileicon fileicon-pdf fileicon-color"></span>
	<span class="fileicon fileicon-docx fileicon-color"></span>
	<span class="fileicon fileicon-xlsx fileicon-color"></span>
	<span class="fileicon fileicon-pptx fileicon-color"></span>
	<span class="fileicon fileicon-zip fileicon-color"></span>
	<span class="fileicon fileicon-mp3 fileicon-color"></span>
	<span class="fileicon fileicon-mpg fileicon-color"></span>
	<span class="fileicon fileicon-abc fileicon-color"></span>
</p>
[/example]

### File icons with text

If you want to have text instead of image on icon, just add <code>data-icon-text</code> attribute with desired text. Text should have no more than 3 or 4 characters. For best results font size should be even larger.

[example]
<p style="font-size: 3rem;">
	<span class="fileicon fileicon-epub fileicon-color" data-icon-text="epub"></span>
	<span class="fileicon fileicon-pdf fileicon-color" data-icon-text="pdf"></span>
	<span class="fileicon fileicon-mpg fileicon-color" data-icon-text="mpg"></span>
	<span class="fileicon fileicon-pptx fileicon-color" data-icon-text="ppt"></span>
	<span class="fileicon fileicon-abc fileicon-color" data-icon-text="abc"></span>
	<span class="fileicon fileicon-prc fileicon-color" data-icon-text="prc"></span>
</p>
[/example]
