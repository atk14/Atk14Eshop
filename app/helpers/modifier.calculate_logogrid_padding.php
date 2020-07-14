<?php
/*
 * Calculate padding for logo in logo grid dependent on logo aspect ratio
 */
function smarty_modifier_calculate_logogrid_padding( $base_padding, $ratio ) {
	$multiplier = 1.1;
	if ( $ratio >= 1) {
		$padding = $base_padding / ( $ratio * $multiplier );
	} else {
		$padding = $base_padding * ( $ratio / $multiplier );
	}
	return $padding + 10;
}
