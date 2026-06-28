<?php
class OrderWithdrawalRequest extends ApplicationModel {

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
			if(!$processed && in_array($order_status->getCode(),[
				"processed",
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

	static function ReasonsOfOrderReturningChoices(){
		return [
			"unsatisfactory_pattern" => _("Nevyhovující barva / vzor"),
			"pattern_mismatch_photo" => _("Barva / vzor neodpovídá fotografii produktu"),
			"unsatisfactory_material" => _("Nevyhovující materiál"),
			"other" => _("Další / jiný důvod k vrácení")
		];
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
