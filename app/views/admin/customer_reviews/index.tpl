<h1>{$page_title}</h1>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}The list is empty.{/t}</p>

{else}

	<table class="table table-sm table-striped table--articles">
		<thead>
			<tr class="table-dark">
				<th class="item-id">#</th>
				<th>{t}Catalog Id{/t}</th>
				<th>{t}Product{/t}</th>
				<th class="item-author">{t}Author{/t}</th>
				<th class="item-title">{t}Title{/t}</th>
				<th>{t}Rating{/t}</th>
				<th>{t}Status{/t}</th>
				{sortable key=created_at}<th>{t}Date{/t}</th>{/sortable}
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial="customer_review_item" from=$finder->getRecords()}
		</tbody>
	</table>

	{paginator}

{/if}
