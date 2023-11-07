<?php
class BasketOrOrder extends ApplicationModel {

	static function GetAddressFields($options = []){
		$options += [
			"company_data" => false,
			"address_street2" => true,
			"address_state" => true,
			"phone" => false,
			"note" => false,
			"prefix" => "", // "", "delivery_"
		];

		$prefix = $options["prefix"];

		$fields = [
			"{$prefix}firstname" => true,
			"{$prefix}lastname" => true,
			"{$prefix}company" => false,
			"{$prefix}address_street" => true,
			"{$prefix}address_street2" => false,
			"{$prefix}address_city" => true,
			"{$prefix}address_state" => false,
			"{$prefix}address_zip" => true,
			"{$prefix}address_country" => true,
		];

		if($options["company_data"]){
			$fields += [
				"{$prefix}company_number" => false,
				"{$prefix}vat_id" => false,
			];
		}

		if($options["phone"]){
			$fields += [
				"{$prefix}phone" => false,
			];
		}

		if($options["note"]){
			$fields["{$prefix}address_note"] = false;
		}

		if(!$options["address_street2"]){
			unset($fields["{$prefix}address_street2"]);
		}

		if(!$options["address_state"]){
			unset($fields["{$prefix}address_state"]);
		}

		return $fields;
	}

	function getCurrency(){
		return Cache::Get("Currency",$this->getCurrencyId());
	}

	/**
	 * Returns decimals to round the summary price
	 *
	 * It is safer to call $basket->getCurrencyDecimalsSummary() or $order->getCurrencyDecimalsSummary()
	 * instead of $basket->getCurrency()->getDecimalsSummary() $order->getCurrency()->getDecimalsSummary() respectively,
	 * because in some special cases the results may vary.
	 */
	function getCurrencyDecimalsSummary(){
		$currency = $this->getCurrency();
		$decimals = $currency->getDecimalsSummary();
		return $decimals;
	}

	function getRegion(){
		return Cache::Get("Region",$this->getRegionId());
	}

	/**
	 * Cena za polozky
	 */
	function getItemsPrice($incl_vat = false){
		$price = 0.0;
		foreach($this->getItems() as $bi){
			//$price += $bi->getPrice($incl_vat); // Secteni vsech zaokrouhlenych polozek. Toto je to mozna prirozenejsi, ale Winshop to tak nepocita.
			$price += $bi->getUnitPrice($incl_vat) * $bi->getAmount(); // Takto to pocita Winshop
		}

		// A jakmile to tak pro Winshop spocitame, musime to zaokrouhlit...
		$currency = $this->getCurrency();
		$price = $currency->roundPrice($price);

		return $price;
	}

	function getItemsPriceInclVat(){
		return $this->getItemsPrice(true);
	}

	function getItemsPriceBeforeDiscount($incl_vat = false){
		// Vypocet je analogicky jako v getItemsPrice()
		$price = 0.0;
		foreach($this->getItems() as $bi){
			//$price += $bi->getPriceBeforeDiscount($incl_vat);
			$price += $bi->getUnitPriceBeforeDiscount($incl_vat) * $bi->getAmount();
		}

		$currency = $this->getCurrency();
		$price = $currency->roundPrice($price);

		return $price;
	}

	function getItemsPriceBeforeDiscountInclVat(){
		return $this->getItemsPriceBeforeDiscount(true);
	}

	function getAveragedItemsVatPercent(){
		$used_vat_rates = [];
		foreach($this->getItems() as $item){
			$vat_percent = $item->getVatPercent();
			if(in_array($vat_percent,$used_vat_rates)){ continue; }
			$used_vat_rates[] = $vat_percent;
		}

		if(sizeof($used_vat_rates)==0){
			return null;
		}

		if(sizeof($used_vat_rates)==1){
			return $used_vat_rates[0];
		}

		// TODO: needs to be more precise
		$price = $this->getItemsPrice();
		$price_incl_vat = $this->getItemsPriceInclVat();
		if(!$price){ return null; }
		$out = ($price_incl_vat - $price) / ($price / 100.0);
		return round($out,2);
	}

	function getDeliveryFirstname(){
		return $this->_getDelivery("firstname");
	}

	function getDeliveryLastname(){
		return $this->_getDelivery("lastname");
	}

	function getDeliveryAddressStreet(){
		return $this->_getDelivery("address_street");
	}

	function getDeliveryAddressStreet2(){
		if(strlen((string)$this->g("delivery_address_street"))){
			return $this->g("delivery_address_street2");
		}
		return $this->g("address_street2");
	}

	function getDeliveryAddressCity(){
		return $this->_getDelivery("address_city");
	}

	function getDeliveryAddressState(){
		return $this->_getDelivery("address_state");
	}

	function getDeliveryAddressZip(){
		return $this->_getDelivery("address_zip");
	}

	function getDeliveryAddressCountry(){
		return $this->_getDelivery("address_country");
	}

	function getDeliveryPhone(){
		if($this->g("delivery_phone")){
			return $this->g("delivery_phone");
		}
		return $this->g("phone");
	}

	function _getDelivery($key){
		$delivery_address_set = true;
		foreach(["street","city","zip"] as $k){
			if(!strlen((string)$this->g("delivery_address_$k"))){
				$delivery_address_set = false;
				break;
			}
		}

		$out = $this->g("delivery_$key");
		if($delivery_address_set){
			return $out;
		}
		if(!strlen((string)$out)){
			$out = $this->g("$key");
		}
		return $out;
	}

	function getDeliveryMethodData() {
		return json_decode($this->g("delivery_method_data"),true);
	}

	function getDeliveryPlace() {
		if ($data = $this->getDeliveryMethodData()) {
			return $data["delivery_address"]["place"];
		}
	}

	/**
	 * Je DIC zvalidovane v systemu VIES: http://ec.europa.eu/taxation_customs/vies/vatResponse.html
	 *
	 * Hodnoty:
	 * - true: DIC je zvalidovane
	 * - false: DIC je neplatne
	 * - null: validace selhala nebo nebylo validovano
	 */
	function isVatIdValidForCrossBorderTransactionsWithinEu(){
		return $this->g("vat_id_valid_for_cross_border_transactions_within_eu");
	}

	function getDeliveryMethod(){
		return Cache::Get("DeliveryMethod",$this->getDeliveryMethodId());
	}

	/**
	 * Vrati kod dopravy pro tuto objednavku nebo kosik
	 *
	 * Kod se muze lisit pro ruzne zeme v dorucovaci adrese.
	 *
	 *	$order->getDeliveryMethodCode(); // "ppl_eu"
	 *	$order1->getDeliveryMethodCode(); // "ppl_eu_germany"
	 *	$order2->getDeliveryMethodCode(); // "ppl_eu_poland"
	 *	$order3->getDeliveryMethodCode(); // "ppl_czech_republic"
	 *
	 */
	function getDeliveryMethodCode(){
		$dm = $this->getDeliveryMethod();
		if(!$dm){ return null; }
		return $dm->getCode($this->getDeliveryAddressCountry());
	}

	function getPaymentMethod(){
		return Cache::Get("PaymentMethod",$this->getPaymentMethodId());
	}


	function getShippingFee($incl_vat = false){
		if($incl_vat){
			return $this->getShippingFeeInclVat();
		}
		$delivery_fee = $this->getDeliveryFee();
		if(is_null($delivery_fee)){
			return null;
		}
		return $delivery_fee + $this->getPaymentFee();
	}

	function getShippingFeeInclVat(){
		$delivery_fee = $this->getDeliveryFeeInclVat();
		if(is_null($delivery_fee)){
			return null;
		}
		return $this->getDeliveryFeeInclVat() + $this->getPaymentFeeInclVat();
	}

	/**
	 * Vrati celk. slevy z voucheru v dane mene
	 *
	 * V $options muzeme urcit, ktere vouchery se uvazuji, defaultne se uvazuji vsechny typy
	 */
	function getVouchersDiscountAmount($incl_vat = true, $options=[]){
		$options += [
			"free_shipping" => null,
			"discount_amount" => null,
			"discount_percent" => null,
		];
		$out = 0.0;
		foreach($this->getVouchers() as $v){
			if (!is_null($options["free_shipping"]) && ($options["free_shipping"]===false) && $v->getVoucher()->freeShipping()) {
				continue;
			}
			if (!is_null($options["discount_percent"]) && ($options["discount_percent"]===false) && $v->getDiscountPercent()) {
				continue;
			}
			if (!is_null($options["discount_amount"]) && ($options["discount_amount"]===false) && $v->getVoucher()->getDiscountAmount($incl_vat)) {
				continue;
			}
			$out += $v->getDiscountAmount($incl_vat);
		}
		return $out;
	}

	/**
	 * Vrati celk. slevy z kampani v dane mene
	 */
	function getCampaignsDiscountAmount($incl_vat = true){
		$out = 0.0;
		foreach($this->getCampaigns() as $c){
			$out += $c->getDiscountAmount($incl_vat);
		}
		return $out;
	}

	/**
	 * Vrati checksum kosiku nebo objednavky
	 *
	 * Pri zmene/pridani/smazani polozky je generovan jiny checksum.
	 */
	function getChecksum(){
		$ary = [];
		$ary[] = $this->getId();
		foreach($this->getItems() as $item){
			$ary[] = [
				"product_id" => $item->getProductId(),
				"amount" => $item->getAmount(),
			];
		}
		return md5(serialize($ary));
	}

	function _delVat($price,$vat_percent){
		if(is_null($price)){ return null; }

		$vat_percent = (float)$vat_percent;
		$out = ($price / (100.0 + $vat_percent)) * 100.0;
		$out = round($out,INTERNAL_PRICE_DECIMALS);
		return $out;
	}
}
