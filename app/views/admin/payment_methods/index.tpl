<h1>{button_create_new}{t}Nová možnost platby{/t}{/button_create_new} {$page_title}</h1>

<ul class="list-group list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{foreach $payment_methods as $payment_method}
		<li class="list-group-item" data-id="{$payment_method->getId()}">
		{dropdown_menu clearfix=0}
			{a action=edit id=$payment_method}<i class="glyphicon glyphicon-edit"></i> {t}Edit{/t}{/a}
			{if $payment_method->isActive()}
				{a action=disable id=$payment_method _method="post"}<i class="glyphicon glyphicon-ban-circle"></i> {t}Vypnout{/t}{/a}
			{else}
				{a action=enable id=$payment_method _method="post"}<i class="glyphicon glyphicon-ok-circle"></i> {t}Zapnout{/t}{/a}
			{/if}
			{if $payment_method->isDeletable()}
				{a_destroy id=$payment_method}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}

		{if $payment_method->getLogo()}
			{!$payment_method->getLogo()|pupiq_img:"x40"}
		{/if}
		#{$payment_method->getId()}

		{render partial="shared/active_state" object=$payment_method}

		{$payment_method->getLabel()}
		<br>
		<small>{render partial="shared/region_list" regions=$payment_method->getRegions()}</small>


		</li>
	{/foreach}
</ul>
