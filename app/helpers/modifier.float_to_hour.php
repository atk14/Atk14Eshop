<?php
/**
 * For examples see test/helpers/tc_float_to_hour.php
 */
function smarty_modifier_float_to_hour($float,$format = "H:i"){
	if(!isset($float) || (string)$float===""){ return ""; }
	$float = (float)$float;
	$hour = floor($float);
	$zbytek = $float - $hour;
	$minutes = floor($zbytek * 60);
	$seconds = round((($zbytek * 60) - $minutes) * 60);

	return strtr($format,array(
		"H" => $hour,
		"i" => sprintf('%02d',$minutes),
		"s" => sprintf('%02d',$seconds)
	));
}
