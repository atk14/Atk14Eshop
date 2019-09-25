{foreach WarehouseItem::FindAll("product_id",$product) as $item}
	{a action="warehouse_items/edit" id=$item}{!"boxes"|icon} {t warehouse=$item->getWarehouse()->getName()}Edit stockount in warehouse %1{/t}{/a}
{/foreach}
{foreach PricelistItem::FindAll("product_id",$product) as $item}
	{a action="pricelist_items/edit" id=$item}{!"money-bill-wave"|icon} {t pricelist=$item->getPricelist()->getName()}Edit price in pricelist %1{/t}{/a}
{/foreach}
