<?php
class GetLabelsForm extends AdminForm {

	function set_up(){
		$this->set_button_text(_("Continue"));
	}

	function prepare_for_cards($cards){
		global $ATK14_GLOBAL;

		$fieldsets = [];

		$langs = $ATK14_GLOBAL->getSupportedLangs();
		$initials = [];

		foreach($cards as $card){
			$fields = [];
			foreach($card->getProducts(["visible" => null]) as $p){
				$id = $p->getId();

				$_fields = $this->add_translatable_field("product_$id", new CharField([
					"label" => sprintf(_("Label for product %s"),$p->getCatalogId()),
					"required" => true,
				]),["return" => "names"]);

				foreach($_fields as $f){ $fields[] = $f; }

				foreach($langs as $l){
					$initials["product_{$id}_$l"] = $p->g("label_$l");
				}
			}

			if($fields){
				$fieldsets[] = [
					"card" => $card,
					"fields" => $fields,
				];
			}
		}

		$this->set_initial($initials);

		return $fieldsets;
	}
}
