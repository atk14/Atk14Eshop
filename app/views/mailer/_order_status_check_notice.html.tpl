{if $order->getUser()}{* neanonymni objednavka *}
{capture assign="url"}{link_to namespace="" action="orders/index" _with_hostname=$region->getDefaultDomain()}{/capture}
{t url=$url style=$link_style escape=no}V případě, že si chcete Vaši objednávku zkontrolovat,
Vaši objednávku naleznete v&nbsp;sekci <a href="%1" style="%2">"Historie objednávek"</a> Vašeho zákaznického účtu.{/t}
{/if}
