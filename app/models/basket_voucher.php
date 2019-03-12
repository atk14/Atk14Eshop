<?php
/**
 *
 *	$voucher = BasketVoucher::GetInstanceById(123);
 *	$voucher->setBasket($basket);
 *
 * 	$voucher->getDiscountAmount();
 */
class BasketVoucher extends ApplicationModel implements Rankable {

	function setRank($rank){
		$this->_setRank($rank,[
			"basket_id" => $this->getBasketId(),
		]);
	}

	function getBasket(){
		return Cache::Get("Basket",$this->getBasketId());
	}

	function getVoucher(){
		return Cache::Get("Voucher",$this->getVoucherId());
	}

	function getVoucherCode(){
		return $this->getVoucher()->getVoucherCode();
	}

	function getDiscountPercent(){
		return $this->getVoucher()->getDiscountPercent();
	}

	function getDiscountAmount($incl_vat = true){
		if(!$incl_vat){
			throw new Exception("Actually I don't know how to determine vouchers discount amount without vat");
		}

		$currency = $this->getBasket()->getCurrency();
		$voucher = $this->getVoucher();
		$basket = $this->getBasket();

		$out = $this->getVoucher()->getDiscountAmount() / $currency->getRate();

		$discount_percent = ApplicationHelpers::GetPercentageDiscountApplicableOnBasket($this);
		if($discount_percent > 0.0){
			foreach($basket->getItems() as $item){
				$pp = $item->getProductPrice();
				if($pp->discounted()){
					// Procentni slevu nelze uplatnit na jiz slevnene zbozi
					continue;
				}
				$out += ($pp->getPriceInclVat() / 100.0) * $discount_percent;
			}
		}

		$out = $currency->roundPrice($out);

		return $out;
	}

	function toString(){
		return $this->getVoucherCode();
	}

}
