<?php
class CampaignField extends ChoiceField {

	function __construct($options = []){
		$choices = ["" => ""];
		foreach(Campaign::FindAll(["order_by" => "active DESC, (valid_from IS NULL OR valid_from<NOW()) DESC, (valid_to IS NULL OR valid_to>NOW()) DESC"]) as $c){
			$choices[$c->getId()] = $c->getName()." (".join(", ",$c->getRegions()).")";
		}

		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
