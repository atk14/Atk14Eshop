ALTER TABLE order_vouchers ADD free_shipping BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE order_vouchers DROP CONSTRAINT unq_ordervouchers; -- UNIQUE CONSTRAINT, btree (order_id, voucher_id)
ALTER TABLE order_vouchers ADD CONSTRAINT unq_ordervouchers UNIQUE (order_id,voucher_id,free_shipping);
ALTER TABLE order_vouchers ADD vat_percent NUMERIC(5,2);
