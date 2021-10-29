<?php
require_once(__DIR__ . "/baskets_form.php"); // Toto tu potrebujeme, nebot se tento formular nahrava i v api/baskets/detail a dalsich API funkci

class EditForm extends BasketsForm {

	function set_up(){
		$this->add_field("voucher", new CharField([
			"max_length" => 50,
			"required" => false,
			"null_empty_output" => true,
			"hint" => _("Slevový kód"),
		]));

		$this->add_field("note", new TextField([
			'label' => _('Vaše poznámka k objednávce'),
			'required' => false,
			'max_length' => 1000,
			'widget' => new Textarea([
				'attrs' => ['rows' => 2 ],
			])
		]));
	}

	function set_up_for_basket($basket){
		foreach($basket->getItems() as $item){
			$product = $item->getProduct();
			$id = $item->getId();
			$field = $this->add_field("i$id",new OrderQuantityField($product,[
				"min_value" => 0,
				"initial" => $item->getAmount(),
			]));
			$field->widget->attrs["data-initial"] = $item->getAmount();
			$field->widget->attrs["tabindex"] = "100";
		}
	}
}
