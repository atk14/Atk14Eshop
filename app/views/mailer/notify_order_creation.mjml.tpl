<mj-section>
	<mj-column>
		<mj-text>

			{t escape=no}Vážený zákazníku,{/t}<br/><br/>

{render partial="thanks_for_order_lower.html"}

{if $special_note}
	
	{render partial="partials/title_box" content=$special_note|h|nl2br titlebg="{$special_note_bgcolor}" titlecolor="{$special_note_color}" space_before=0}
{/if}

{t}V případě osobního odběru vyčkejte na výzvu k vyzvednutí. Pokud jste zvolili úhradu bankovním převodem, podklady k úhradě objednávky Vám budou zaslány obratem.{/t}

{if $shipping_days|strlen}
	{if $shipping_days=="3-5"}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dní od připsání platby na náš bankovní účet.{/t}
	{else}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dnů od připsání platby na náš bankovní účet.{/t}
	{/if}
{/if}

		</mj-text>
	</mj-column>
</mj-section>
		
		
		<mj-wrapper mj-class="order-overview">
			<mj-section>
				<mj-column width="100%" padding="0">
					<mj-text>
						<p class="nomargin"><strong>{t}Detaily objednávky{/t}</strong></p>
					</mj-text>
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>
			
			<mj-section>
				<mj-column width="100%" padding-top="0" padding-bottom="0">
					<mj-text mj-class="smalltext">
						{t}Číslo objednávky:{/t} <strong>{!$order->getOrderNo()}</strong><br />
						{t}Vytvořena:{/t} {$order->getCreatedAt()|format_datetime}<br />
						{t}Platba:{/t} {$order->getPaymentMethod()}
					</mj-text>
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>

			{foreach $order->getItems() as $item}
				{render partial="partials/order_item.mjml" item=$item}
			{/foreach}

			<mj-section>
					<mj-group>
						<mj-column padding="0" width="50%"><mj-text>{t}Cena celkem{/t}</mj-text></mj-column>
						<mj-column padding="0" width="50%"><mj-text align="right">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</mj-text></mj-column>
					</mj-group>
				</mj-section>

				{foreach $order->getVouchers() as $voucher}
				<mj-section>
					<mj-group>
						<mj-column padding="0" width="50%"><mj-text>{$voucher->getDescription()}</mj-text></mj-column>
						<mj-column padding="0" width="50%"><mj-text align="right">{$voucher}</mj-text></mj-column>
					</mj-group>
				</mj-section>
			{/foreach}
			
			{foreach $order->getCampaigns() as $campaign}
				{if $campaign->getDiscountAmount()}
					<mj-section>
						<mj-group>
							<mj-column padding="0" width="50%"><mj-text>{$campaign}</mj-text></mj-column>
							<mj-column padding="0" width="50%"><mj-text align="right">-{!$campaign->getDiscountAmount()|display_price:"$currency"}</mj-text></mj-column>
						</mj-group>
					</mj-section>
				{/if}
			{/foreach}
		
			
			<mj-section>
				<mj-group>
					<mj-column padding="0" width="50%"><mj-text>{t}Doprava{/t}</mj-text></mj-column>
					<mj-column padding="0" width="50%"><mj-text align="right">{!$order->getShippingFeeInclVat()|display_price:"$currency"|default:$mdash}</mj-text></mj-column>
				</mj-group>
			</mj-section>
			
			<mj-section>
				<mj-column width="100%">
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>
			<mj-section>
				<mj-group>
					<mj-column padding="0" width="50%"><mj-text>{t}Celkem k úhradě{/t}</mj-text></mj-column>
					<mj-column padding="0" width="50%"><mj-text align="right"><strong>{!$order->getPriceToPay()|display_price:"$currency,summary"}{if is_null($order->getShippingFeeInclVat())}<sup>*</sup>{/if}</strong></mj-text></mj-column>
				</mj-group>
			</mj-section>
			
			{if is_null($order->getShippingFeeInclVat())}
				<mj-section>
					<mj-column padding="0">
						<mj-text>
							<small><sup>*</sup> {t}Uvedená konečná cena neobsahuje poplatek za dopravu.{/t}</small>
						</mj-text>
					</mj-column>
				</mj-section>
			{/if}
			
			<mj-section padding-top="20px">
				<mj-column width="100%" padding="0">
					<mj-text>
						<p class="nomargin"><strong>{t}Přeprava{/t}</strong></p>
					</mj-text>
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>
			
			<mj-section>
				<mj-column width="100%" padding-top="0" padding-bottom="0">
					<mj-text mj-class="smalltext">
						{t}Dopravce:{/t} <strong>{$order->getDeliveryMethod()}</strong><br>
						{*Tracking: <a href="#">356166</a><br>*}
					</mj-text>
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
				<mj-column width="50%" padding-top="0" padding-bottom="0">
					<mj-text mj-class="smalltext">
						<strong>{t}Fakturační adresa{/t}</strong><br>
						{render partial="shared/order/invoice_address"}
					</mj-text>
				</mj-column padding-top="0" padding-bottom="0">
				<mj-column width="50%">
					<mj-text mj-class="smalltext">
						<strong>{t}Dodací adresa{/t}</strong><br>
						{render partial="shared/order/delivery_address"}
					</mj-text>
				</mj-column>
				<mj-column width="100%">
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>
			
			{if $order->getNote()}
				<mj-section>
					<mj-column padding="0">
						<mj-text mj-class="smalltext">
							<strong>{t}Vaše poznámka k objednávce:{/t}</strong><br>
							{!$order->getNote()|h|nl2br}
						</mj-text>
						<mj-divider mj-class="thin"></mj-divider>
					</mj-column>
				</mj-section>
			{/if}
			
			<mj-section>
				<mj-column padding="0">
					<mj-text mj-class="smalltext">
						{render partial="order_status_check_notice.html"}
					</mj-text>
					<mj-divider mj-class="thin"></mj-divider>
				</mj-column>
			</mj-section>
			
			<mj-section>
				<mj-column>
					<mj-spacer></mj-spacer>
				</mj-column>
			</mj-section>
			
			
		</mj-wrapper>