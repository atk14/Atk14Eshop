<?php
/**
 *
 * @fixture products
 * @fixture cards 
 */
class TcCustomerReview extends TcBase {

	function test_PrepareTitleForProduct(){
		$this->assertEquals("Product rating",CustomerReview::PrepareTitleForProduct($this->products["arabica"]));
		$this->assertEquals("How satisfied are you with the product?",CustomerReview::PrepareTitleForProduct($this->products["arabica"],["type" => "how_do_you_like"]));
		$this->assertEquals("Write a review for product",CustomerReview::PrepareTitleForProduct($this->products["arabica"],"write_review_for"));

		$this->assertEquals("Product rating",CustomerReview::PrepareTitleForProduct($this->cards["coffee"]));
		$this->assertEquals("How satisfied are you with the product?",CustomerReview::PrepareTitleForProduct($this->cards["coffee"],["type" => "how_do_you_like"]));
		$this->assertEquals("Write a review for product",CustomerReview::PrepareTitleForProduct($this->cards["coffee"],"write_review_for"));

		$book_card = $this->cards["book"];
		$book_card->s("product_type_id",ProductType::GetInstanceByCode("book"));

		$this->assertEquals("Book rating",CustomerReview::PrepareTitleForProduct($this->products["book"]));
		$this->assertEquals("How did you like the book?",CustomerReview::PrepareTitleForProduct($this->products["book"],["type" => "how_do_you_like"]));
		$this->assertEquals("Write a review for book",CustomerReview::PrepareTitleForProduct($this->products["book"],"write_review_for"));

		$this->assertEquals("Book rating",CustomerReview::PrepareTitleForProduct($book_card));
		$this->assertEquals("How did you like the book?",CustomerReview::PrepareTitleForProduct($book_card,["type" => "how_do_you_like"]));
		$this->assertEquals("Write a review for book",CustomerReview::PrepareTitleForProduct($book_card,"write_review_for"));
	}
}
