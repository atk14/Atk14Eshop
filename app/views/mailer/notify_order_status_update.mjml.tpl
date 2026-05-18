<mj-section>
	<mj-column>
		<mj-text>
      {t}Vážený zákazníku,{/t}<br/>

{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {$order_status}{/capture}
<span class="title">{!$order_title}</span><br/>
    </mj-text>

{* uncomment for debugging various order states *}
{*
  {assign var="statuses" value=[
    "cancelled",
    "delivered",
    "finished_successfully",
    "payment_accepted",
    "payment_failed",
    "processing",
    "ready_for_pickup",
    "repeated_call_for_pickup_order",
    "repeated_payment_request",
    "returned",
    "shipped",
    "waiting_for_bank_transfer"
    ]}    
  {assign order_status_code $statuses[11]}
*}

{render partial="order_statuses/$order_status_code.mjml"}

{render partial="partials/digital_contents_notice.mjml"}

{render partial="partials/order_status_check_notice.mjml"}

  </mj-column>
</mj-section>
