{assign user_special_pricelists UserSpecialPricelist::FindAll("user_id",$user)}

<h3 id="user_special_pricelists">{button_create_new controller="user_special_pricelists" action="create_new" user_id=$user return_to_anchor="user_special_pricelists"}{t}Adding a special pricelist{/t}{/button_create_new} {t}Special price lists{/t}</h3>

{if !$user_special_pricelists}

	<p>{t}There is no special price list attached to this user.{/t}</p>

{else}

	<ul class="list-group list-sortable list-group--iobjects" data-sortable-url="{link_to action="user_special_pricelists/set_rank"}">
		{foreach $user_special_pricelists as $user_special_pricelist}
			{assign special_pricelist $user_special_pricelist->getSpecialPricelist()}
			<li class="list-group-item" data-id="{$user_special_pricelist->getId()}">

				{dropdown_menu clearfix=false}
					{a_destroy controller="user_special_pricelists" id=$user_special_pricelist}{!"remove"|icon} {t}Remove{/t}{/a_destroy}
				{/dropdown_menu}

				<small>#{$special_pricelist->getId()}</small> {$special_pricelist->getName()}

			</li>
		{/foreach}
	</ul>

{/if}
