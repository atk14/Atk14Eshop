ALTER TABLE vouchers DROP CONSTRAINT chk_vouchers; -- CHECK(free_shipping OR discount_amount>=0.0 OR discount_percent>=0.0)
