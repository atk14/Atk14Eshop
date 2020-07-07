CREATE SEQUENCE seq_product_types START WITH 11;
CREATE TABLE product_types (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_product_types'),
	--
	code VARCHAR(255),
	--
	rank INT DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_producttypes_code UNIQUE (code),
	CONSTRAINT fk_producttypes_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_producttypes_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

-- default product type
INSERT INTO product_types (id,code) VALUES(1,'default');
--
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('product_types',1,'en','name','product');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('product_types',1,'cs','name','produkt');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('product_types',1,'en','page_title_pattern','%product_name%');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('product_types',1,'cs','page_title_pattern','%product_name%');
--
INSERT INTO slugs (table_name,record_id,lang,slug) VALUES('product_types',1,'en','product');
INSERT INTO slugs (table_name,record_id,lang,slug) VALUES('product_types',1,'cs','produkt');

ALTER TABLE cards ADD product_type_id INT NOT NULL DEFAULT 1;
ALTER TABLE cards ADD CONSTRAINT fk_cards_producttypes FOREIGN KEY (product_type_id) REFERENCES product_types;

