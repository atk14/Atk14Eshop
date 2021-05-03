Advanced Grid Layout system
===========================

To create pages with more ambitious full width layouts one may opt-in for Advanced Grid Layout system.

## Turning on Advanced Grid Layout

Before using Advanced Grid Layout it must be turned on first.

### How to turn on Advanced Grid Layout when creating Pages content

When creating Pages content: in adminm, fill in "fullwidth" in Code field.

### How tu turn on Advanced Grid Layout programmatically in template code

Switch layout from <code>default</code> to <code>containerless</code> by entering this tag at the beginnning of template code:
<code>{use layout="containerless"}
</code>

### How tu turn on Advanced Grid Layout in HTML and CSS

You need full width div with class <code>.body--fullwidth</code> and nested div with <code>.content-main</code> class. 
(TODO simplify this)

## Basic markup for Advanced Grid Layout

[example]
<div class="body--fullwidth">
	<div class="content-main">
		<section class="section--fullwidth" style="background-color: lightblue">
			<div class="container-fluid">
				<h5>Full width section</h5>
				<p>I'm baby pickled helvetica ramps vaporware gentrify twee shabby chic small batch pinterest vegan tousled. 90's copper mug crucifix asymmetrical. Snackwave typewriter tumeric YOLO man braid.</p>
			</div>
		</section>
		
		<section class="section--narrow">
			<div class="container-fluid">
				<h5>Narrow section</h5>
				<p>Tilde franzen slow-carb YOLO venmo. Fingerstache bitters godard semiotics, chillwave vegan glossier four loko unicorn banh mi. Chicharrones food truck forage sustainable, tote bag glossier keffiyeh brooklyn asymmetrical schlitz letterpress.</p>
			</div>
		</section>
		
		<div class="container-fluid">
			<h5>Container fluid</h5>
			<p>Twee gastropub green juice, sriracha iceland truffaut blog ethical literally glossier asymmetrical roof party biodiesel salvia tousled. Cliche stumptown cronut tilde meggings cloud bread crucifix.</p>
		</div>
		
		<p>Tilde franzen slow-carb YOLO venmo. Fingerstache bitters godard semiotics, chillwave vegan glossier four loko unicorn banh mi. Chicharrones food truck forage sustainable, tote bag glossier keffiyeh brooklyn asymmetrical schlitz letterpress. Cloud bread lyft gentrify scenester hammock actually austin forage mustache williamsburg butcher jean shorts VHS polaroid wayfarers. Direct trade actually thundercats pabst, biodiesel bushwick hammock tumeric yuccie lomo.</p>
		
	</div>
	
</div>
[example]