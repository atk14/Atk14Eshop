List Tree
=========

Lists used for displaying hieararchical tree structures.

[example]
<h3>List title</h3>
<ul class="list--tree">
	<li class="list__item">List Item</li>
	<li class="list__item">List Item</li>
	<li class="list__item">List Item
		<ul class="list--tree">
			<li class="list__item">List item</li>
			<li class="list__item">List item</li>
			<li class="list__item">List item</li>
		</ul>
	</li>
	<li class="list__item">List Item</li>
	<li class="list__item">List Item</li>
</ul>
[/example]

Example with parent list with <code>list--categories</code> or <code>list--tree-parent</code>:

[example]
<ul class="list--tree-parent">
	<li class="list__item">Parent item
		<ul class="list--tree">
			<li class="list__item">List Item</li>
			<li class="list__item">List Item
				<ul class="list--tree">
					<li class="list__item">List item</li>
					<li class="list__item">List item</li>
				</ul>
			</li>
			<li class="list__item">List Item</li>
			<li class="list__item">List Item</li>
		</ul>
	</li>
	<li class="list__item">Parent item
		<ul class="list--tree">
			<li class="list__item">List Item</li>
			<li class="list__item">List Item</li>
			<li class="list__item">List Item</li>
		</ul>
	</li>
</ul>
[/example]

### Collapsible list tree

Suitable for long nested lists, especially in admin area. All nested lists are collapsed by default. Basic functionality is provided by Bootstrap Collapse component so no special JS is needed for basic function. If Expand All/Collapse All toggle is used it must be handled in JS like this:

<code><pre>
$( ".js-toggle-all-trees" ).on( "click", function() {
	if( $( this ).hasClass( "collapsed" ) ){
		$( ".list--tree.collapse" ).collapse( "show" );
	} else {
		$( ".list--tree.collapse" ).collapse( "hide" );
	}
	$( this ).toggleClass( [ "collapsed", "expanded" ] )
} );
</pre></code>

[example]
<ul class="list--categories">
	<li>
		<h3><a href="#"><span class="fas fa-folder-open"></span> Obchod</a> <button class="btn btn-sm btn-outline-secondary js-toggle-all-trees collapsed"><span class="btn__text--collapsed">Expand all</span><span class="btn__text--expanded">Collapse all</span></button></h3>
		<ul class="list--tree list--tree-collapsible">
			<li>
				<span class="js-collapse-toggle collapsed" data-toggle="collapse" data-target="#tree_5f43c9bfe2323" aria-expanded="false"><span class="js-icon--collapsed"><span class="fas fa-plus"></span></span><span class="js-icon--expanded"><span class="fas fa-minus"></span></span></span>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Květiny</a>
				<ul class="list--tree list--tree-collapsible collapse" id="tree_5f43c9bfe2323" style="">
					<li>
						<em><span class="fas fa-folder-open"></span></em>
						<a href="#">Voňavé</a>
					</li>
					<li>
						<em><span class="fas fa-folder-open"></span></em>
						<a href="#">Pichlavé</a>
					</li>
					<li>
						<em><span class="fas fa-folder-open"></span></em>
						<a href="#">Domácí</a>
					</li>
					<li>
						<span class="js-collapse-toggle collapsed" data-toggle="collapse" data-target="#tree_5f43c9bfe9431" aria-expanded="false"><span class="js-icon--collapsed"><span class="fas fa-plus"></span></span><span class="js-icon--expanded"><span class="fas fa-minus"></span></span></span>
						<em><span class="fas fa-folder-open"></span></em>
						<a href="#">Divoké</a>
						<ul class="list--tree list--tree-collapsible collapse" id="tree_5f43c9bfe9431" style="">
							<li>
								<em><span class="fas fa-folder-open"></span></em>
								<a href="#">Domácí</a>
							</li>
							<li>
								<em><span class="fas fa-folder-open"></span></em>
								<a href="#">Exotické</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Retro</a>
			</li>
			<li>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Krabice, krabičky</a>
			</li>
			<li>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Zážitky</a>
			</li>
			<li>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Knihy</a>
			</li>
			<li>
				<em><span class="fas fa-folder-open"></span></em>
				<a href="#">Hudba</a>
			</li>
		</ul>
	</li>
</ul>
[/example]