Tables
======

Tables are based on Bootstrap tables. They have different responsive behavior - on small screens, table cells are stacked vertically. Consult Bootstrap table docs for many styling options such as compact, dark, bordered, borderless, striped, hoverable etc. tables.

###Basic table

[example]
<table class="table">
	<thead>
		<tr>
			<th>Heading</th>
			<th>Heading</th>
			<th>Heading</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>content</td>
			<td>content</td>
			<td>content</td>
		</tr>
		<tr>
			<td>content</td>
			<td>content</td>
			<td>content</td>
		</tr>
	</tbody>
</table>
[/example]

###Basic table enhanced for better behavior on small screens
On small screens table header is hidden using <code>thead-hidden-xs</code> and optional captions for small screens are added to individual cells using <code>span.table-hint-xs</code>. Try to resize browser window into narrow viewport to see the effect.

[example]
<table class="table">
	<thead class="thead--hidden-xs">
		<tr>
			<th>Heading 1</th>
			<th>Heading 2</th>
			<th>Heading 3</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<span class="table-hint-xs">Heading 1</span>
				content
			</td>
			<td>
				<span class="table-hint-xs">Heading 2</span>
				content
			</td>
			<td>
				<span class="table-hint-xs">Heading 3</span>
				content
			</td>
		</tr>
		<tr>
			<td>
				<span class="table-hint-xs">Heading 1</span>
				content
			</td>
			<td>
				<span class="table-hint-xs">Heading 2</span>
				content
			</td>
			<td>
				<span class="table-hint-xs">Heading 3</span>
				content
			</td>
		</tr>
	</tbody>
</table>
[/example]
