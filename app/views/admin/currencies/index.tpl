<h1>{$page_title}</h1>

<ul class="list-group">
	{foreach $currencies as $currency}
		<li class="list-group-item">
			{$currency->getCode()}
			{if $currency->getCode()!=$currency->getSymbol()}
				({$currency->getSymbol()})
			{/if}
			{if $currency->isDefaultCurrency()}
				<small>{t}default currency{/t}</small>
			{else}
				<small>{t}conversion rate{/t}:  1 {$currency} = {$currency->getRate()|display_number} {$default_currency}</small>
			{/if}

			{dropdown_menu}
				{a action="edit" id=$currency}{!"edit"|icon} {t}Edit{/t}{/a}
			{/dropdown_menu}
		</li>
	{/foreach}
</ul>
