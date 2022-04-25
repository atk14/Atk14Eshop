FAQ / Definition lists
======================

FAQ with expandable answers. It is designed to require only minimal markup without any special attributes or excessive number of classes etc., so it is quite easy to write by hand.

It may be used as <code>dl > dt + dd</code> HTML definition list, or as <code>ul</code> or <code>ol</code> lists.

In browsers without Javascript, all answers are visible.

## Usage as DL definition list tag
This variant has simplest possible markup - just add <code>.faq</code> class to <code>dl</code> element. Note that <code>dd</code> tag must follow immidiately after <code>dt</code> tag.

[example]
<dl class="faq">

	<dt>
		Question Title	
	</dt>
	<dd>
		I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer.
	</dd>
	
	<dt>
		Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse.
	</dt>
	<dd>
		I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer. Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse. Hot chicken tacos pinterest, dreamcatcher 90's semiotics marfa. Beard jean shorts single-origin coffee, occupy kombucha poutine poke twee asymmetrical kinfolk squid paleo ramps raclette. Fixie godard selvage, listicle lo-fi yr fashion axe tote bag drinking vinegar irony snackwave distillery tacos waistcoat.
	</dd>
	
	<dt>
		Will it blend?
	</dt>
	<dd>
		No.
	</dd>
	
</dl>
[/example]

## Usage as UL or OL list tag


[example]
<ul class="faq">

	<li>
		<div class="faq__q">
			Question Title
		</div>
		<div class="faq__a">
			I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer.
		</div>
	</li>
	
	<li>
		<div class="faq__q">
			Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse.
		</div>
		<div class="faq__a">
			I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer. Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse. Hot chicken tacos pinterest, dreamcatcher 90's semiotics marfa. Beard jean shorts single-origin coffee, occupy kombucha poutine poke twee asymmetrical kinfolk squid paleo ramps raclette. Fixie godard selvage, listicle lo-fi yr fashion axe tote bag drinking vinegar irony snackwave distillery tacos waistcoat.
		</div>
	</li>
	
	<li>
		<div class="faq__q">
			Will it blend?
		</div>
		<div class="faq__a">
			No.
		</div>
	</li>
	
</ul>


<ol class="faq">

	<li>
		<div class="faq__q">
			Question Title
		</div>
		<div class="faq__a">
			I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer.
		</div>
	</li>
	
	<li>
		<div class="faq__q">
			Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse.
		</div>
		<div class="faq__a">
			I'm baby irony roof party narwhal af kitsch, cold-pressed literally franzen etsy tilde YOLO butcher craft beer. Kickstarter gochujang lyft, ramps snackwave vape squid. Listicle pickled brooklyn master cleanse. Hot chicken tacos pinterest, dreamcatcher 90's semiotics marfa. Beard jean shorts single-origin coffee, occupy kombucha poutine poke twee asymmetrical kinfolk squid paleo ramps raclette. Fixie godard selvage, listicle lo-fi yr fashion axe tote bag drinking vinegar irony snackwave distillery tacos waistcoat.
		</div>
	</li>
	
	<li>
		<div class="faq__q">
			Will it blend?
		</div>
		<div class="faq__a">
			No.
		</div>
	</li>
	
</ol>
[/example]