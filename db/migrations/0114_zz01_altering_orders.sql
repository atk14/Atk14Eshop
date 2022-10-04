ALTER TABLE orders ADD delivery_fee_vat_percent NUMERIC(5,2);
ALTER TABLE orders ADD payment_fee_vat_percent NUMERIC(5,2);

UPDATE orders SET
	delivery_fee_vat_percent=(SELECT vat_percent FROM vat_rates WHERE code='default'),
	payment_fee_vat_percent=(SELECT vat_percent FROM vat_rates WHERE code='default')
WHERE
	NOT without_vat;

UPDATE orders SET
	delivery_fee_vat_percent=0.0,
	payment_fee_vat_percent=0.0
WHERE
	without_vat;

ALTER TABLE orders DROP COLUMN delivery_fee;
ALTER TABLE orders DROP COLUMN payment_fee;
