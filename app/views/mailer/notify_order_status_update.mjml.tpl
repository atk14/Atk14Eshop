<mj-section>
	<mj-column>
		<mj-text>
      {t}Vážený zákazníku,{/t}<br/>

{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {$order_status}{/capture}
<span class="title">{!$order_title}</span><br/><br/>

{render partial="order_statuses/$order_status_code.html"}

{render partial="digital_contents_notice.mjml"}

{render partial="order_status_check_notice.html"}
    </mj-text>
  </mj-column>
</mj-section>
