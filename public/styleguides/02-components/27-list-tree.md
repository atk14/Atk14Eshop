List Tree and Tree Menu Nav
===========================

## List Tree

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
				<span class="js-collapse-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#tree_5f43c9bfe2323" aria-expanded="false"><span class="js-icon--collapsed"><span class="fas fa-plus"></span></span><span class="js-icon--expanded"><span class="fas fa-minus"></span></span></span>
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
						<span class="js-collapse-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#tree_5f43c9bfe9431" aria-expanded="false"><span class="js-icon--collapsed"><span class="fas fa-plus"></span></span><span class="js-icon--expanded"><span class="fas fa-minus"></span></span></span>
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

## Collapsible Tree Vertical Menu Nav

Collapsible menu suitable for use in sidebars on frontend with large category structures. Use <code>.active</code> on <code>a</code> class to hlighlight active link. Expand and collapse is controlled by <code>expander</code> element using Bootstrap Collapse element. Branch with current page should be expanded and active.  
On small viewports it is displayed in compact expandable form.

[example]
<nav class="nav-section">
	<button class="sidebar-toggle js-sidebar-toggle"><span class="sidebar-toggle__text-hidden">Zobrazit
			kategorie</span><span class="sidebar-toggle__text-shown">Skrýt kategorie</span><span
			class="sidebar-toggle__icon"><span class="fas fa-chevron-down"></span></span></button>
	<ul class="nav nav--sidebar nav--sidebar--borders-sm" id="sidebar_menu" style="position: relative;">

		<li class="nav-item nav-item--has-submenu">
			<a href="#" class="nav-link">Květiny</a>
			<span class="expander  collapsed" role="button" id="sidebar_menu_item_35" data-bs-toggle="collapse"
				data-target="#sidebar_submenu_35" aria-expanded="false" aria-controls="sidebar_submenu_35"
				aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
			<ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_35" aria-labelledby="sidebar_menu_item_35">
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_36">Voňavé</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_37">Pichlavé</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_38">Domácí</a>
				</li>
				<li class="nav-item nav-item--has-submenu">
					<a href="#" class="nav-link collapsed">Divoké</a>
					<span class="expander  collapsed" role="button" id="sidebar_menu_item_39" data-bs-toggle="collapse"
						data-target="#sidebar_submenu_39" aria-expanded="false" aria-controls="sidebar_submenu_39"
						aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
					<ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_39" aria-labelledby="sidebar_menu_item_39">
						<li class="nav-item">
							<a href="#" class="nav-link" id="sidebar_menu_item_70">Domácí</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link" id="sidebar_menu_item_71">Exotické</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>

		<li class="nav-item">
			<a href="#" class="nav-link" id="sidebar_menu_item_40">Retro</a>
		</li>

		<li class="nav-item">
			<a href="#" class="nav-link" id="sidebar_menu_item_41">Krabice, krabičky</a>
		</li>

		<li class="nav-item">
			<a href="#" class="nav-link" id="sidebar_menu_item_54">Zážitky</a>
		</li>

		<li class="nav-item">
			<a href="#" class="nav-link" id="sidebar_menu_item_68">Knihy</a>
		</li>

		<li class="nav-item nav-item--has-submenu">
			<a href="#" class="nav-link active">Hudba</a>
			<span class="expander  " role="button" id="sidebar_menu_item_69" data-bs-toggle="collapse"
				data-target="#sidebar_submenu_69" aria-expanded="true" aria-controls="sidebar_submenu_69"
				aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
			<ul class="nav nav--sidebar__submenu collapse show" id="sidebar_submenu_69"
				aria-labelledby="sidebar_menu_item_69">
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_72">Techno</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_73">Electro</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_81">Ambient</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_82">EBM</a>
				</li>
			</ul>
		</li>

		<li class="nav-item nav-item--has-submenu">
			<a href="#" class="nav-link">Syntezátory</a>
			<span class="expander  collapsed" role="button" id="sidebar_menu_item_74" data-bs-toggle="collapse"
				data-target="#sidebar_submenu_74" aria-expanded="false" aria-controls="sidebar_submenu_74"
				aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
			<ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_74" aria-labelledby="sidebar_menu_item_74">
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_85">Analogové</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_86">Modulární</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link" id="sidebar_menu_item_88">Digitální</a>
				</li>
			</ul>
		</li>

	</ul>
</nav>
[/example]