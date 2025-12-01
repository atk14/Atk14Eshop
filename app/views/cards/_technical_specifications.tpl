{assign technical_specifications $card->getTechnicalSpecifications(["visible" => true])}
{assign filters $card->getActiveFilters()}

{if $technical_specifications || $filters}
	<table class="table table-sm">
		{foreach $technical_specifications as $ts}
			<tr>
				<th>{$ts->getKey()}</th>
				<td>{!$ts->getContent()|markdown}</td>
			</tr>
		{/foreach}
		{foreach $filters as $filter}
			<tr>
				<th>{$filter}</th>
				<td>
					{foreach $card->getCategories(["root_category" => $filter, "consider_invisible_categories" => false]) as $filter_option}
						{$filter_option}{if !$filter_option@last}, {/if}
					{/foreach}
				</td>
			</tr>
		{/foreach}
	</table>
{/if}
