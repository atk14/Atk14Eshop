<?php
class SelectVariantForm extends BasketsForm {

	function set_up(){
		$this->add_field("product_id", new ChoiceField([
			"label" => _("Variant"),
		]));

	}

	function prepare_for_card($card){
		$choices = ["" => "-- "._("Select variant")." --"];
		foreach($card->getProducts() as $product){
			$choices[$product->getId()] = $product->getLabel();
		}

		$this->fields["product_id"]->set_choices($choices);
	}
}
