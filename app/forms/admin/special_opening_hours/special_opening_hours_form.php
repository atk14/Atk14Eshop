<?php
class SpecialOpeningHoursForm extends AdminForm {

	function set_up(){
		$this->add_field("date", new DateField([
			"label" => _("Datum"),
			"hint" => Atk14Locale::FormatDate(now()),
		]));

		$this->add_field("opening_hours1",new HourField([
			"label" => _("Otevřeno od"),
			"hints" => ["8:00","9:30"],
			"required" => false,
			"help_text" => _("Nevyplňujte, pokud je zavřeno"),
		]));
		$this->add_field("opening_hours2",new HourField([
			"label" => _("Otevřeno do"),
			"hints" => ["20:30","21:00"],
			"required" => false,
			"help_text" => _("Nevyplňujte, pokud je zavřeno"),
		]));

		$this->add_translatable_field("note", new CharField([
			"label" => _("Poznámka"),
			"required" => false,
			"hints" => ["dovolená","inventura","Vánoce"],
		]));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(is_array($d)){
			$keys = array_keys($d);
			if(in_array("opening_hours1",$keys) && in_array("opening_hours2",$keys)){ // it means that both values are without errors
				if((isset($d["opening_hours1"]) && is_null($d["opening_hours2"])) || (is_null($d["opening_hours1"]) && isset($d["opening_hours2"]))){
					$this->set_error(_("Zadejte oba časy nebo ponechte oba nevyplněné"));
				}
				if(isset($d["opening_hours1"]) && isset($d["opening_hours2"]) && $d["opening_hours2"]<=$d["opening_hours1"]){
					$this->set_error("opening_hours2",_("Čas otevření do musí být větší než čas otevření od"));
				}
			}
		}

		return [$err,$d];
	}
}
