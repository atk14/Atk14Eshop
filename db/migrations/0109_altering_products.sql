ALTER TABLE products ADD code VARCHAR(255);
ALTER TABLE products ADD CONSTRAINT unq_products_code UNIQUE (code);

ALTER TABLE products ADD vat_rate_id INT;
ALTER TABLE products ADD CONSTRAINT fk_products_vatrates FOREIGN KEY (vat_rate_id) REFERENCES vat_rates;

ALTER TABLE products ADD unit_id INT NOT NULL DEFAULT 1;
ALTER TABLE products ADD CONSTRAINT fk_products_units FOREIGN KEY (unit_id) REFERENCES units;

ALTER TABLE products ADD consider_stockcount BOOLEAN NOT NULL DEFAULT TRUE;

ALTER TABLE products ADD minimum_quantity_to_order INT DEFAULT NULL;
