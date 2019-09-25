<?php
defined("NBSP") || define("NBSP",html_entity_decode("&nbsp;"));

/**
 *
 *	{3|display_number} -> 3
 *	{1001|display_number} -> 1 001
 *	{1001.23|display_number} -> 1 001,23
 *	{"1.00"|display_number} -> 1,00
 */
function smarty_modifier_display_number($number){
	$out = Atk14Locale::FormatNumber($number);
	$out = str_replace(" ",NBSP,$out);
	return $out;
}
