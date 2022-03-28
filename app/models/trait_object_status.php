<?php
/**
 *
 *	class ClaimStatus extends ApplicationModel implements TraitObjectStatus, Rankable {
 *		use TraitObjectStatus;
 *		use TraitCodebook;
 *	}
 */
trait TraitObjectStatus {

	static function GetTranslatableFields() {
		return array("name");
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function toString() {
		return (string)$this->getName();
	}

	function notificationEnabled(){
		// pro toto chybi v db policka
		return false;
	}

	function finishedSuccessfully(){
		return $this->g("finished_successfully");
	}

	function finishedUnsuccessfully(){
		return $this->g("finished_unsuccessfully");
	}
}
