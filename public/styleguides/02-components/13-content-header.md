Content header
==============

Universal component to create header for any page. It may contain main title (usually H1), teaser, tags, product author name, article meta info, header image etc. To make it consistent and easy to maintain throughout entire site frontend, it should be generated with powerful <code>shared/layout/content_header</code> template which is able to generate all variants of content header. It may be also used for lower level headings as template is able to display main heading with tag other than <code>H1</code>.
		
## Very minimal example of content header
[example]
<header class="content-header">
	<div class="content-header__text">
		<h1 class="h1">Registrace nového uživatele</h1>
	</div>
</header>
[/example]
		

## Another example with image

[example]	
<header class="content-header">
	<div class="content-header__image" style="background-color: #333333">
		<img src="http://i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_800x533_3af660bc2008ce93.jpg" class="img-fluid" style="background-color: #C4D8E8">
	</div>
	<div class="content-header__text">
		<h1 class="h1">Elegantní lékárna</h1>
		<div class="teaser">
			<p>Praha</p>
		</div>
	</div>
</header>
[/example]


## Fully featured Content header
Fully featured Content header with tags and image as used for articles and with colored background. Background colors should be taken from image. Note that <code>content-header__text--dark</code> class also causes slightly different layout of text.

[example]
<header class="content-header">
	<div class="content-header__image" style="background-color: #333333">
		<img src="http://i.pupiq.net/i/6f/6f/ab2/2dab2/2000x1342/FCAMgI_800x536_8150bf6e93946a88.jpg" class="img-fluid" style="background-color: #EBEAEE">
	</div>
	<div class="content-header__text content-header__text--dark" style="background-color: #2A282A">
		<div class="tags"> <a href="#">
				<span class="badge tag-item tag--news tag--bg-gray-dark"><span class="fas fa-tag"></span> aktuality</span>
			</a>
		</div>
		<news class="h1">Vítejte na ATK14&nbsp;Skelet</news>
		<div class="teaser">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			<p class="meta">Zaslal <em>Charlie Root</em> dne <time datetime="2013-04-12 00:00:00">12.&nbsp;4.&nbsp;2013</time> </p>
		</div>
	</div>
</header>
[/example]


## Content header with product author link

Content header on product page with author name/link, tags and teaser.

[example]
<header class="content-header">
	<div class="content-header__text">
		<div class="tags"> <span class="badge tag-item tag--digital-product tag--bg-gray-dark"><span class="fas fa-tag"></span> digitální produkt</span>
		</div>
		<h1 class="h1">Violator (download)</h1>
		<div class="author"> <a href="#">Depeche Mode</a> </div>
		<div class="teaser">
			<p>Nadčasové příběhy malého štěněte z&nbsp;pera nesmrtelného Karla Čapka.</p>
		</div>
	</div>
</header>
[/example]

###Usage with tag other than H1
It looks the same when used with heading tag other than <code>H1</code>.

[example]
<header class="content-header">
	<div class="content-header__text">
		<h2 class="h1">Vítejte v&nbsp;ATK14&nbsp;E‑shopu</h2>
		<div class="teaser">
			<p><em>ATK14&nbsp;E‑shop</em> je aplikační kostra vhodná pro e‑shopy, která je postavena na <em>ATK14&nbsp;Katalogu</em>.</p>
		</div>
	</div>
</header>
[/example]