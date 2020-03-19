{t}Vážený zákazníku,{/t}<br/>

{capture assign="order_title"}{t order_no=$order->getOrderNo()}Vaše objednávka č.%1{/t} - {$order_status}{/capture}
{render partial="partials/title_box" content=$order_title}

{render partial="order_statuses/$order_status_code.html"}

{render partial="digital_contents_notice.html"}

{render partial="order_status_check_notice.html"}
