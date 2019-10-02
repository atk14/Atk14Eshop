<?php
/**
 * Converts color in hexa form into rgba notation with the given alpha value
 *
 *	{"#ff0000"|color_to_rgba:"0.5"} -> rgba(255,0,0,0.5)
 */
function smarty_modifier_color_to_rgba($color,$alpha = "1.0"){
	if(!$color){
		return;
	}
	$h = '[0-9a-fA-F]';
	if(preg_match("/^#?($h{2})($h{2})($h{2})$/",$color,$matches)){
		$r = hexdec($matches[1]);
		$g = hexdec($matches[2]);
		$b = hexdec($matches[3]);
		return "rgba($r,$g,$b,$alpha)";
	}
}
