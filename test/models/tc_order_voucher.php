<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture delivery_methods
 * @fixture payment_methods
 */
class TcOrderVoucher extends TcBase {

	function test(){
		$voucher_free_shipping = Voucher::CreateNewRecord([
			"voucher_code" => "FREE_SHIPPING",
			"repeatable" => true,
			"free_shipping" => true,
			"regions" => '{"CR": true, "SK": true, "EU": true}'
		]);
		$voucher_20_percent_off = Voucher::CreateNewRecord([
			"voucher_code" => "20_PERCENT_OFF",
			"repeatable" => true,
			"discount_percent" => 20,
			"regions" => '{"CR": true, "SK": true, "EU": true}'
		]);
		$basket = $this->_prepareEmptyBasket();
		$basket->setProductAmount($this->products["wooden_button"],2); // vat_percent: 21%
		$basket->setProductAmount($this->products["book"],1); // vat_percent: 10%
		$basket->getVouchersLister()->add($voucher_free_shipping);
		$basket->getVouchersLister()->add($voucher_20_percent_off);

		$vouchers = $basket->getVouchers(); // BasketVoucher[]
		
		$this->assertEquals(2,sizeof($vouchers));
		$this->assertEquals("Free shipping",$vouchers[0]->getDescription());
		$this->assertEquals("Discount voucher",$vouchers[1]->getDescription());

		$order = $basket->createOrder();
		$vouchers = $order->getVouchers();

		$this->assertEquals(2,sizeof($vouchers));

		$this->assertEquals(121.0,$vouchers[0]->getDiscountAmount());
		$this->assertEquals(100.0,$vouchers[0]->getDiscountAmount(false));
		$this->assertEquals(21.0,$vouchers[0]->getVatPercent());
		$this->assertEquals("Doprava zdarma",$vouchers[0]->getDescription());

		$this->assertEquals(65.48,$vouchers[1]->getDiscountAmount());
		$this->assertEquals(58.73,$vouchers[1]->getDiscountAmount(false)); // used averaged items VAT percent
		$this->assertEquals(null,$vouchers[1]->getVatPercent());
		$this->assertEquals("Slevový kupón",$vouchers[1]->getDescription());

		// --

		$voucher = Voucher::CreateNewRecord([
			"voucher_code" => "SUPER-COUPON",
			"repeatable" => true,
			"free_shipping" => true,
			"discount_percent" => 10.0,
			"regions" => '{"CR": true, "SK": true, "EU": true}'
		]);

		$basket = $this->_prepareEmptyBasket();
		$basket->setProductAmount($this->products["wooden_button"],10);
		$basket->getVouchersLister()->add($voucher);

		$vouchers = $basket->getVouchers(); // BasketVoucher[]
		
		$this->assertEquals(1,sizeof($vouchers));
		$this->assertEquals("Sleva + doprava zdarma",$vouchers[0]->getDescription());

		$order = $basket->createOrder();
		$vouchers = $order->getVouchers();

		$this->assertEquals(2,sizeof($vouchers));

		$this->assertEquals($voucher->getId(),$vouchers[0]->getVoucherId());
		$this->assertEquals(121.0,$vouchers[0]->getDiscountAmount());
		$this->assertEquals(100.0,$vouchers[0]->getDiscountAmount(false));
		$this->assertEquals(21.0,$vouchers[0]->getVatPercent());
		$this->assertEquals("Doprava zdarma",$vouchers[0]->getDescription());

		$this->assertEquals($voucher->getId(),$vouchers[1]->getVoucherId());
		$this->assertEquals(24.2,$vouchers[1]->getDiscountAmount());
		$this->assertEquals(20.0,$vouchers[1]->getDiscountAmount(false)); // used averaged items VAT percent
		$this->assertEquals(null,$vouchers[1]->getVatPercent());
		$this->assertEquals("Slevový kupón",$vouchers[1]->getDescription());
	}
}
