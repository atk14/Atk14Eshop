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