<?php
/**
 *
 * @fixture vouchers
 * @fixture regions
 * @fixture users
 */
class TcBasketVoucher extends TcBase {

	function test(){
		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];
		
		$free_shipping = $this->vouchers["free_shipping"];
		$percentage_discount = $this->vouchers["percentage_discount"];
		$amount_discount = $this->vouchers["amount_discount"];
		$free_voucher = $this->vouchers["free_voucher"];

		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$basket->getVouchersLister()->add($free_shipping);
		$basket->getVouchersLister()->add($percentage_discount);
		$basket->getVouchersLister()->add($amount_discount);
		$basket->getVouchersLister()->add($free_voucher);

		$vouchers = $basket->getVouchers(); // BasketVoucher[]
		
		$this->assertEquals($vouchers[0]->getVoucherId(),$free_shipping->getId());
		$this->assertEquals("Free shipping",$vouchers[0]->getDescription());
		$this->assertEquals("check",$vouchers[0]->getIconSymbol());

		$this->assertEquals($vouchers[1]->getVoucherId(),$percentage_discount->getId());
		$this->assertEquals("Discount voucher",$vouchers[1]->getDescription());
		$this->assertEquals("percent",$vouchers[1]->getIconSymbol());

		$this->assertEquals($vouchers[2]->getVoucherId(),$amount_discount->getId());
		$this->assertEquals("Discount voucher",$vouchers[2]->getDescription());
		$this->assertEquals("percent",$vouchers[2]->getIconSymbol());

		$this->assertEquals($vouchers[3]->getVoucherId(),$free_voucher->getId());
		$this->assertEquals("Gift voucher",$vouchers[3]->getDescription());
		$this->assertEquals("gift",$vouchers[3]->getIconSymbol());

		// custom descriptions
		$free_shipping->s("description_en","Yep, shipping is free of charge!");
		$percentage_discount->s("description_en","Percentage discount for you!");
		$amount_discount->s("description_en","Discount for you!");
		$free_voucher->s("description_en","Gift for you!");
		//
		$this->assertEquals("Yep, shipping is free of charge!",$vouchers[0]->getDescription());
		$this->assertEquals("Percentage discount for you!",$vouchers[1]->getDescription());
		$this->assertEquals("Discount for you!",$vouchers[2]->getDescription());
		$this->assertEquals("Gift for you!",$vouchers[3]->getDescription());
	}
}
