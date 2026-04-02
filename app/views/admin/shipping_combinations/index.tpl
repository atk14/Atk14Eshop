<h1>{$page_title}</h1>

<ul class="list-group">
	{foreach $delivery_methods as $dm}
		<li class="list-group-item">
			{dropdown_menu clearfix=0}
				{a action=edit_payment_methods delivery_method_id=$dm}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
			{/dropdown_menu}
			<strong>{$dm} ({render partial="shared/region_list" regions=$dm->getRegions()})</strong><br>
			{if $dm->getPaymentMethods()}
			<ul class="list-unstyled">
				{foreach $dm->getPaymentMethods() as $pm}
					<li>{render partial="shared/active_state" object=$pm} {$pm} ({render partial="shared/region_list" regions=$pm->getRegions()})</li>
				{/foreach}
			</ul>
			{else}
				<em>{t}no payment methods selected{/t}</em>
			{/if}
		</li>
	{/foreach}
</ul>
