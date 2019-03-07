<?php
class BasketOrOrder extends ApplicationModel {

	static function GetAddressFields($options = []){
		$options += [
			"company_data" => false,
			"address_street2" => true,
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
				"{$prefix}phone_mobile" => false,
			];
		}

		if($options["note"]){
			$fields["{$prefix}address_note"] = false;
		}

		if(!$options["address_street2"]){
			unset($fields["{$prefix}address_street2"]);
		}

		return $fields;
	}

	function getCurrency(){
		return Cache::Get("Currency",$this->getCurrencyId());
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
		if(strlen($this->g("delivery_address_street"))){
			return $this->g("delivery_address_street2");
		}
		return $this->g("address_street2");
	}

	function getDeliveryAddressCity(){
		return $this->_getDelivery("address_city");
	}

	function getDeliveryAddressZip(){
		return $this->_getDelivery("address_zip");
	}

	function getDeliveryAddressCountry(){
		return $this->_getDelivery("address_country");
	}

	function getDeliveryPhone(){
		if($this->g("delivery_phone") || $this->g("delivery_phone_mobile")){
			return $this->g("delivery_phone");
		}
		return $this->g("phone");
	}

	function getDeliveryPhoneMobile(){
		if($this->g("delivery_phone") || $this->g("delivery_phone_mobile")){
			return $this->g("delivery_phone_mobile");
		}
		return $this->g("phone_mobile");
	}

	function _getDelivery($key){
		$out = $this->g("delivery_$key");
		if(!strlen($out)){
			$out = $this->g("$key");
		}
		return $out;
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


	function getShippingFee(){
		return $this->getDeliveryFee() + $this->getPaymentFee();
	}

	function getShippingFeeInclVat(){
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
			if (!is_null($options["discount_amount"]) && ($options["discount_amount"]===false) && $v->getVoucher()->getDiscountAmount()) {
				continue;
			}
			$out += $v->getDiscountAmount();
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
}
