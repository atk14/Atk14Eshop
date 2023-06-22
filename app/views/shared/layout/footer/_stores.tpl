{assign max_stores 3}
{assign stores Store::FindAll("visible AND (code IS NULL OR code!='eshop')",[],["limit" => $max_stores + 1])}

{foreach array_slice($stores,0,$max_stores) as $store}
	{admin_menu for=$store edit_title="{t}Upravit údaje prodejny{/t}" only_edit=1}
	<div class="h5 footer__links-heading">{a action="stores/detail" id=$store}{$store->getName()}{/a}</div>
	<address>
		{!$store->getAddress()|h|nl2br}<br>
	</address>
{/foreach}

{if sizeof($stores)>$max_stores}
	<a href="{link_to namespace="" action="stores/index"}">{t}zobrazit všechny prodejny{/t}</a>
{/if}
