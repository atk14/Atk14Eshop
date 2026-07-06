<?php
class GetDataForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->add_field("order_no", new CharField([
			"label" => _("Číslo objednávky"),
			"max_length" => 255,
			"disabled" => true,
		]));

		$this->add_field("firstname", new CharField([
			"label" => _("Vaše jméno"),
			"max_length" => 255,
		]));

		$this->add_field("lastname", new CharField([
			"label" => _("Vaše příjmení"),
			"max_length" => 255,
		]));

		$this->add_field("email", new EmailField([
			"label" => _("Váš e-mail"),
			"max_length" => 255,
		]));

		$this->add_field("phone", new PhoneField([
			"label" => _("Váš telefon"),
		]));

		$this->add_field("bank_account_number", new BankAccountField([
			"label" => _("Číslo vašeho bankovního účtu pro vrácení peněz"),
		]));

		$choices = OrderWithdrawalRequest::ReasonsOfOrderReturningChoices(true);
		$initial = [];
		if(sizeof($choices)==1){
			$initial = array_keys($choices);
		}
		$f = $this->add_field("reasons", new MultipleChoiceField([
			"label" => sizeof($choices)===1 ? _("Důvod vrácení zboží") : _("Vyberte důvody vrácení zboží"),
			"choices" => $choices,
			"widget" => new CheckboxSelectMultiple(),
			"initial" => $initial,
			"required" => true,
		]));
		$f->update_messages([
			"required" => _("Vyberte důvod vrácení zboží"),
		]);

		if(isset($choices["other"])){
			$f = $this->add_field("other_reason", new TextField([
				"label" => _("Jiný důvod k vrácení"),
				"required" => false,
			]));
		}
		$f->widget->attrs["rows"] = 3;

		$f = $this->add_field("products", new MultipleChoiceField([
			"label" => _("Jaké položky objednávky vracíte?"),
			"choices" => [],
			"widget" => new CheckboxSelectMultiple(),
			"required" => true,
		]));
		$f->update_messages([
			"required" => _("Zatrhněte položky objednávky, které chcete vratit"),
		]);
		
		$this->set_button_text(_("Odstoupit od kupní smlouvy"));
	}

	function tune_for_order($order,$authorized = true){
		$initial = [
			"order_no" => $order->getOrderNo(),
		];

		if($authorized){
			foreach([
				"firstname",
				"lastname",
				"email",
			] as $f){
				$method = String4::ToObject($f)->camelize(["lower" => true])->prepend("get")->toString();
				$initial[$f] = $order->$method();
			}
			if($phones = $order->getPhones()){
				$initial["phone"] = $phones[0];
			}

			Atk14Require::Helper("modifier.catalog_id");
			Atk14Require::Helper("modifier.display_amount");

			$choices = [];
			foreach($order->getItems() as $item){
				$product = $item->getProduct();
				$unit = $product->getUnit();

				if($product->getCode()==="price_rounding"){ continue; }

				$amount_str = smarty_modifier_display_amount($item->getAmount(),$unit);

				$choices[$product->getId()] = sprintf("%s - %s (%s)",smarty_modifier_catalog_id($product),$product->getName(),$amount_str);
			}

			$this->fields["products"]->set_choices($choices);
		}

		$payment_method = $order->getPaymentMethod();
		if(!$payment_method->isCashOnDelivery()){
			unset($this->fields["bank_account_number"]);
		}

		$this->set_initial($initial);
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(is_array($d)){
			unset($d["order_no"]);

			if(isset($d["reasons"]) && in_array("other",$d["reasons"]) && !$d["other_reason"]){
				$this->set_error("other_reason",_("Napište důvod k vrácení"));
			}
		}

		return [$err,$d];
	}
}
