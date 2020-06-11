<?php
class Voucher extends ApplicationModel implements Translatable {

	use TraitRegions;

	static function GetTranslatableFields(){ return array("description"); }

	function __construct(){
		// Toto tady mame pro tridu BasketVoucher
		parent::__construct("vouchers",[
			"sequence_name" => "seq_vouchers",
		]);
	}

	static function PrepareVoucherCode(){
		$length = 10;
		$counter = 0;
		while(1){
			//$voucher_code = String4::RandomPassword($length)->upper()->toString();
			$voucher_code = rand(1,9).sprintf('%09d',rand(0,999999999)); // kod voucher ma byt 10 cislic
			if(!Voucher::FindFirst("voucher_code",$voucher_code)){
				return $voucher_code;
			}
			$counter++;
			if($counter>=10){
				throw new Exception("Too many cycles in Voucher::PrepareVoucherCode()");
			}
		}
	}

	/**
	 * Je mozne tento voucher pouzit?
	 *
	 *	if(!$voucher->isApplicable($basket,$msg)){
	 *		// tento voucher nelze pouzit...
	 *		echo $msg;
	 *	}
	 */
	function isApplicable($basket,&$error_msg = ""){
		$error_msg = "";

		if(!$this->isActive()){
			$error_msg = sprintf(_("Voucher %s nelze použít"),$this->getVoucherCode());
			return false;
		}

		if($basket->isEmpty()){
			$error_msg = _("Voucher nemůže být použit v prázdném košíku");
			return false;
		}

		$current_time = strtotime(now());
		if(
			(!is_null($this->getValidFrom()) && strtotime($this->getValidFrom())>$current_time) ||
			(!is_null($this->getValidTo()) && strtotime($this->getValidTo())<$current_time)
		){
			$error_msg = sprintf(_("Platnost voucheru %s vypršela"),$this->getVoucherCode());
			return false;
		}

		if(!$this->isRepeatable() && $this->hasBeenUsed()){
			$error_msg = sprintf(_("Voucher %s již nelze použít"),$this->getVoucherCode());
			return false;
		}

		$region = $basket->getRegion();
		$rc = $region->getCode();
		$regions = json_decode($this->g("regions"),true);
		if(!isset($regions[$rc]) || !$regions[$rc]){
			$error_msg = sprintf(_("Voucher %s nelze použít"),$this->getVoucherCode());
			return false;
		}

		if($minimal_items_price_incl_vat = $this->getMinimalItemsPriceInclVat()){
			$currency = $basket->getCurrency();
			$items_price_incl_vat = $basket->getItemsPriceInclVat() * $currency->getRate();
			if($minimal_items_price_incl_vat>$items_price_incl_vat){
				Atk14Require::Helper("modifier.display_price");
				$price = smarty_modifier_display_price($minimal_items_price_incl_vat / $currency->getRate(),$currency);
				$error_msg = sprintf(_("Voucher %s lze použít až při minimálním obnosu %s za zboží"),$this->getVoucherCode(),$price);
				return false;
			}
		}

		return true;
	}


	function hasBeenUsed(){
		return 0<$this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM order_vouchers WHERE voucher_id=:voucher LIMIT 1)q",[":voucher" => $this]);
	}

	function isDeletable(){
		return !$this->hasBeenUsed();
	}

	function isRepeatable(){
		return $this->getRepeatable();
	}

	function isActive(){
		return $this->getActive();
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	function freeShipping(){
		return $this->g("free_shipping");
	}

	function toString(){ return $this->getVoucherCode(); }
}
