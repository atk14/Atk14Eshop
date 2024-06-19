<?php
/**
 *
 *	$voucher = BasketVoucher::GetInstanceById(123);
 *	$voucher->setBasket($basket);
 *
 * 	$voucher->getDiscountAmount();
 */
class BasketVoucher extends BasketOrOrderVoucher {

	function setRank($rank){
		$this->_setRank($rank,[
			"basket_id" => $this->getBasketId(),
		]);
	}

	function getBasket(){
		return Cache::Get("Basket",$this->getBasketId());
	}

	function getDiscountAmount($incl_vat = true){
		$currency = $this->getBasket()->getCurrency();
		$voucher = $this->getVoucher();
		$basket = $this->getBasket();

		$out = $this->getVoucher()->getDiscountAmount() / $currency->getRate();

		$discount_percent = ApplicationHelpers::GetPercentageDiscountApplicableOnBasket($this);
		if($discount_percent > 0.0){
			foreach($basket->getItems() as $item){
				$product = $item->getProduct();
				if(!$product->invoiceDiscountAllowed()){ continue; }

				$pp = $item->getProductPrice();
				if($pp->discounted()){
					// Procentni slevu nelze uplatnit na jiz slevnene zbozi
					continue;
				}
				$out += ($pp->getPriceInclVat() / 100.0) * $discount_percent;
			}
		}

		$out = $currency->roundPrice($out);

		if(!$incl_vat){
			$vat_percent = $voucher->getVatPercent();
			if(is_null($vat_percent)){
				$vat_percent = $basket->getAveragedItemsVatPercent();
			}
			$out = ($out / (100.0 + $vat_percent)) * 100.0;
			$out = $currency->roundPrice($out);
		}

		return $out;
	}

}
