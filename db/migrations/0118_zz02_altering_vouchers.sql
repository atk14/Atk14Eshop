-- a gift voucher (coupon) should have a VAT rate specified
ALTER TABLE vouchers ADD gift_voucher BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE vouchers ADD vat_rate_id INT;
ALTER TABLE vouchers ADD CONSTRAINT fk_vouchers_vatrates FOREIGN KEY (vat_rate_id) REFERENCES vat_rates;

-- TODO: this constraint needs to be revised for non VAT payers
ALTER TABLE vouchers ADD CONSTRAINT chk_vouchers_giftvoucher CHECK((gift_voucher=FALSE AND vat_rate_id IS NULL) OR (gift_voucher=TRUE AND vat_rate_id IS NOT NULL));
