{if $product}

{foreach WarehouseItem::FindAll("product_id",$product) as $item}
	{a action="warehouse_items/edit" id=$item}{!"boxes"|icon} {t warehouse=$item->getWarehouse()->getName()}Edit stockount in warehouse %1{/t}{/a}
{foreachelse}	
	{assign warehouse Warehouse::GetDefaultInstance4Eshop()}
	{if $warehouse}
		{a action="warehouse_items/create_new" warehouse_id=$warehouse product_id=$product}{!"boxes"|icon} {t warehouse=$warehouse->getName()}Create new entry in warehouse %1{/t}{/a}
	{/if}
{/foreach}

{foreach PricelistItem::FindAll("product_id",$product) as $item}
	{a action="pricelist_items/edit" id=$item}{!"money-bill-wave"|icon} {t pricelist=$item->getPricelist()->getName()}Edit price in pricelist %1{/t}{/a}
{foreachelse}	
	{assign pricelist Pricelist::GetDefaultPricelist()}
	{if $pricelist}
		{a action="pricelist_items/create_new" pricelist_id=$pricelist product_id=$product}{!"money-bill-wave"|icon} {t pricelist=$pricelist->getName()}Create new entry in pricelist %1{/t}{/a}
	{/if}
{/foreach}

{if $product->containsTag(Tag::GetInstanceByCode("digital_product"))}
	{a action="digital_contents/index" product_id=$product}{!"cloud-download-alt"|icon} {t}Soubory ke stažení{/t}{/a}
{/if}

{/if}
