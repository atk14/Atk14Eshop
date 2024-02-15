<li class="list-group-item" data-id="{$delivery_method->getId()}">
	<div class="item__properties">

		<div class="item__title">
			{render partial="shared/active_state" object=$delivery_method}

			#{$delivery_method->getId()}

			{if $delivery_method->getLogo()}
				{!$delivery_method->getLogo()|pupiq_img:"40x40x#ffffff"}
			{/if}

			{$delivery_method->getLabel()}
			<br>
			<small>{render partial="shared/region_list" regions=$delivery_method->getRegions()}</small>
		</div>

		<div class="item__code">
			{$delivery_method->getCode()}
		</div>

		<div>
			<small>{t}Výchozí cena s DPH{/t}</small><br>
			{$delivery_method->getPriceInclVat()|display_price:"format=plain"|default:"{t}cena neurčena{/t}"}
		</div>

		<div>
			{if $delivery_method->getPersonalPickupOnStore()}
				<small>{t}Osobní odběr na prodejně{/t}</small><br>
				{$delivery_method->getPersonalPickupOnStore()}
			{/if}
		</div>

		<div>
			{if $delivery_method->getDesignatedForTags()}
				<small>{t}Určeno pro štítky{/t}</small><br>
				{$delivery_method->getDesignatedForTags()|to_sentence}<br>
			{/if}
			{if $delivery_method->getExcludedForTags()}
				<small>{t}Vyloučeno pro štítky{/t}</small><br>
				{$delivery_method->getExcludedForTags()|to_sentence}<br>
			{/if}
			{if $delivery_method->getRequiredTag()}
				<small>{t}Exkluzivní metoda pro štítek{/t}</small><br>
				{$delivery_method->getRequiredTag()}
			{/if}
		</div>

		<div>
			{if $delivery_method->getRequiredCustomerGroup()}
				<small>{t}Only for customer group:{/t}</small><br>
				{$delivery_method->getRequiredCustomerGroup()}
			{/if}
		</div>

		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$delivery_method}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
				{a action="shipping_combinations/edit_payment_methods" delivery_method_id=$delivery_method}{!"list"|icon} {t}Vybrat možné platební metody{/t}{/a}
				{if $delivery_method->isActive()}
					{a action=disable id=$delivery_method _method="post"}{!"ban"|icon} {t}Vypnout{/t}{/a}
				{else}
					{a action=enable id=$delivery_method _method="post"}{!"check-circle"|icon} {t}Zapnout{/t}{/a}
				{/if}
				{if $delivery_method->isDeletable()}
					{a_destroy id=$delivery_method}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>

	</div>
</li>
