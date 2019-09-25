<tr>
	<th>{$day_title}</th>
	<td>
		{if $store->g("opening_hours_{$day}1")}
			{$store->g("opening_hours_{$day}1")|float_to_hour} {$mdash} {$store->g("opening_hours_{$day}2")|float_to_hour}
		{else}
			{t}zavřeno{/t}
		{/if}
	</td>
</tr>
