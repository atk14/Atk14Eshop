{*
 * {render partial="cards/product_menu_links" product=$product}
 * {render partial="cards/product_menu_links" product=$product display_dividers=0}
 *}

{if !isset($display_dividers)}
	{assign display_dividers 1}
{/if}

{if $product}

{assign divider "<div class=\"dropdown-divider\"></div>"}
{if !$display_dividers}
	{assign divider ""}
{/if}

{foreach WarehouseItem::FindAll("product_id",$product) as $item}
	{a action="warehouse_items/edit" id=$item}{!"boxes"|icon} {t warehouse=$item->getWarehouse()->getName()}Edit stockcount in warehouse %1{/t}{/a}
	{if $item@last}{!$divider}{/if}
{foreachelse}	
	{assign warehouse Warehouse::GetDefaultInstance4Eshop()}
	{if $warehouse}
		{a action="warehouse_items/create_new" warehouse_id=$warehouse product_id=$product}{!"boxes"|icon} {t warehouse=$warehouse->getName()}Create new entry in warehouse %1{/t}{/a}
		{!$divider}
	{/if}
{/foreach}

{foreach PricelistItem::FindAll("product_id",$product) as $item}
	{a action="pricelist_items/edit" id=$item}{!"money-bill-wave"|icon} {t pricelist=$item->getPricelist()->getName()}Edit price in pricelist %1{/t}{/a}
	{if $item@last}{!$divider}{/if}
{foreachelse}	
	{assign pricelist Pricelist::GetDefaultPricelist()}
	{if $pricelist}
		{a action="pricelist_items/create_new" pricelist_id=$pricelist product_id=$product}{!"money-bill-wave"|icon} {t pricelist=$pricelist->getName()}Create new entry in pricelist %1{/t}{/a}
		{!$divider}
	{/if}
{/foreach}

{if $product->containsTag(Tag::GetInstanceByCode("digital_product"))}
	{a action="digital_contents/index" product_id=$product}{!"cloud-download-alt"|icon} {t}Soubory ke stažení{/t}{/a}
{/if}

{/if}
