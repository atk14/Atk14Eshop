{foreach Store::FindAll("visible",true) as $store}
	{if $store->getCode()!="eshop"}
		{admin_menu for=$store edit_title="{t}Upravit údaje prodejny{/t}" only_edit=1}
		<h5>{a action="stores/detail" id=$store}{$store->getName()}{/a}</h5>
		<address>
			{!$store->getAddress()|h|nl2br}<br>
		</address>
	{/if}
{/foreach}
