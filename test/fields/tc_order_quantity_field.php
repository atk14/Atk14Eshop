<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture warehouse_items
 */
class TcOrderQuantityField extends TcBase {

	function test(){
		// back tea: in stock 5 pcs
		$field = new OrderQuantityField($this->products["black_tea"]);
		$this->assertEquals(1,$field->min_value);
		$this->assertEquals(5,$field->max_value);
		$this->assertEquals(false,$field->disabled);

		// herbal teal: not in stock
		$field = new OrderQuantityField($this->products["herbal_tea"]);
		$this->assertEquals(0,$field->min_value);
		$this->assertEquals(0,$field->max_value);
		$this->assertEquals(true,$field->disabled);
	}
}
