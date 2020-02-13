<?php
/**
 *
 * @fixture sliders
 * @fixture slider_items
 */
class TcSlider extends TcBase {

	function test(){
		$promo = $this->sliders["promo"];

		$items = $promo->getItems();
		$this->assertEquals(3,sizeof($items));
		$this->assertEquals("First",$items[0]->getTitle());
		$this->assertEquals("Second",$items[1]->getTitle());
		$this->assertEquals("Third",$items[2]->getTitle());

		$items = $promo->getVisibleItems();
		$this->assertEquals(2,sizeof($items));
		$this->assertEquals("First",$items[0]->getTitle());
		$this->assertEquals("Third",$items[1]->getTitle());
	}
}
