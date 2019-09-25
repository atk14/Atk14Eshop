<h1>{$page_title}</h1>

{render partial="shared/form"}


{if $not_imported_packets}
	<ul>
	<h3>{t count=$not_imported_packets|count}Chyby importu (%1){/t}</h3>
	<ul>
		{foreach $not_imported_packets as $p}
			<li>{$p.tracking_number} - {$p.order_no} - {$p.message} ({t line_no=$p.line_no}řádek %1{/t})</li>
		{/foreach}
	</ul>
{/if}

{if $imported_packets}
	<h3>{t count=$imported_packets|count}Úspěšně importované zásilky (%1){/t}</h3>
	<ul>
		{foreach $imported_packets as $o}
			<li>{$o->getTrackingNumber()} - {a action="orders/detail" id=$o}{t order_no=$o->getOrderNo()}Objednávka %1{/t}{/a}</li>
		{/foreach}
	<ul>
{/if}
