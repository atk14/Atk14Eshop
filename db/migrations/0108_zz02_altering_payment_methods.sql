ALTER TABLE payment_methods ADD vat_rate_id INT;
UPDATE payment_methods SET vat_rate_id=(SELECT id FROM vat_rates WHERE code='default');
ALTER TABLE payment_methods DROP COLUMN price;
ALTER TABLE payment_methods ADD CONSTRAINT fk_paymentmethods_vatrates FOREIGN KEY (vat_rate_id) REFERENCES vat_rates;
