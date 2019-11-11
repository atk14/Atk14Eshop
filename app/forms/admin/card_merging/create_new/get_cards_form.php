<?php
class GetCardsForm extends AdminForm {

	var $count_of_cards = 5;

	function set_up(){
		for($i=1;$i<=$this->count_of_cards;$i++){
			$this->add_field("card_$i", new CardField([
				"label" => sprintf(_("Product %d"),$i),
				"required" => $i<=2,
			]));
		}

		$this->set_button_text(_("Continue"));
	}

	function clean(){
		list($err,$d) = parent::clean();
	
		$ids = [];
		for($i=1;$i<=$this->count_of_cards;$i++){
			if(!isset($d["card_$i"])){ continue; }
			$id = $d["card_$i"]->getId();
			if(in_array($id,$ids)){
				$this->set_error("card_$i",_("Každý produkt lze zadat pouze jednou"));
			}
			$ids[] = $id;
		}

		return [$err,$d];
	}
}
