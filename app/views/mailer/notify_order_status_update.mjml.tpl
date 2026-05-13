<mj-section>
	<mj-column>
		<mj-text>
      {t}Vážený zákazníku,{/t}<br/>

{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {$order_status}{/capture}
<span class="title">{!$order_title}</span><br/><br/>
--order status code: -- {$order_status_code} --
    </mj-text>

{render partial="order_statuses/$order_status_code.mjml"}
{*render partial="order_statuses/waiting_for_bank_transfer.mjml"*}

{render partial="digital_contents_notice.mjml"}

{render partial="order_status_check_notice.mjml"}

  </mj-column>
</mj-section>
