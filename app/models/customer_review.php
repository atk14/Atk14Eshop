<?php
definedef("CUSTOMER_REVIEWS_AUTOMATIC_PUBLICATION",true);

class CustomerReview extends ApplicationModel {

	const MAX_RATING = 5;

	use TraitObjectWithStatus {
		TraitObjectWithStatus::CreateNewRecord as TraitCreateNewRecord;
	}

	static function CreateNewRecord($values,$options = []){
		global $ATK14_GLOBAL;
		$values += [
			"language" => $ATK14_GLOBAL->getLang(),
		];

		$customer_review = self::TraitCreateNewRecord($values,$options);
		$customer_review->_publishAutomatically();
		return $customer_review;
	}

	/**
	 *
	 *	if(CustomerReview::CanUserReviewProduct($logged_user,$product)){
	 *		// ...
	 * 	}
	 */
	static function CanUserReviewProduct($user,$product){
		if(!$user){ return false; }
		if($product->getCode()==="price_rounding"){ return false; }
		if($user->isAdmin()){ return true; }
		if(CustomerReview::FindFirst("user_id",$user,"product_id",$product)){ return true; }
		$dbmole = self::GetDbmole();
		return 0<$dbmole->selectInt("
			SELECT COUNT(*) FROM
				orders,
				order_items,
				order_statuses
			WHERE
				orders.user_id=:user AND
				order_items.order_id=orders.id AND
				order_items.product_id=:product AND
				order_statuses.id=orders.order_status_id AND
				(
					order_statuses.finishing_successfully OR
					order_statuses.finished_successfully
				)	
		",[
			":user" => $user,
			":product" => $product,
		]);
	}

	/**
	 *
	 */
	static function PrepareTitleForProduct($product,$options = []){
		if(is_string($options)){
			$options = ["type" => $options];
		}
		$options += [
			"type" => "product_rating", // "product_rating", "write_review_for", "how_do_you_like"
		];

		$card = is_a($product,"Product") ? $product->getCard() : $product;
		
		$titles = [
			"product_rating" => _("Product rating"),
			"write_review_for" => _("Write a review for product"),
			"how_do_you_like" => _("How satisfied are you with the product?"),
		];

		if(!$card){ return $title_product_rating; }

		switch($card->getProductType()->getCode()){
			case "book":
			case "ebook":
				$titles["product_rating"] = _("Book rating");
				$titles["write_review_for"] = _("Write a review for book");
				$titles["how_do_you_like"] = _("How did you like the book?");
				break;
		}

		return $titles[$options["type"]];
	}

	function setValues($values,$options = []){
		$ret = parent::setValues($values,$options);
		$this->_publishAutomatically();
		return $ret;
	}

	protected function _publishAutomatically(){
		if(!CUSTOMER_REVIEWS_AUTOMATIC_PUBLICATION){ return false; }
		if($this->getStatus()->getCode()!=="new"){ return false; }
		if(!strlen((string)$this->getBody())){ return false; }

		$this->setNewStatus([
			"customer_review_status_id" => CustomerReviewStatus::GetInstanceByCode("published"),
			"customer_review_status_set_by_user_id" => User::ID_ROBOT,
		]);

		return true;
	}

	static function GetPublishedReviewsByCard(Card $card){
		$products = $card->getProducts();
		if(!$products){ return []; }
		$dbmole = self::GetDbmole();
		$ids = $dbmole->selectIntoArray("
			SELECT id FROM customer_reviews
			WHERE
				product_id IN :products AND
				customer_review_status_id IN (SELECT id FROM customer_review_statuses WHERE finished_successfully) -- AND
				-- body IS NOT NULL
			ORDER BY created_at DESC, id DESC
		",[
			":products" => $products
		]);
		return Cache::Get("CustomerReview",$ids);
	}

	static $RatingCache;

	/**
	 *
	 *	$rating = CustomerReview::GetRatingFor($card);
	 *	$rating = CustomerReview::GetRatingFor($product);
	 */
	static function GetRatingFor($record,&$review_count = null){
		if(!self::$RatingCache){
			self::$RatingCache = new CacheSomething(
				function($ids) {
					$ids += Cache::CachedIds("Card");
					$dbmole = CustomerReview::GetDbmole();
					$rows = $dbmole->selectRows("
						SELECT
							products.card_id,
							SUM(rating) AS sum_rating,
							COUNT(*) AS review_count
						FROM
							products,
							customer_reviews
						WHERE
							products.card_id IN :cards AND
							customer_reviews.product_id=products.id AND
							customer_reviews.rating IS NOT NULL
						GROUP BY products.card_id
						",
						[":cards" => $ids]
					);
					$out = array_fill_keys($ids, [null,0]);
					foreach($rows as $row){
						$review_count = (int)$row["review_count"];
						$rating = round($row["sum_rating"] / $review_count,1);
						$id = $row["card_id"];
						$out[$id] = [$rating,$review_count];
					}
					return $out;
				}
			);
		}

		$card = is_a($record,"Product") ? $record->getCard() : $record;

		list($rating,$review_count) = self::$RatingCache->get($card);
		return $rating;
	}

	static function GetStarRowsFor($record){
		$card = is_a($record,"Product") ? $record->getCard() : $record;

		$out = [];
		for($i=1;$i<=self::MAX_RATING;$i++){
			$out[] = new CustomerReviewStarRow($i,0,0.0);
		}

		$dbmole = self::GetDbmole();
		$rows = $dbmole->selectRows("
				SELECT
					customer_reviews.rating,
					COUNT(*) AS review_count
				FROM
					products,
					customer_reviews
				WHERE
					products.card_id=:card AND
					customer_reviews.product_id=products.id AND
					customer_reviews.rating IS NOT NULL
				GROUP BY customer_reviews.rating
			",
			[":card" => $card]
		);

		$total_star_count = 0;
		foreach($rows as $row){ $total_star_count += $row["review_count"]; }

		foreach($rows as $row){
			$stars = (int)$row["rating"];
			$star_count = (int)$row["review_count"];
			$percentage = round($star_count / ($total_star_count / 100.0),2);
			$k = $stars-1;
			$out[$k] = new CustomerReviewStarRow($stars,$star_count,$percentage);
		}

		return array_reverse($out);
	}

	static function BuildLinkForOrderItem(OrderItem $order_item){
		return Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "customer_reviews",
			"action" => "create_new",
			"order_item_token" => $order_item->getToken("customer_review_salt"),
		],[
			"with_hostname" => true,
		]);
	}

	function isPublished(){
		return $this->getStatus()->getCode()==="published";
	}
}
