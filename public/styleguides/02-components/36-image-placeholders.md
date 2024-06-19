Image placeholders / dummy images
===================

Utility for generating image placeholders or dummy images. This feature is intended for design and development purpposes and should be not used in production.

## Usage
Simply write <code>img</code> tag with <code>src</code> attribute in following format:

<code>SVGPlaceholder/width/height/backgroundColor</code>

This fake URL will be replaced with SVG image in Data URI format.

Parameters are optional. If width and/or height are not set they wold be taken from image`s <code>width</code> and <code>height</code> attributes. If image has <code>width</code> and/or <code>height</code> attributes these will be used as  <code>width</code> and/or <code>height</code> attributes of resulting SVG, otherwise SVG would have only <code>viewBox</code> attribute specified.

If background color is not set randomly generated light, low-saturated color will be used.

## Usage examples

### Image with size specified in src attribute only

[example]
<img src="SVGPlaceholder/1200/200/" alt="" class="img-fluid">
[/example]

### Image with size specified botn in src attribute and width and height attributes

[example]
<img src="SVGPlaceholder/1200/200/" alt="" class="img-fluid" width="300" height="50">
[/example]

### Image with size specified in width and height attributes only

[example]
<img src="SVGPlaceholder" alt="" class="img-fluid" width="300" height="50">
[/example]

### Image with custom background color
[example]
<img src="SVGPlaceholder/800/150/#000" alt="" class="img-fluid mb-2">
<img src="SVGPlaceholder/800/150/deeppink" alt="" class="img-fluid">
[/example]