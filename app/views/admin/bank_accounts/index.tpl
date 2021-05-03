<h1>{button_create_new}{t}Add new bank account{/t}{/button_create_new} {$page_title}</h1>


{if $bank_accounts}

	{if sizeof($bank_accounts)>1}
	<p>
		{t}Nejvhodnější bankovní účet pro uhrazení platby za objednávku bude vybrán v daném pořadí dle prodejní oblasti a peněžní měny objednávky.{/t}
	</p>
	{/if}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{render partial="bank_account_item" from=$bank_accounts}
	</ul>

{else}

	<p>{t}No record has been found.{/t}</p>

{/if}
