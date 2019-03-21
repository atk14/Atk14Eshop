<h1>{button_create_new}{t}Nová možnost doručení{/t}{/button_create_new} {$page_title}</h1>

<ul class="list-group list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{foreach $delivery_methods as $delivery_method}
		<li class="list-group-item" data-id="{$delivery_method->getId()}">
		{if $delivery_method->getLogo()}
			{!$delivery_method->getLogo()|pupiq_img:"x40"}
		{/if}
		#{$delivery_method->getId()}

		{render partial="shared/active_state" object=$delivery_method}

		<em>{$delivery_method->getRegions()|to_sentence}</em> / {$delivery_method->getLabel()}

		{if $delivery_method->personalPickup()}
			<span title="{t}osobní odběr{/t}">{!"briefcase"|icon}</span>
			{assign personal_pickup_on_store $delivery_method->getPersonalPickupOnStore()}
			{if $personal_pickup_on_store}
				{$personal_pickup_on_store->getName()}
			{else}
				<em>{t}prodejna není určena{/t}</em>
			{/if}
		{/if}
		{dropdown_menu}
			{a action=edit id=$delivery_method}<i class="glyphicon glyphicon-edit"></i> {t}Edit{/t}{/a}
			{a action="shipping_combinations/edit_payment_methods" delivery_method_id=$delivery_method}{!"list"|icon} {t}Vybrat možné platební metody{/t}{/a}
			{if $delivery_method->isActive()}
				{a action=disable id=$delivery_method _method="post"}<i class="glyphicon glyphicon-ban-circle"></i> {t}Vypnout{/t}{/a}
			{else}
				{a action=enable id=$delivery_method _method="post"}<i class="glyphicon glyphicon-ok-circle"></i> {t}Zapnout{/t}{/a}
			{/if}
			{if $delivery_method->isDeletable()}
				{a_destroy id=$delivery_method}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}

		</li>
	{/foreach}
</ul>
