{assign card_creators CardCreator::FindAll("card_id",$card)}
{capture assign=return_uri}{$request->getRequestUri()}#creators{/capture}

<div id="creators">

	<h3>{button_create_new action="card_creators/create_new" card_id=$card return_to_anchor=creators}{/button_create_new} {t}Creators{/t}</h3>

	{if $card_creators}

		<ul class="list-group list-sortable" data-sortable-url="{link_to action="card_creators/set_rank"}">
		{foreach $card_creators as $card_creator}
			<li class="list-group-item" data-id="{$card_creator->getId()}">
				{dropdown_menu clearfix=false}
					{a action="card_creators/edit" id=$card_creator return_uri=$return_uri}{icon glyph="edit"} {t}Edit{/t}{/a}
					{a action="creators/edit" id=$card_creator->getCreator() return_uri=$return_uri}{icon glyph="user"} {t}Edit creator{/t}{/a}

					{a_destroy action="card_creators/destroy" id=$card_creator}{icon glyph="remove"} {t}Remove{/t}{/a_destroy}
				{/dropdown_menu}

				{if $card_creator->isMainCreator()}<strong title="{t}Main creator{/t}">{/if}

				<small>{$card_creator->getCreatorRole()}</small><br>
				{$card_creator->getCreator()}

				{if $card_creator->isMainCreator()}</strong>{/if}
			</li>
		{/foreach}
		</ul>

	{else}

		<p>{t}This product has no creator specified{/t}</p>
		
	{/if}

</div>
