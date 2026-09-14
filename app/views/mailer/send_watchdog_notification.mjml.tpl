<mj-section>
	<mj-column>
		<mj-text>
{t}Vážený zákazníku,{/t}<br/><br/>

{t product=$product|h catalog_id=$product->getCatalogId()|h escape=false}produkt <em>%1</em> s katalogovým číslem <em>%2</em> byl právě naskladněn.{/t}<br/><br/>

{capture assign=product_link}{link_to namespace="" action="cards/detail" id=$product->getCard() _with_hostname=true}{/capture}
{t}Produkt najdete na adrese{/t}<br/>
    </mj-text>
    <mj-button href="{$product_link}">{t}Zobrazit produkt{/t}</mj-button>
    <mj-text>
      <p style="text-align: center;"><small><a href="{$product_link}" class="muted">{$product_link}</a></small></p>
    </mj-text>
  </mj-column>
</mj-section>
