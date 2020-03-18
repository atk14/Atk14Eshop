<?php
class AddingIntegrityKeyToOrdersMigration extends ApplicationMigration {

	function up(){
		$o = new Order();

		if(!$o->hasKey("integrity_key")){
			$this->dbmole->doQuery("
				ALTER TABLE orders ADD integrity_key VARCHAR(255);
				ALTER TABLE orders ADD CONSTRAINT unq_orders_integritykey UNIQUE(integrity_key);
			");
		}
	}
}
