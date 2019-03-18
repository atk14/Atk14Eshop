<?php
class OrderCampaign extends ApplicationModel implements Rankable {

	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->getOrderId(),
		]);
	}

	function getCampaign(){
		return Cache::Get("Campaign",$this->g("campaign_id"));
	}

	function getName(){
		return $this->getCampaign()->getName();
	}

	function createdAdministratively(){
		return $this->g("created_administratively");
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	function toString(){
		return (string)$this->getName();
	}
}
