<h1>{$page_title}</h1>

<ul>
	{foreach $delivery_methods as $dm}
		<li><h4>{a action=edit_payment_methods delivery_method_id=$dm}<em>{$dm->getRegions()|to_sentence}</em> / {$dm}{/a}</h4>
			<ul>
				{foreach $dm->getPaymentMethods() as $pm}
					<li>{render partial="shared/active_state" object=$pm} {$pm} ({$pm->getRegions()|to_sentence})</li>
				{/foreach}
			</ul>
		</li>
	{/foreach}
</ul>
