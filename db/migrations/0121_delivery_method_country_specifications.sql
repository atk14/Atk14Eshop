-- Specificke vlastnosti dopravy pro danou zemi.
-- Zatim muze byt specificka pouze cena a code. V budoucnu by mohlo jit dopravu pro nejakou zemi napr. vypnout...
CREATE SEQUENCE seq_delivery_method_country_specifications;
CREATE TABLE delivery_method_country_specifications (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_method_country_specifications'),
	--
	delivery_method_id INT NOT NULL,
	country CHAR(2) NOT NULL,
	--
	code VARCHAR(255),
	price NUMERIC(12,4),
	price_incl_vat NUMERIC(12,4),
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_deliverymethodcountryspecs UNIQUE(delivery_method_id,country),
	CONSTRAINT fk_deliverymethodcountryspecs_delmethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods ON DELETE CASCADE,
	--
	CONSTRAINT chk_deliverymethodcountryspecs_price CHECK(
		(price IS NULL AND price_incl_vat IS NULL) OR
		(price IS NOT NULL AND price_incl_vat IS NOT NULL)
	),
	--
	CONSTRAINT fk_eliverymethodcountryspecs_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_eliverymethodcountryspecs_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
