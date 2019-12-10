<?php
class CreatorRoleField extends ObjectChoiceField {

	function __construct($options = []){
		$options += [
			"initial" => CreatorRole::FindFirst(),
		];

		parent::__construct($options);
	}

}
