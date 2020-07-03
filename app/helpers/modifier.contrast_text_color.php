<?php
/**
 * Finds suitable text color with sufficient contrast compared to $color
 * Known bug - named colors 6 or 3 chars long like "violet" or "red" are detected as white
 * 
 * $color: original color (typically background). Does not consider alpha values.
 * $dark, $light = colors (or CSS class names etc. when suitable) of dark and light text to be returned
 * $threshold - luminance threshold 0-255, should be 127 but 160 usually looks better
 *
 * {"#ff0000"|contrast_text_color}
 * {"#ff0000"|contrast_text_color:"#000000":"#ffffff":125}
 * {"#ff0000"|contrast_text_color:"text-dark":"text-light"} // to return class names rather than colors
 * {"hsla(120,60%,70%,0.3)"|contrast_text_color} // any css color format accepted
 * {"hotpink"|contrast_text_color} // any css color format accepted
 */
function smarty_modifier_contrast_text_color( $color, $dark = "#000000", $light = "#FFFFFF", $threshold = 160 ){
	if(!$color){
		return $dark;
	}
	$color_object = ariColor::newColor( $color );
	return ( $threshold < $color_object->luminance ) ? $dark : $light;
}
