<tr>
	<td>{$special_opening_hour->getId()}</td>
	<td>{$special_opening_hour->getDate()|format_date}</td>
	<td>
		{if $special_opening_hour->getOpeningHours2()}
			{$special_opening_hour->getOpeningHours1()|float_to_hour} &mdash; {$special_opening_hour->getOpeningHours2()|float_to_hour}
		{else}
			{t}zavřeno{/t}
		{/if}
	</td>
	<td>{$special_opening_hour->getNote()|default:$mdash}</td>
	<td>
		{dropdown_menu}
			{a action="edit" id=$special_opening_hour}{!"edit"|icon} {t}Edit{/t}{/a}
			{a_destroy id=$special_opening_hour}{!"remove"|icon} {t}Delete{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
