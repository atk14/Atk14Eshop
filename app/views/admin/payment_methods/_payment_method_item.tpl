<li class="list-group-item" data-id="{$payment_method->getId()}">
	<div class="item__properties">

		<div class="item__title">
			{render partial="shared/active_state" object=$payment_method}

			#{$payment_method->getId()}

			{if $payment_method->getLogo()}
				{!$payment_method->getLogo()|pupiq_img:"40x40x#ffffff"}
			{/if}

			{$payment_method->getLabel()}
			<br>
			<small>{render partial="shared/region_list" regions=$payment_method->getRegions()}</small>
		</div>

		<div class="item__code">
			{$payment_method->getCode()}
		</div>

		<div>
			<small>{t}Platební brána{/t}</small><br>
			{$payment_method->getPaymentGateway()|default:$mdash}
		</div>

		<div>
			<small>{t}Cena s DPH{/t}</small><br>
			{$payment_method->getPriceInclVat()|display_price:"format=plain"}
		</div>

		<div>
			{if $payment_method->getDesignatedForTags()}
				<small>{t}Určeno pro štítky{/t}</small><br>
				{$payment_method->getDesignatedForTags()|to_sentence}<br>
			{/if}
			{if $payment_method->getExcludedForTags()}
				<small>{t}Vyloučeno pro štítky{/t}</small><br>
				{$payment_method->getExcludedForTags()|to_sentence}<br>
			{/if}
		</div>

		<div>
			{if $payment_method->getRequiredCustomerGroup()}
				<small>{t}Only for customer group:{/t}</small><br>
				{$payment_method->getRequiredCustomerGroup()}
			{/if}
		</div>

		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$payment_method}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
				{if $payment_method->isActive()}
					{a action=disable id=$payment_method _method="post"}{!"ban"|icon} {t}Vypnout{/t}{/a}
				{else}
					{a action=enable id=$payment_method _method="post"}{!"check-circle"|icon} {t}Zapnout{/t}{/a}
				{/if}
				{if $payment_method->isDeletable()}
					{a_destroy id=$payment_method}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>

	</div>
</li>
