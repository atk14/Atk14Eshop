<?php
class OrderWithdrawalRequest extends ApplicationModel {

	public static $REASONS = [];

	use TraitObjectWithStatus {
		TraitObjectWithStatus::CreateNewRecord as TraitCreateNewRecord;
	}

	static function CreateNewRecord($values,$options = []){
		global $ATK14_GLOBAL;
		$values += [
			"language" => $ATK14_GLOBAL->getLang(),
		];

		return self::TraitCreateNewRecord($values,$options);
	}

	static function CanOrderBeWithdrawn($order,&$reason = ""){
		$reason = "";

		$delivery_method = $order->getDeliveryMethod();

		$date = null;
		$processed_date = null;
		$delivered_date = null;

		foreach($order->getOrderHistory(["reverse" => false]) as $item){
			$order_status = $item->getOrderStatus();
			if(!$processed_date && in_array($order_status->getCode(),[
				"processed",
				"ready_for_pickup",
				"shipped",
				"delivered",
				"finished_successfully",
			])){
				$processed_date = $item->getOrderStatusSetAt();
			}
			if($order_status->getCode()==="delivered"){
				$delivered_date = $item->getOrderStatusSetAt();
			}
			if(in_array($order_status->getCode(),[
				"ready",
				"ready_reminder",
				"ready_for_pickup",
				"shipped",
				"delivered",
				"processed",
				"finished_successfully",
			])){
				$date = $item->getOrderStatusSetAt();
			}
		}

		$max_days = 14;
		$some_more_days = 7;

		if(!$processed_date && !$delivered_date){
			$reason = _("Objednávka doposud nebyla zpracována.");
			return false;
		}

		if($delivered_date && $delivery_method->personalPickup()){
			$date = $delivered_date;
			$some_more_days = 0;
		}

		if($processed_date && !$delivery_method->personalPickup()){
			$date = $processed_date;
			$some_more_days = 7;
		}

		if(!$date){
			$date = $order->getCreatedAt(); 
		}

		$today = Date::Today();
		$date = Date::ByDate($date);

		$days = $today->daysFrom($date); // 0 if the dates are the same

		if($days>($max_days + $some_more_days)){
			$reason = _("Objednávku již není možné vrátit.");
			return false;
		}

		// TODO: doplnit kontrolu

		return true;	
	}

	static function ReasonsOfOrderReturningChoices($active_choices_only = false){
		$out = self::$REASONS;

		// Filtering out inactive choices
		if($active_choices_only){
			$out = array_filter($out,function($item){ return $item["active"]; });
		}

		// Stringify
		$out = array_map(function($item){ return $item["title"]; },$out);

		return $out;
	}

	static function PlacedFor($order){
		return OrderWithdrawalRequest::FindFirst("order_id",$order,["order_by" => "created_at DESC, id DESC"]);
	}

	function getReasons(){
		$json = $this->g("reasons");
		if(!$json){ return; }
		$choices = self::ReasonsOfOrderReturningChoices();
		$out = [];
		foreach(json_decode($json,true) as $k){
			$out[$k] = $choices[$k];
		}
		return $out;
	}

	function getItems(){
		return OrderWithdrawalRequestItem::FindAll("order_withdrawal_request_id",$this);
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}
}

OrderWithdrawalRequest::$REASONS = [
	"no_reason_given" => [
		"title" => _("Odstoupení od smlouvy bez udání důvodu"),
		"active" => true,
	],
	"unsatisfactory_pattern" => [
		"title" => _("Nevyhovující barva / vzor"),
		"active" => true,
	],
	"pattern_mismatch_photo" => [
		"title" => _("Barva / vzor neodpovídá fotografii produktu"),
		"active" => true,
	],
	"unsatisfactory_material" => [
		"title" => _("Nevyhovující materiál"),
		"active" => true,
	],
	"other" => [
		"title" => _("Další / jiný důvod k vrácení"),
		"active" => true,
	],
];
