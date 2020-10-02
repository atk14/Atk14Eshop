{render partial="thanks_for_order.html"}

{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 byla úspěšně dokončena.{/t}
<br/><br/>
{t}Vybrali jste si platbu bankovním převodem.{/t}<br/>
{t escape=no}Zboží Vám bude dodáno <strong>po obdržení Vaší platby</strong>.{/t}
<br/><br/>
{t}Zde jsou bankovní údaje pro platbu bankovním převodem:{/t}
<br/><br/>
{render partial="partials/bank_transfer_data" order=$order}
