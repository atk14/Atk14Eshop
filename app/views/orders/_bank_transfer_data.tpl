{if $order}
	{assign currency $order->getcurrency()}
	{assign bank_account $order->getbankaccount()}

	{capture assign=bank_transfer_data}
		<strong>{t}částka k úhradě:{/t}</strong> {!$order->getpricetopay()|display_price:"$currency,summary"}
		<br>
		<strong>{t}variabilní symbol:{/t}</strong> {$order->getorderno()}
		<br>
		<strong>{t}číslo účtu:{/t}</strong> {$bank_account->getaccountnumber()}
		{if $bank_account->getiban()}
			<br>
			<strong>iban:</strong> {$bank_account->getiban()}
		{/if}
		{if $bank_account->getswiftbic()}
			<br>
			<strong>swift:</strong> {$bank_account->getswiftbic()}
		{/if}
		{if $bank_account->getholdername()}
			<br>
			<strong>{t}majitel účtu:{/t}</strong> {$bank_account->getholdername()}
		{/if}
		
		{if constant("payment_qr_codes_enabled")}
			<br>
			<img src="{link_to namespace="" action="payment_qr_codes/detail" order_token=$order->gettoken(["extra_salt" => "qrpayment","hash_length" => 16])}" width="200" height="200" class="pull-right img-responsive">
		{/if}
	{/capture}
{/if}
