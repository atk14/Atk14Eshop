{t}Vážený zákazníku,{/t}<br/><br/>

{t product=$product|h catalog_id=$product->getCatalogId()|h escape=false}produkt <em>%1</em> s katalogovým číslem <em>%2</em> byl právě naskladněn.{/t}<br/></br>

{capture assign=product_link}{link_to namespace="" action="cards/detail" id=$product->getCard() _with_hostname=true}{/capture}
{t}Produkt najdete na adrese{/t}<br/>
<a href="{$product_link}" style="{$link_style}">{$product_link}</a>
