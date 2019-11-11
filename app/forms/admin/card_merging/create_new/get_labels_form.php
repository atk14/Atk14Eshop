<?php
class GetLabelsForm extends AdminForm {

	function set_up(){
		$this->set_button_text(_("Continue"));
	}

	function prepare_for_cards($cards){
		global $ATK14_GLOBAL;

		$langs = $ATK14_GLOBAL->getSupportedLangs();
		$initials = [];

		foreach($cards as $card){
			foreach($card->getProducts() as $p){
				$id = $p->getId();

				$this->add_translatable_field("product_$id", new CharField([
					"label" => sprintf(_("Label for product %s"),$p->getCatalogId()),
					"required" => true,
				]));

				foreach($langs as $l){
					$initials["product_{$id}_$l"] = $p->g("label_$l");
				}
			}
		}

		$this->set_initial($initials);
	}
}
