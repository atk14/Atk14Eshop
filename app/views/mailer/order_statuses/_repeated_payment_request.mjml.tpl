<mj-text>
{render partial="thanks_for_order.html"}

{t order_no=$order->getOrderNo() escape=no}Doposud jsme nedobdrželi platbu za Vaši objednávku č. %1. Zboží Vám bude dodáno, <strong>po obdržení Vaší platby</strong>.{/t}
<br/>
{t}Pokud objednávku nezaplatíte do 10 dnů, bude automaticky stornována.{/t}
<br/>
{t}Zde je rekapitulace údajů pro platbu bankovním převodem:{/t}
<br/>
</mj-text>
{render partial="partials/bank_transfer_data.mjml" order=$order}