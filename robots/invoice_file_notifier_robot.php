<?php
class InvoiceFileNotifierRobot extends ApplicationRobot {

	function run(){
		foreach(InvoiceFile::FindAll("notified",false) as $invoice){
			$this->dbmole->begin();
			$invoice->s([
				"notified" => true,
				"notified_at" => now(),
			]);
			$this->mailer->notify_invoice_file($invoice);
			$this->dbmole->commit();
		}
	}
}
