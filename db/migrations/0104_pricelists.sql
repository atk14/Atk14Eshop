CREATE SEQUENCE seq_pricelists START WITH 11;
CREATE TABLE pricelists (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_pricelists'),
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
	CONSTRAINT unq_pricelists_code UNIQUE (code),
	CONSTRAINT fk_pricelists_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_pricelists_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO pricelists (id,code) VALUES(1,'default');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('pricelists','1','name','cs','Ceník');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('pricelists','1','name','en','Pricelist');

INSERT INTO pricelists (id,code) VALUES(2,'base');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('pricelists','2','name','cs','Základní ceny');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('pricelists','2','name','en','Basic prices');

CREATE SEQUENCE seq_pricelist_items;
CREATE TABLE pricelist_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_pricelist_items'),
	--
	pricelist_id INT NOT NULL,
	product_id INT NOT NULL,
	minimum_quantity INT NOT NULL DEFAULT 0,
	price NUMERIC(20,6) NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_pricelistitems UNIQUE(pricelist_id,product_id,minimum_quantity),
	--
	CONSTRAINT fk_pricelistitems_pricelists FOREIGN KEY (pricelist_id) REFERENCES pricelists ON DELETE CASCADE,
	CONSTRAINT fk_pricelistitems_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	--
	CONSTRAINT fk_pricelistitems_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_pricelistitems_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

