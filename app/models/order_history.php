<?php
class OrderHistory extends ApplicationModel {

	function __construct($table_name="order_history", $options=array()) {
		return parent::__construct($table_name, $options);
	}

	/**
	 * V podstate created_by_user_id, ale prenasi se z modelu Order,
	 * takze se jmenuje stejne....
	 */
	function getOrderStatusSetByUser() {
		return User::FindFirstById($this->g("order_status_set_by_user_id"));
	}

	/*
	 * Zpracovatel - ten kdo ma latku nastrihat
   */
	function getResponsiblePerson() {
		return User::FindFirstById($this->g("responsible_user_id"));
	}

	function getOrderStatus(){
		return Cache::Get("OrderStatus",$this->getOrderStatusId());
	}

	/*
	 * Vrátí následující položku historie objednávky
	 */
	function getNext() {
		return OrderHistory::GetInstanceById($this->dbmole->selectSingleValue(
				"SELECT id FROM order_history WHERE
					order_id = :oid AND
					( order_status_set_at > :set_at OR
					order_status_set_at = :set_at AND id > :id)
					order by order_status_set_at, id
					limit 1
				",
		[ ':oid' => $this->getOrderId(),
			':set_at' => $this->getOrderStatusSetAt(),
			':id' => $this->getId() ]));
	}

	/*
	 * Vrátí předchozí položku historie objednávky
	 */
	function getPrevious() {
		return OrderHistory::GetInstanceById($this->dbmole->selectSingleValue(
				"SELECT id FROM order_history WHERE
					order_id = :oid AND
					( order_status_set_at < :set_at OR
					order_status_set_at = :set_at AND id < :id)
					order by order_status_set_at desc, id desc
					limit 1
				 ",
		[ ':oid' => $this->getOrderId(),
			':set_at' => $this->getOrderStatusSetAt(),
			':id' => $this->getId() ]));
	}

}
