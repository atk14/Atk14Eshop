<?php
/**
 * Makes first character of string uppercase
 */
function smarty_modifier_capitalize($title){
	$title = new String4($title);
	return $title->capitalize()->toString();
}
