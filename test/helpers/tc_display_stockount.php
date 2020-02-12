<?php
/**
 *
 * @fixture products
 * @fixture warehouse_items
 */
class TcDisplayStockount extends TcBase {

	function test(){
		Atk14Require::Helper("function.display_stockcount");

		$smarty = Atk14Utils::GetSmarty();

		$this->assertEquals('<span class="text-success">In stock &gt; 10 pcs</span>',smarty_function_display_stockcount(array("product" => $this->products["green_tea"]),$smarty));
		$this->assertEquals('<span class="text-success">In stock 5 pcs</span>',smarty_function_display_stockcount(array("product" => $this->products["black_tea"]),$smarty));
	}
}
