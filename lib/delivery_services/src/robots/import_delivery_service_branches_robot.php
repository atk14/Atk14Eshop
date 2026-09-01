<?php
/**
 * Imports branches for delivery services
 *
 * All delivery services (default country CZ):
 *
 * ./scripts/robot_runner import_delivery_service_branches
 *
 * Only selected delivery services:
 *
 * ./scripts/robot_runner import_delivery_service_branches gls zasilkovna
 *
 * With a specific country code:
 *
 * ./scripts/robot_runner import_delivery_service_branches gls --country_code=sk
 */
class ImportDeliveryServiceBranchesRobot extends ApplicationRobot {

	function run() {
		global $argv;

		ini_set("memory_limit", "600M");

		array_shift($argv);
		array_shift($argv);

		$required = [];
		$country_code = "cz";
		while($arg = array_shift($argv)) {
			if (preg_match('/^--country_code=(.+)$/', $arg, $m)) {
				$country_code = $m[1];
			} else {
				$required[] = $arg;
			}
		}

		$force_import = false;

		if ($required) {
			$service_codes = $required;
			$force_import = true;
		} else {
			$service_codes = $this->dbmole->selectIntoArray("SELECT code FROM delivery_services");
		}

		foreach($service_codes as $code){
			$ds = DeliveryService::FindFirst("code", $code);
			if (!$ds) {
				$this->logger->error(sprintf("Delivery service not found for code", $code));
				continue;
			}

			$this->logger->info(sprintf("going to import branches for DeliveryService#%s, code=%s, country_code=%s", $ds->getId(), $ds->getCode(), $country_code));
			$this->logger->flush();
			DeliveryService::UpdateBranches($ds->getCode(), ["logger" => $this->logger, "force_import" => $force_import, "country_code" => $country_code]);
		}
	}
}
