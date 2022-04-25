{if $products}
	{assign digital_product Tag::GetInstanceByCode("digital_product")}
	{capture assign=return_uri}{$request->getUri()}#variants{/capture}

	<ul class="list-group list-sortable" data-sortable-url="{link_to action="products/set_rank"}">
		{foreach $products as $product}
			{assign tags $product->getTags()}
			<li class="list-group-item" data-id="{$product->getId()}">
				{dropdown_menu clearfix=false}
					{a action="products/edit" id=$product return_uri=$return_uri}{icon glyph="edit"} {t}Edit{/t}{/a}
					{render partial="product_menu_links" product=$product}
					{capture assign="confirm"}{t 1=$product->getFullName()|h escape=no}Chystáte se smazat produkt %1. Jste si jistý/á?{/t}{/capture}
					{a_destroy action="products/destroy" id=$product _confirm=$confirm}{icon glyph="remove"} {t}Delete{/t}{/a_destroy}
				{/dropdown_menu}

				<div class="float-left">
				{render partial="shared/list_thumbnail" image=$product->getImage(false)}
				</div>
				{$product->getCatalogId()}<br>
				<strong>{if $product->getLabel()}{$product->getLabel()}{else}<em>{t}unnamed variant{/t}</em>{/if}</strong>
				{if !$product->isVisible()}<em>({!"eye-slash"|icon} {t}invisible{/t})</em>{/if}
				{if $tags}
					<br>
					{render partial="shared/tags" tags=$tags}
				{/if}

				{if $product->containsTag($digital_product)}
					{assign digital_contents DigitalContent::FindAll("product_id",$product,"deleted",false)}
					<br>{t}soubory ke stažení:{/t} {a action="digital_contents/index" product_id=$product}{$digital_contents|count}{/a}
				{/if}
			</li>
		{/foreach}
	</ul>

{else}

	<p>{t}Produkt zatím nemá žádnou variantu.{/t}</p>

{/if}
