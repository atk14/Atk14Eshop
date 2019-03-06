CREATE SEQUENCE seq_pricelists START WITH 11;
CREATE TABLE pricelists (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_pricelists'),
	code VARCHAR(255),
	--
	name VARCHAR(255) NOT NULL,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_pricelists_code UNIQUE (code),
	CONSTRAINT fk_pricelists_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_pricelists_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
INSERT INTO pricelists (id,code,name) VALUES(1,'default','Default');
INSERT INTO pricelists (id,code,name) VALUES(2,'basic','Basic');

CREATE SEQUENCE seq_pricelist_items;
CREATE TABLE pricelist_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_pricelist_items'),
	--
	pricelist_id INT NOT NULL,
	product_id INT NOT NULL,
	price NUMERIC(20,6) NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_pricelistitems UNIQUE(pricelist_id,product_id),
	--
	CONSTRAINT fk_pricelistitems_pricelists FOREIGN KEY (pricelist_id) REFERENCES pricelists ON DELETE CASCADE,
	CONSTRAINT fk_pricelistitems_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	--
	CONSTRAINT fk_pricelistitems_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_pricelistitems_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

