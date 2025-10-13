<?php
/**
 *
 * @fixture sliders
 * @fixture slider_items
 */
class TcSliderItem extends TcBase {

	function test_isVisible(){
		$time = time();
		$item = $this->slider_items["promo__first"];

		$item->s([
			"visible" => true,
			"display_from" => null,
			"display_to" => null,
		]);
		$this->assertTrue($item->isVisible());

		$item->s([
			"visible" => true,
			"display_from" => date("Y-m-d H:i:s",$time - 60),
			"display_to" => date("Y-m-d H:i:s",$time + 60),
		]);
		$this->assertTrue($item->isVisible());

		$item->s([
			"visible" => true,
			"display_from" => null,
			"display_to" => date("Y-m-d H:i:s",$time + 60),
		]);
		$this->assertTrue($item->isVisible());

		$item->s([
			"visible" => true,
			"display_from" => date("Y-m-d H:i:s",$time - 60),
			"display_to" => null,
		]);
		$this->assertTrue($item->isVisible());

		$item->s([
			"visible" => true,
			"display_from" => date("Y-m-d H:i:s",$time - 60),
			"display_to" => date("Y-m-d H:i:s",$time - 30),
		]);
		$this->assertFalse($item->isVisible());

		$item->s([
			"visible" => true,
			"display_from" => date("Y-m-d H:i:s",$time + 30),
			"display_to" => date("Y-m-d H:i:s",$time + 60),
		]);
		$this->assertFalse($item->isVisible());

		$item->s([
			"visible" => false,
			"display_from" => date("Y-m-d H:i:s",$time - 60),
			"display_to" => date("Y-m-d H:i:s",$time + 60),
		]);
		$this->assertFalse($item->isVisible());
	}
}
