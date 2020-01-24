<?php
class GetPrimaryCardForm extends AdminForm {

	function set_up(){
		$this->add_field("card_id", new ChoiceField([
			"label" => _("Zachovávaný produkt"),
			"widget" => new RadioSelect([]),
		]));


		$this->set_button_text(_("Continue"));
	}

	function prepare_for_cards($cards){
		$choices = [];

		foreach($cards as $card){
			$choices[$card->getId()] = sprintf("%s, #%d",$card->getName(),$card->getId());
		}

		$this->fields["card_id"]->set_choices($choices);
		$this->set_initial("card_id",$cards[0]->getId());
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["card_id"])){
			$d["card_id"] = Card::GetInstanceById($d["card_id"]);
		}
		
		return [$err,$d];
	}
}
