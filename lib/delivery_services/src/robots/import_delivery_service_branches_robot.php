<?php
/**
 * Import informaci o dorucovacich mistech
 *
 * ./scripts/robot_runner import_post_offices [filename]
 *
 * Kdyz neni zadan nazev souboru, stahne se aktualni verze z webu ( viz. $options["data_url"] )
 */
class ImportDeliveryServiceBranchesRobot extends ApplicationRobot {
	function run() {
		DeliveryService::UpdateBranches("zasilkovna", ["logger" => $this->logger]);
		DeliveryService::UpdateBranches("cp-balik-na-postu", ["logger" => $this->logger]);
		DeliveryService::UpdateBranches("cp-balikovna", ["logger" => $this->logger]);
	}
}
