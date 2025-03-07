<?php
function smarty_modifier_rand($min = 0, $max = null){
	if(is_null($max)){ $max = getrandmax(); }
	$min = (int)$min;
	$max = (int)$max;
	return mt_rand($min,$max);
}
