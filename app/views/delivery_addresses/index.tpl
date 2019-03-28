<h1>{$page_title}</h1>

{if !$delivery_addresses}
	
	<p>{t}Nemáte uloženou žádnou doručovací adresu{/t} &rarr; {a action="create_new"}{t}vytvořte novou{/t}{/a}</p>

{else}

	<p>{a action="create_new" _class="btn btn-default"}{t}Vytvořit novou adresu{/t}{/a}</p>

	{render partial="shared/delivery_addresses" delivery_addresses=$delivery_addresses}

{/if}
