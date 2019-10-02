<h1>{button_create_new}{t}vytvořit novou kampaň{/t}{/button_create_new} {$page_title}</h1>

{render partial="shared/search_form"}

<p>{t escape=no}Kampaně se používají pro stanovení <em>procentní slevy nebo dopravy zdarma od určité částky</em> nebo <em>slevy pro registrované zákazníky</em>.{/t}</p>

{if $finder->isEmpty()}

	<p>{t}Nebyla nalezena ani jedna kampaň.{/t}</p>

{else}

	<table class="table">

	<thead>
		<tr>
			<th>#</th>
			<th>{t}Oblasti{/t}</th>
			{sortable key=name}<th>{t}Název{/t}</th>{/sortable}
			<th>{t}Obsah{/t}</th>
			<th>{t}Podmínky{/t}</th>
			<th>{t}Je aktivní?{/t}</th>
			<th>{t}Valid from{/t}</th>
			<th>{t}Valid to{/t}</th>
			{sortable key=created_at}<th>{t}Datum vytvoření{/t}</th>{/sortable}
			<th></th>
		</tr>
	</thead>

	<tbody>
		{render partial=campaign_item from=$finder->getRecords()}
	</tbody>

	</table>

	{paginator}

{/if}
