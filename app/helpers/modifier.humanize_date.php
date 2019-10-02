<?php
function smarty_modifier_humanize_date($date){
	if(!$date){
		return;
	}

	$now = time();
	$time = strtotime($date);
	$delta = $now - $time;
	
	if($delta>=0){
		if($delta<=30){
			return _("právě teď");
		}
		if($delta<=90){
			return _("před minutou");
		}

		$minutes = round($delta / 60);
		if($minutes<=50){
			return sprintf(_("před %s minutama"),$minutes);
		}

		$hours = round($delta / (60 * 60));

		if($hours==1){
			return _("před hodinou");
		}

		if($hours<=48){
			return sprintf(_("před %s hodinama"),$hours);
		}
	}

	Atk14Require::Helper("modifier.format_datetime");
	return smarty_modifier_format_datetime($date);
}
