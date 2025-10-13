<?php
class OrderQuantityField extends IntegerField {

	protected $step = null;

	function __construct($product,$options = []){
		$unit = $product->getUnit();

		$min_value = $product->getCalculatedMinimumQuantityToOrder();
		$max_value = $product->getCalculatedMaximumQuantityToOrder();
		$initial = $product->getCalculatedStandardQuantityToOrder();
		$disabled = false;
		if($max_value===0){
			$min_value = 0;
			$initial = 0;
			$disabled = true;
		}
		$step = $product->getOrderQuantityStep();

		$options += [
			"min_value" => $min_value,
			"max_value" => $max_value,
			"step" => $step,
			"initial" => $initial,
			"disabled" => $disabled,
		];

		$options["min_value"] = ceil($options["min_value"] / $step) * $step; // pokud bude $options["min_value"] 12 a $step=10, tak se tady $options["min_value"] zmeni na 20
		if(isset($options["max_value"])){
			$options["max_value"] = floor($options["max_value"] / $step) * $step; // pokud bude $options["max_value"] 202 a $step=10, tak se tady $options["max_value"] zmeni na 200
		}

		/*
		if(isset($options["initial"])){
			$options["initial"] = ceil($options["initial"] / $step) * $step;
			if($options["initial"]<$options["min_value"]){
				$options["initial"] = $options["min_value"];
			}
		}
		*/

		$options += [
			"widget" => new OrderQuantityInput([
				"unit" => $unit,
				"attrs" => [
					"step" => $options["step"],
					"min" => $options["min_value"],
					"max" => $options["max_value"],
				],
			])
		];

		$this->step = $options["step"];

		parent::__construct($options);
	}

	function clean($value){
		list($err,$value) = parent::clean($value);

		if(!is_null($err) || is_null($value)){
			return [$err,null];
		}

		if(($value%$this->step)!==0){
			$err = sprintf(_("Zadaný počet musí být dělitelný číslem %d"),$this->step);
			return [$err,null];
		}

		

		return [$err,$value];
	}
}
