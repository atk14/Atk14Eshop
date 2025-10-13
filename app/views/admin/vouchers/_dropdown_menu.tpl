{if !isset($clearfix)}{assign clearfix true}{/if}

{dropdown_menu clearfix=$clearfix}
	{if $action=="index"}
		{a action="edit" id=$voucher}{!"edit"|icon} {t}Upravit{/t}{/a}
	{/if}
	<a href="{$voucher->getUrl()}">{!"eye-open"|icon} {t}Zobrazit náhled{/t}</a>
	{if $action=="index"}
		{if $voucher->isDeletable()}
			{a_destroy id=$voucher}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
		{/if}
	{/if}
{/dropdown_menu}
