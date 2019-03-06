CREATE SEQUENCE seq_warehouses START WITH 11;
CREATE TABLE warehouses (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_warehouses'),
	code VARCHAR(255),
	--
	applies_to_eshop BOOLEAN NOT NULL DEFAULT 't',
	store_id INT,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_warehouses_code UNIQUE (code),
	CONSTRAINT fk_warehouses_stores FOREIGN KEY (store_id) REFERENCES stores ON DELETE SET NULL,
	CONSTRAINT fk_warehouses_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_warehouses_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO warehouses (id,code,applies_to_eshop) VALUES(1,'default','t');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('warehouses','1','name','cs','sklad e-shopu');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('warehouses','1','name','en','warehouse of eshop');

CREATE SEQUENCE seq_warehouse_products;
CREATE TABLE warehouse_products (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_warehouse_products'),
	--
	warehouse_id INT NOT NULL,
	product_id INT NOT NULL,
	stockcount INT NOT NULL,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_warehouseproducts UNIQUE (warehouse_id,product_id),
	CONSTRAINT fk_warehouseproducts_warehouses FOREIGN KEY (warehouse_id) REFERENCES warehouses ON DELETE CASCADE,
	CONSTRAINT fk_warehouseproducts_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE
);
