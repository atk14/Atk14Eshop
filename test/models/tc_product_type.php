<?php
/**
 *
 * @fixture product_types
 * @fixture cards
 * @fixture products
 * @fixture creators
 * @fixture card_creators
 */
class TcProductType extends TcBase {

	function test(){
		$book = $this->cards["book"];
		$type_book = $this->product_types["book"];

		$this->assertEquals("The Book - John Doe",$type_book->generatePageTitleForProduct($book));

		$creators = CardCreator::GetCreatorsForCard($book);
		$creators[0]->destroy();
		$this->assertEquals("The Book",$type_book->generatePageTitleForProduct($book));

		$type_spare_part = $this->product_types["spare_part"];
		$this->assertEquals("The Book - spare part BOOK",$type_spare_part->generatePageTitleForProduct($book));

	}
}
