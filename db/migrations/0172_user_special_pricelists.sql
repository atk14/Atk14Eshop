CREATE SEQUENCE seq_special_pricelists;
CREATE TABLE special_pricelists (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_special_pricelists'),
	--
	contains_prices_without_vat BOOLEAN DEFAULT FALSE NOT NULL,
	code VARCHAR(255),
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_specialpricelists_code UNIQUE (code),
	CONSTRAINT fk_specialpricelists_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_specialpricelists_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_special_pricelist_items;
CREATE TABLE special_pricelist_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_special_pricelist_items'),
	--
	special_pricelist_id INT NOT NULL,
	product_id INT NOT NULL,
	minimum_quantity INT NOT NULL DEFAULT 0,
	price NUMERIC(20,6),
	discount_percent NUMERIC(5,2),
	--
	valid_from TIMESTAMP,
	valid_to TIMESTAMP,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT chk_specialpricelistitems CHECK((price IS NOT NULL AND discount_percent IS NULL) OR (price IS NULL AND discount_percent IS NOT NULL)),
	--
	CONSTRAINT fk_specialpricelistitems_special_pricelists FOREIGN KEY (special_pricelist_id) REFERENCES special_pricelists ON DELETE CASCADE,
	CONSTRAINT fk_specialpricelistitems_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	--
	CONSTRAINT fk_specialpricelistitems_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_specialpricelistitems_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
CREATE INDEX in_specialpricelistitems_specialpricelistid_productid ON special_pricelist_items(special_pricelist_id,product_id);

CREATE SEQUENCE seq_user_special_pricelists;
CREATE TABLE user_special_pricelists (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_user_special_pricelists'),
	--
	user_id INTEGER NOT NULL,
	special_pricelist_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	CONSTRAINT in_userspecialpricelists_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT in_userspecialpricelists_specialpricelists FOREIGN KEY (special_pricelist_id) REFERENCES special_pricelists
);

CREATE INDEX in_userspecialpricelists_userid ON user_special_pricelists(user_id);
