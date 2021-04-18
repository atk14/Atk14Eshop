ALTER TABLE delivery_methods ADD vat_rate_id INT;
UPDATE delivery_methods SET vat_rate_id=(SELECT id FROM vat_rates WHERE code='default');
ALTER TABLE delivery_methods DROP COLUMN price;
ALTER TABLE delivery_methods ADD CONSTRAINT fk_deliverymethods_vatrates FOREIGN KEY (vat_rate_id) REFERENCES vat_rates;
