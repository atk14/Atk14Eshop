<?php
Atk14Require::Helper("modifier.format_number");
function smarty_modifier_display_amount($amount,$unit){
	return sprintf(
		"%s %s",
		smarty_modifier_format_number(
			($amount / $unit->getDisplayUnitMultiplier()),
			$unit->getDisplayQuantityPrecision()
		),
		$unit->getDisplayUnitLocalized()
	);
}
