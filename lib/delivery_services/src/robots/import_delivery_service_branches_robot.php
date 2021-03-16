<?php
/**
 * Imports branches for delivery services
 */
class ImportDeliveryServiceBranchesRobot extends ApplicationRobot {

	function run() {
		foreach(DeliveryService::FindAll() as $ds){
			$this->logger->info(sprintf("going to import branches for DeliveryService#%s, code=%s",$ds->getId(),$ds->getCode()));
			$this->logger->flush();
			DeliveryService::UpdateBranches($ds->getCode(),["logger" => $this->logger]);
		}
	}
}
