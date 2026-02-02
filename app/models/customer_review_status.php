<?php
class CustomerReviewStatus extends ApplicationModel implements Translatable, Rankable {

	use TraitObjectStatus;
	use TraitCodebook;

	function getNextAutomaticCustomerReviewStatus(){
		return Cache::Get("CustomerReviewStatus",$this->getNextAutomaticCustomerReviewStatusId());
	}
}
