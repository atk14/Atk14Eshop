<?php
/**
 * Inserts span with space every 10 characters. Useful for easy wraping extra long words
 * like long filenames or urls.
 *
 * To make inserted spaces invisible, make sure that css class .invisible-space
 * has font size set to 0.
 *
 * In a Smarty template:
 * {$longtext|breakable_word}
 *
 */
function smarty_modifier_breakable_word( $input ){
	
	$output = $input;
	$insertion = "<span class=\"invisible-space\"> </span>";

	for( $i = strlen( $input ); $i > 1; $i -= 10 ){
		$output = substr_replace( $output, $insertion, $i, 0 );
	}

	return $output;
}
