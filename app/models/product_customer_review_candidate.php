<?php
class ProductCustomerReviewCandidate {

	protected $user;
	protected $product;
	protected $order_item;

	protected function __construct($order_item){
		$order = $order_item->getOrder();
		$this->user = $order->getUser();
		$this->product = $order_item->getProduct();
		$this->order_item = $order_item;
	}

	static function GetInstancesByUser(User $user){
		$out = [];

		$dbmole = CustomerReview::GetDbmole();
		$order_items = Cache::Get("OrderItem",$dbmole->selectIntoArray("
			SELECT
				order_items.id
			FROM
				order_items,
				orders,
				order_statuses
			WHERE
				orders.user_id=:user AND
				order_items.order_id=orders.id AND
				order_items.product_id!=(SELECT id FROM products WHERE code='price_rounding') AND
				order_statuses.id=orders.order_status_id AND
				(
					order_statuses.finishing_successfully OR
					order_statuses.finished_successfully
				) AND
				order_items.product_id NOT IN (SELECT product_id FROM customer_reviews WHERE user_id=:user)	
			ORDER BY
				orders.created_at DESC,
				order_items.rank,
				order_items.id
		",[
			":user" => $user,
		]));
		foreach($order_items as $order_item){
			$k = $order_item->getProductId();
			if(isset($out[$k])){ continue; }
			$out[$k] = new self($order_item);
		}
		$out = array_values($out);
		
		return $out;
	}

	function getProduct(){
		return $this->product;
	}

	function getOrderItem(){
		return $this->order_item;
	}

	function getPurchasedAt(){
		return $this->order_item->getOrder()->getCreatedAt();
	}

	function getCreateUrl(){
		$user = $this->order_item->getOrder()->getUser();
		if($user){
			return Atk14Url::BuildLink([
				"namespace" => "",
				"controller" => "customer_reviews",
				"action" => "create_new",
				"product_id" => $this->order_item->getProductId(),
			],[
				"with_hostname" => true,
			]);
		}
		return CustomerReview::BuildLinkForOrderItem($this->order_item);
	}
}
