<?php
/**
 * Choice fild with list of administrators
 *
 *	new AdminField();
 *	new AdminField(["user_required" => $user_required_to_be_in_list]); // even when the user is not administrator
 *
 */
class AdminField extends ObjectChoiceField {

	function __construct($options = []){
		$options += [
			"class_name" => "User",
			"order_by" => "UPPER(COALESCE(firstname,'')||' '||COALESCE(lastname,'')||' '||login)",
			"user_required" => null,
			"empty_choice_text" => "-- "._("select administrator")." --",
			"value_formatter" => function($user){
				return sprintf("%s (%s)",$user->getName(),$user->getLogin());
			}
		];

		if(isset($options["user_required"])){
			$options["conditions"] = ["is_admin OR id=:user_required"];
			$options["bind_ar"] = [":user_required" => $options["user_required"]];
		}else{
			$options["conditions"] = ["is_admin"];
			$options["bind_ar"] = [];
		}

		parent::__construct($options);
	}
}
