<?php
/**
 *
 * @fixture products
 * @fixture cards
 * @fixture users
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

	function test_HasCardPublishedReviews(){
		$card = $this->cards["coffee"];
		$product = $this->products["arabica"];

		$this->assertFalse(CustomerReview::HasCardPublishedReviews($card));

		$review = CustomerReview::CreateNewRecord(["product_id" => $product, "user_id" => $this->users["rambo"], "author" => "Test"]);
		$this->assertEquals("new",$review->getStatus()->getCode());
		$this->assertFalse(CustomerReview::HasCardPublishedReviews($card));

		$review->s("body","Great product!");
		$this->assertEquals("published",$review->getStatus()->getCode());
		$this->assertTrue(CustomerReview::HasCardPublishedReviews($card));
	}

	function test_HasCardPublishedReviews_ignores_rejected_reviews(){
		$card = $this->cards["book"];
		$product = $this->products["book"];

		$review = CustomerReview::CreateNewRecord(["product_id" => $product, "user_id" => $this->users["rocky"], "author" => "Test", "body" => "Not good."]);
		$this->assertEquals("published",$review->getStatus()->getCode());

		$review->setNewStatus("rejected");
		$this->assertEquals("rejected",$review->getStatus()->getCode());

		$this->assertFalse(CustomerReview::HasCardPublishedReviews($card));
	}
}
