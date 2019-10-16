<?php
class CurrenciesController extends AdminController {

	function index(){
		$this->page_title = _("List of Currencies");

		$this->tpl_data["currencies"] = Currency::FindAll(["order_by" => "code"]);
		$this->tpl_data["default_currency"] = Currency::GetDefaultCurrency();
	}

	function edit(){
		$currency = $this->currency;

		$this->form->set_initial([
			"rate" => $this->currency->getRate(),
		]);

		$this->_edit([
			"update_closure" => function($currency,$d){
				if($currency->getRate()!==$d["rate"]){
					CurrencyRate::CreateNewRecord([
						"currency_id" => $currency,
						"rate" => $d["rate"],
					]);
				}
				unset($d["rate"]);
				$currency->s($d);
				return $currency;
			}
		]);
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("currency");
		}
	}
}
