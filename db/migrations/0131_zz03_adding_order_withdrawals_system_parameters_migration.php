<?php
class Zz03AddingOrderWithdrawalsSystemParametersMigration extends ApplicationMigration {

	function up(){
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		foreach([
			"withdrawal_request_days" => [
				"content" => "14",
				"name_en" => "Deadline for submitting an order withdrawal request",
				"name_cs" => "Lhůta pro podání žádosti o odstoupení od smlouvy",
			],
			"return_goods_days" => [
				"content" => "14",
				"name_en" => "Deadline for returning the goods",
				"name_cs" => "Lhůta pro odeslání vráceného zboží zpět",
			],
			"refund_days" => [
				"content" => "14",
				"name_en" => "Deadline for refunding the payment",
				"name_cs" => "Lhůta pro vrácení peněz",
			],
		] as $key => $values){
			$values += [
				"code" => "orders.withdrawals.$key",
				"system_parameter_type_id" => $type["integer"],
				"mandatory" => true,
			];
			SystemParameter::CreateNewRecord($values);
		}
	}
}
