<?php
trait TraitStatusHistoryItem {

	function __construct(){
		list($prefix) = $this->_getNames();
		parent::__construct("{$prefix}_history");
	}

	/**
	 * V podstate created_by_user_id, ale prenasi se z modelu Claim,
	 * takze se jmenuje stejne....
	 */
	function getStatusSetByUser(){
		list($prefix) = $this->_getNames();
		return Cache::Get("User",$this->g("{$prefix}_status_set_by_user_id"));
	}
	
	/*
	 * Vrátí následující položku historie objednávky
	 */
	function getNext() {
		list($prefix) = $this->_getNames();
		return self::GetInstanceById($this->dbmole->selectSingleValue(
				"SELECT id FROM {$prefix}_history WHERE
					{$prefix}_id = :oid AND
					( {$prefix}_status_set_at > :set_at OR
					{$prefix}_status_set_at = :set_at AND id > :id)
					order by {$prefix}_status_set_at, id
					limit 1
				",
		[ ':oid' => $this->g("{$prefix}_id"),
			':set_at' => $this->g("{$prefix}_status_set_at"),
			':id' => $this->getId() ]));
	}

	/*
	 * Vrátí předchozí položku historie objednávky
	 */
	function getPrevious() {
		list($prefix) = $this->_getNames();
		return self::GetInstanceById($this->dbmole->selectSingleValue(
				"SELECT id FROM {$prefix}_history WHERE
					{$prefix}_id = :oid AND
					( {$prefix}_status_set_at < :set_at OR
					{$prefix}_status_set_at = :set_at AND id < :id)
					order by {$prefix}_status_set_at desc, id desc
					limit 1
				 ",
		[ ':oid' => $this->g("{$prefix}_id"),
			':set_at' => $this->g("{$prefix}_status_set_at"),
			':id' => $this->getId() ]));
	}

	protected function _getNames(){
		$history_class_name = get_class($this); // "OrderHistory", "ClaimHistory", "SaleRegistrationHistory"
		$subject_class_name = String4::ToObject($history_class_name)->gsub('/History$/','')->toString();
		$prefix = String4::ToObject($history_class_name)->underscore()->gsub('/_history$/','')->toString(); // "order", "claim", "sale_registration"
		return [$prefix,$subject_class_name,$history_class_name];
	}

	function __call($name,$arguments){
		list($prefix,$subject_class_name) = $this->_getNames();
		if($name === "get{$subject_class_name}StatusSetByUser") { // "getOrderStatusSetByUser", "getClaimStatusSetByUser", "getSaleRegistrationStatusSetByUser"
			return $this->getStatusSetByUser();
		}
		return parent::__call($name,$arguments);
	}
}
