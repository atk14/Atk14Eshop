{render partial="thanks_for_order.html"}

{t order_no=$order->getOrderNo() escape=no}Doposud jsme nedobdrželi platbu za Vaši objednávku č. %1. Zboží Vám bude dodáno, <strong>po obdržení Vaší platby</strong>.{/t}
<br/><br/>
{t}Pokud objednávku nezaplatíte do 10 dnů, bude automaticky stornována.{/t}
<br/><br/>
{t}Zde je rekapitulace údajů pro platbu bankovním převodem:{/t}
<br/><br/>
{render partial="partials/bank_transfer_data" order=$order}
<br/><br/>
{t}QR kód pro načtení platby do bankovní aplikace:{/t}
<br/>
<img src="cid:qrcode" width="200" height="200" alt="{t}QR kód{/t}">
