<?php
class WatchedProduct extends ApplicationModel {

	// delay before scheduling the first notification once a product becomes available again
	public static $NOTIFICATION_DELAY_MINUTES = 0;

	// gap between notifying successive watchers of the same product, in creation order
	public static $NOTIFICATION_STAGGER_MINUTES = 0;

	// how many watchers get staggered notifications before the rest get notified all at once; 0 = no limit
	public static $NOTIFICATION_STAGGER_LIMIT = 0;

	static function CreateNewRecord($values,$options = []){
		global $ATK14_GLOBAL;

		$values += [
			"language" => $ATK14_GLOBAL->getLang(),
		];

		return parent::CreateNewRecord($values,$options);
	}

	static function IsWatchedProduct($product,$user){
		if(is_null($user)){
			return null;
		}
		return self::FindFirst("product_id",$product,"user_id",$user,"notified",false);
	}

	/**
	 * Conditions matching watched products whose product is currently available to be notified about
	 * (in stock, visible, not deleted).
	 */
	protected static function _GetAvailabilityConditions(){
		return [
			"COALESCE((SELECT SUM(stockcount) FROM warehouse_items WHERE product_id=watched_products.product_id AND warehouse_id IN (SELECT id FROM warehouses WHERE applicable_to_eshop)),0)-(COALESCE((SELECT SUM(stockcount) FROM v_stockcount_blocations WHERE product_id=watched_products.product_id),0))>0",
			"(SELECT visible FROM products WHERE products.id=watched_products.product_id)",
			"NOT (SELECT deleted FROM products WHERE products.id=watched_products.product_id)",
		];
	}

	/**
	 * Schedules notify_at for watched products of currently available products that aren't scheduled yet.
	 *
	 * Watchers of the same product are ranked by created_at (first interested, first notified); the first
	 * NOTIFICATION_STAGGER_LIMIT of them get notify_at staggered NOTIFICATION_STAGGER_MINUTES apart (on top of
	 * the initial NOTIFICATION_DELAY_MINUTES delay), anything beyond that limit gets the same notify_at as the
	 * last staggered position. Watchers that already have a notify_at set are left untouched, but still count
	 * towards the rank so later-created watchers are queued after them.
	 */
	static function ScheduleNotifications(){
		$conditions = array_merge(
			["watched_products.notified='f'"],
			self::_GetAvailabilityConditions()
		);

		$watched_products = self::FindAll([
			"conditions" => $conditions,
			"order_by" => "product_id, created_at, id",
		]);

		$stagger_limit = self::$NOTIFICATION_STAGGER_LIMIT ?: null; // null = no limit

		$ranks = []; // product_id => count of watchers seen so far
		foreach($watched_products as $watched_product){
			$product_id = $watched_product->getProductId();
			$rank = ($ranks[$product_id] = ($ranks[$product_id] ?? 0) + 1);

			if(!is_null($watched_product->g("notify_at"))){
				continue; // already scheduled, only counted for ranking purposes
			}

			$effective_rank = $stagger_limit ? min($rank,$stagger_limit) : $rank;
			$offset_minutes = self::$NOTIFICATION_DELAY_MINUTES + ($effective_rank - 1) * self::$NOTIFICATION_STAGGER_MINUTES;

			$watched_product->setValues([
				"notify_at" => date("Y-m-d H:i:s",strtotime("+$offset_minutes minutes")),
			]);
		}
	}

	/**
	 * Cancels notify_at for watched products whose product stopped being available again before the
	 * scheduled notification was sent (e.g. it was moved out of the eshop warehouse in the meantime).
	 * The watcher stays in the queue and gets a fresh notify_at next time the product becomes available.
	 */
	static function CancelStaleSchedules(){
		$conditions = [
			"watched_products.notified='f'",
			"watched_products.notify_at IS NOT NULL",
			"NOT (".join(") AND (",self::_GetAvailabilityConditions()).")",
		];

		foreach(self::FindAll(["conditions" => $conditions]) as $watched_product){
			$watched_product->setValues(["notify_at" => null]);
		}
	}

	static function GetWatchedProductsToNotify(){
		$conditions = array_merge(
			[
				"watched_products.notified='f'",
				"watched_products.notify_at IS NOT NULL",
				"watched_products.notify_at<=:now",
			],
			self::_GetAvailabilityConditions()
		);

		return self::FindAll([
			"conditions" => $conditions,
			"bind_ar" => [":now" => now()],
		]);
	}

	function getUser(){
		return Cache::Get("User",$this->getUserId());
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}

	function getEmail(){
		if(strlen($this->g("email"))){
			return $this->g("email");
		}
		if($user = $this->getUser()){
			return $user->getEmail();
		}
	}

	function notified(){
		return $this->g("notified");
	}

	function markAsNotified() {
		$this->setValues([
			"notified" => true,
			"notified_at" => now(),
		]);
	}
}
