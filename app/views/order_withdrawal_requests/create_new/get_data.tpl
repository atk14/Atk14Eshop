<h1>{$page_title}</h1>

<p>{t order_no=$order->getOrderNo()}Odesláním tohoto formuláře podáte žádost na odstoupení od kupní smlouvy k objednávce č. %1.{/t}</p>

<ul>
	<li>{t}Zkontrolujte správnost údajů.{/t}</li>
	<li>{t}Zatrhněte položky objednávky, které chcete vratit.{/t}</li>
	{if !$form->has_field("bank_account_number")}
		<li>{t}Hodnotu vráceného zboží vám vrátíme na bankovní účet / platební kartu, ze které byla objednávka uhrazena.{/t}</li>
	{/if}
</ul>

{render partial="shared/form"}
