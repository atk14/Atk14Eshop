ALTER TABLE delivery_method_country_specifications ADD vat_rate_id INT;
UPDATE delivery_method_country_specifications SET vat_rate_id=(SELECT id FROM vat_rates WHERE code='default');
ALTER TABLE delivery_method_country_specifications DROP COLUMN price;
ALTER TABLE delivery_method_country_specifications ADD CONSTRAINT fk_deliverymethodcountryspecifications_vatrates FOREIGN KEY (vat_rate_id) REFERENCES vat_rates;

