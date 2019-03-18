<?php
class ApplicationHelpers {

	/**
	 * Urci, zda dany $basket_voucher nebo $basket_campaign smi slevnovat produkty v kosiku
	 *
	 * Pokud je napr. v kosiku voucher i kampan s procentualni slevou, vybere se jenom ta vyhodnejsi sleva.
	 * 
	 * $discount_percent = ApplicationHelpers::GetPercentageDiscountApplicableOnBasket($basket_voucher);
	 * $discount_percent = ApplicationHelpers::GetPercentageDiscountApplicableOnBasket($basket_campaign);
	 */
	static function GetPercentageDiscountApplicableOnBasket($obj){
		$discount_percent = $obj->getDiscountPercent();
		if($discount_percent<=0.0){ return 0.0; }

		$basket = $obj->getBasket();

		$discounts = [];
		foreach($basket->getBasketCampaigns() as $item){
			$discounts[self::_GetComparativeId($item)] = $item->getDiscountPercent();
		}
		foreach($basket->getBasketVouchers() as $item){
			$discounts[self::_GetComparativeId($item)] = $item->getDiscountPercent();
		}

		foreach($discounts as $id => $d_percent){
			if($d_percent>$discount_percent){
				// mame u neceho vyssi slevu -> procentni sleva tohoto objektu uz nesmi byt pouzita
				return 0.0;
			}
			if($d_percent===$discount_percent && strcmp($id,self::_GetComparativeId($obj))<0){
				// mame 2 stejne slevy; prednost ma ta prvni v abecednim poradi podle klice
				return 0.0;
			}
		}

		return $discount_percent;
	}

	/**
	 * Vraci unikatni idecko pro porovnavani v metode ApplicationHelpers::GetPercentageDiscountApplicableOnBasket()
	 */
	static function _GetComparativeId($obj){
		if(is_a($obj,"BasketCampaign")){
			return "_BasketCampaign#".$obj->getCampaign()->getId(); // Tridi se to podle abecedy, kampane chceme mit na konci, proto to "_"
		}

		return get_class($obj)."#".$obj->getId();
	}
}
