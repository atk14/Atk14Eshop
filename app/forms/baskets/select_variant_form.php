<?php
class SelectVariantForm extends BasketsForm {

	function set_up(){
		$this->add_field("product_id", new ChoiceField([
			"label" => _("Variant"),
		]));

	}

	function prepare_for_card($card){
		$choices = ["" => "-- "._("Select variant")." --"];
		$disabled_choices = [];
		foreach($card->getProducts() as $product){
			$choices[$product->getId()] = $product->getLabel();
			if(!$product->canBeORdered()){
				$disabled_choices[] = $product->getId();
			}
		}

		$this->fields["product_id"]->set_choices($choices);
		$this->fields["product_id"]->set_disabled_choices($disabled_choices);
	}
}
