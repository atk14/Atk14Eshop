<?php
/**
 * Converts color in HEX, HEXA, RGB or RGBA form into rgba notation with the given alpha value
 *
 *	{"#ff0000"|color_to_rgba:"0.5"} -> rgba(255,0,0,0.5)
 *	{"rgb(100, 150, 170)"|color_to_rgba} -> rgba(100,150,170,1.0)
 */
function smarty_modifier_color_to_rgba($color,$alpha = "1.0"){
	if(!$color){
		return;
	}

	$color = preg_replace('/\s/','',$color);
	$color = strtolower($color);

	$r = $g = $b = null;

	$h = '[0-9a-f]';
	$d = '[0-9\.]+';
	if(preg_match("/^#?($h{1})($h{1})($h{1})$/",$color,$matches)){
		$r = hexdec($matches[1].$matches[1]);
		$g = hexdec($matches[2].$matches[2]);
		$b = hexdec($matches[3].$matches[3]);
	}elseif(preg_match("/^#?($h{2})($h{2})($h{2})($h{2}|)$/",$color,$matches)){
		$r = hexdec($matches[1]);
		$g = hexdec($matches[2]);
		$b = hexdec($matches[3]);
	}elseif(
		preg_match("/^rgb\((?P<r>$d),(?P<g>$d),(?P<b>$d)\)$/",$color,$matches) ||
		preg_match("/^rgba\((?P<r>$d),(?P<g>$d),(?P<b>$d),$d\)$/",$color,$matches)
	){
		$r = $matches["r"];
		$g = $matches["g"];
		$b = $matches["b"];
	}

	if(isset($r)){
		$r = (float)$r;
		$b = (float)$b;
		$g = (float)$g;
		return "rgba($r,$g,$b,$alpha)";
	}
}
