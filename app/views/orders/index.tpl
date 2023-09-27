{capture assign=page_title}{t}Historie a detaily mých objednávek{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title}

{if !$orders_total}

		{t}Zatím jste nevytvořili žádnou objednávku{/t}

{else}

	{render partial="shared/search_form"}

	{if !$finder->isEmpty()}

		<table class="table">
			<thead class="thead--hidden-xs">
				<tr>
					<th>{t}Číslo objednávky{/t}</th>
					<th class="text-sm-right">{t}Cena{/t}</th>
					{sortable key="created_at"}<th>{t}Datum vytvoření{/t}</th>{/sortable}
					<th>{t}Stav{/t}</th>
					<th></th>
					{* <th class="text-sm-right">{t}Faktura{/t}</th> *}
				</tr>
			</thead>
			<tbody>
				{render partial="order_item" from=$finder->getRecords()}
			</tbody>
		</table>

		{paginator items_total_label="{t}objednávek celkem{/t}"}


	{else}

		<p>
			{t}Nebyla nalezena žádná objednávka{/t}
		</p>

	{/if}

{/if}
