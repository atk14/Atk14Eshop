<?php
/**
 * Imports branches for delivery services
 *
 * All delivery services
 *
 * ./scripts/robot_runner import_delivery_service_branches
 *
 * Only selected delivery services, just put codes as robot parameters
 *
 * ./scripts/robot_runner import_delivery_service_branches gls zasilkovna
 */
class ImportDeliveryServiceBranchesRobot extends ApplicationRobot {

	function run() {
		global $argv;

		array_shift($argv);
		array_shift($argv);

		while($code = array_shift($argv)) {
			$required[] = $code;
		}

		if ($required) {
			$service_codes = $required;
		} else {
			$service_codes = $this->dbmole->selectIntoArray("SELECT code FROM delivery_services");
		}

		foreach($service_codes as $code){
			$ds = DeliveryService::FindFirst("code", $code);
			if (!$ds) {
				$this->logger->error(sprintf("Delivery service not found for code", $code));
				continue;
			}

			$this->logger->info(sprintf("going to import branches for DeliveryService#%s, code=%s",$ds->getId(),$ds->getCode()));
			$this->logger->flush();
			DeliveryService::UpdateBranches($ds->getCode(),["logger" => $this->logger]);
		}
	}
}
