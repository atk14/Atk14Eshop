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
		if($this->hasKey("notification_enabled")){
			return $this->g("notification_enabled");
		}
		return false;
	}

	function getBccEmail(){
		if($this->hasKey("bcc_email")){
			return $this->g("bcc_email");
		}
		return null;
	}

	function finishedSuccessfully(){
		return $this->g("finished_successfully");
	}

	function finishedUnsuccessfully(){
		return $this->g("finished_unsuccessfully");
	}

	function isFinishingSuccessfully(){
		return $this->hasKey("finishing_successfully") ? $this->g("finishing_successfully") : false;
	}

	function isFinishingUnsuccessfully(){
		return $this->hasKey("finishing_unsuccessfully") ? $this->g("finishing_unsuccessfully") : false;
	}
}
