<h1>{$page_title}</h1>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}Nebyla nalezana ani jedna žádost.{/t}</p>

{else}

	<table class="table">	
		
		<thead>
			<tr>
				<th>#</th>
				<th>{t}Objednávka{/t}</th>
				<th>{t}Jméno{/t}</th>
				<th>{t}E-mail{/t}</th>
				<th>{t}Telefon{/t}</th>
				{sortable key=created_at}<th>{t}Created at{/t}</th>{/sortable}
				<th></th>
			</tr>
		</thead>

		<tbody>
			{render partial="order_withdrawal_request_item" from=$finder->getRecords()}
		</tbody>

	</table>

	{paginator}

{/if}
