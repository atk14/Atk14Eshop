<?php
class WatchdogNotifierRobot extends ApplicationRobot {

	function run(){
		foreach(WatchedProduct::GetWatchedProductsToNotify() as $watched_product) {
			$user = $watched_product->getUser();
			$product = $watched_product->getProduct();

			$this->logger->info(sprintf("WatchedProduct#%s: sending notification to %s about product %s (%s)", $watched_product->getId(), $user ? "User#{$user->getId()} ($user)" : "anonymous user", $product->getCatalogId(), $product));
			$this->mailer->send_watchdog_notification($watched_product);
			$watched_product->markAsNotified();

			$this->dbmole->commit();
			$this->dbmole->begin();
		}
	}
}
