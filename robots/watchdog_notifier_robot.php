<?php
class WatchdogNotifierRobot extends ApplicationRobot {

	function run(){
		foreach(WatchedProduct::GetWatchedProductsToNotify() as $watched_product) {
			$user = $watched_product->getUser();
			$product = $watched_product->getProduct();

			$this->logger->info(sprintf("sending notification to user %s about product '%s'", $user, $product));
			$this->mailer->send_watchdog_notification($watched_product);
			$watched_product->markAsNotified();

			$this->dbmole->commit();
			$this->dbmole->begin();
		}
	}
}
