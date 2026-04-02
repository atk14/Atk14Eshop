<?php
class LocalVatNumberField extends RegexField {

	function __construct($options = []){
		// https://slovenskedane.cz/blog/slovenske-ico-dic-a-ic-dph-co-jsou-to-za-cisla-a-jak-jim-rozumet/
		// Na Slovensku mají podnikatelé DIČ vždy odlišné od jejich IČO čísla. DIČ je zde desetimístné číslo, začínající číslicemi 10, 20 nebo 40. Fyzické osoby mají na začátku číslovku 10, právnické osoby (eseróčka, akciovky) číslici 20 a zahraniční subjekty registrované v SR číslovku 40.
		parent::__construct('/(10|20|40)\d{8}/',$options);
	}

	function clean($value){
		$value = (string)$value;
		$value = trim($value);
		$value = preg_replace('/\s/','',$value); // "203 456 789 0" -> "2034567890"

		return parent::clean($value);
	}
}
