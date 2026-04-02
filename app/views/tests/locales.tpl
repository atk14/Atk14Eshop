<h1>{$page_title}</h1>

<table class="table">
	<thead>
	<tr>
		<th></th>
		{foreach $locales as $loc}
			<th>
				{$loc.name|ucfirst}<br>
				<small>{$loc.LANG}</small>
			</th>
		{/foreach}
	</tr>
	</thead>
	<tbody>
		{foreach $rows as $k => $values}
			<tr>
				<td>{$k}</td>
				{foreach $values as $value}
					<td>{$value}</td>
				{/foreach}
			</tr>
		{/foreach}
	</tbody>
</table>
