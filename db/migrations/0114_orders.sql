-- DROP TABLE order_items; DROP TABLE orders; DROP SEQUENCE seq_order_items; DROP SEQUENCE seq_orders;

CREATE TABLE order_statuses (
	id INTEGER PRIMARY KEY,
	code VARCHAR(255),
	-- name je translatable
	--
	CONSTRAINT unq_orderstatuses_code UNIQUE (code)
);

INSERT INTO order_statuses VALUES (1,'new'); -- vychozi stav
INSERT INTO order_statuses VALUES (2,'waiting_for_processing');
INSERT INTO order_statuses VALUES (3,'waiting_for_bank_transfer');
INSERT INTO order_statuses VALUES (4,'waiting_for_online_payment');
INSERT INTO order_statuses VALUES (5,'payment_accepted');
INSERT INTO order_statuses VALUES (6,'payment_failed');
INSERT INTO order_statuses VALUES (7,'processing');
INSERT INTO order_statuses VALUES (8,'on_the_way');
INSERT INTO order_statuses VALUES (9,'waiting_for_transport');
INSERT INTO order_statuses VALUES (10,'ready');
INSERT INTO order_statuses VALUES (11,'shipped');
INSERT INTO order_statuses VALUES (12,'delivered');
INSERT INTO order_statuses VALUES (13,'cancelled');

-- obsoletni stavy
INSERT INTO order_statuses VALUES (14,'waiting_for_check');
INSERT INTO order_statuses VALUES (15,'waiting_for_bank_transfer_info');
INSERT INTO order_statuses VALUES (16,'waiting_for_paypal_payment');
INSERT INTO order_statuses VALUES (17,'processed');
INSERT INTO order_statuses VALUES (18,'not_in_stock');
INSERT INTO order_statuses VALUES (19,'returned_money');

INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',1, 'name','cs','Nová objednávka');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',2, 'name','cs','Čeká na zpracování');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',3, 'name','cs','Čeká na úhradu převodem');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',4, 'name','cs','Čekání na zpracování platební bránou');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',5, 'name','cs','Platba přijata');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',6, 'name','cs','Platba neproběhla');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',7, 'name','cs','Zpracování objednávky');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',8, 'name','cs','Na cestě');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',9, 'name','cs','Čekání na rozvoz');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',10,'name','cs','Připraveno k vyzvednutí');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',11,'name','cs','Odesláno');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',12,'name','cs','Doručeno');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',13,'name','cs','Zrušeno');

INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',14,'name','cs','Čekání na proplacení šeku');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',15,'name','cs','Čekání na informace k bankovnímu převodu');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',16,'name','cs','Čekáme na PayPal platbu');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',17,'name','cs','Zpracováno');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',18,'name','cs','Zboží není skladem');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('order_statuses',19,'name','cs','Vráceny peníze');


CREATE SEQUENCE seq_orders;
CREATE TABLE orders (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_orders'),
	--
	order_no VARCHAR(255) NOT NULL,
	reference VARCHAR(255),
	user_id INTEGER, -- nakup bez registrace -> null
	region_id INT NOT NULL,
	currency_id INT DEFAULT 1 NOT NULL,
	language CHAR(2) NOT NULL DEFAULT 'cs',
	--
	-- fakturacni udaje
	firstname VARCHAR(255),
	lastname VARCHAR(255),
	email VARCHAR(255),
	company VARCHAR(255),
	company_number VARCHAR(255), -- ico
	vat_id VARCHAR(255), -- dic
	vat_id_valid_for_cross_border_transactions_within_eu BOOLEAN,
	address_street VARCHAR(255),
	address_street2 VARCHAR(255),
	address_city VARCHAR(255),
	address_state VARCHAR(255),
	address_zip VARCHAR(255),
	address_country CHAR(2),
	address_note TEXT,
	phone VARCHAR(255),
	--
	-- dorucovaci adresa
	delivery_firstname VARCHAR(255),
	delivery_lastname VARCHAR(255),
	delivery_company VARCHAR(255),
	delivery_address_street VARCHAR(255),
	delivery_address_street2 VARCHAR(255),
	delivery_address_city VARCHAR(255),
	delivery_address_state VARCHAR(255),
	delivery_address_zip VARCHAR(255),
	delivery_address_country CHAR(2),
	delivery_address_note TEXT,
	delivery_phone VARCHAR(255),
	--
	-- poznamka k objednavce
	note TEXT,
	--
	delivery_method_id INTEGER NOT NULL,
	delivery_method_data JSON,
	delivery_fee NUMERIC(20,6) NOT NULL,
	delivery_fee_incl_vat NUMERIC(20,6) NOT NULL,
	--
	payment_method_id INTEGER NOT NULL,
	payment_method_data JSON,
	payment_fee NUMERIC(20,6) NOT NULL,
	payment_fee_incl_vat NUMERIC(20,6) NOT NULL,
	--
	without_vat BOOLEAN NOT NULL DEFAULT FALSE,
	price_to_pay NUMERIC(20,6) NOT NULL,
	--
	gdpr BOOLEAN,
	--
	responsible_user_id INTEGER,
	--
	-- akt. stav objednavky
	order_status_id INT NOT NULL,
	order_status_set_at TIMESTAMP DEFAULT NOW() NOT NULL,
	order_status_set_by_user_id INT,
	order_status_note TEXT,
	--
	-- notifikace vytvoreni objednavky muze byt pozdrzeno (napr. z duvodu cekani na udaje z plat. brany)
	creation_notified BOOLEAN,
	creation_notified_at TIMESTAMP,
	--
	exported BOOLEAN NOT NULL DEFAULT false,
	exported_at TIMESTAMP,
	--
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	created_from_user_agent VARCHAR(1000),
	--
	created_by_user_id INT, -- toto muze byt administrator!
	updated_by_user_id INT,
	--
	created_at TIMESTAMP DEFAULT NOW() NOT NULL,
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_orders_orderno UNIQUE (order_no),
	CONSTRAINT chk_orders_pricetopay CHECK (price_to_pay >= 0.0),
	CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id),
	CONSTRAINT fk_orders_regions FOREIGN KEY (region_id) REFERENCES regions,
	CONSTRAINT fk_orders_orderstatuses FOREIGN KEY (order_status_id) REFERENCES order_statuses,
	CONSTRAINT fk_orders_status_users FOREIGN KEY (order_status_set_by_user_id) REFERENCES users,
	CONSTRAINT fk_orders_currencies FOREIGN KEY (currency_id) REFERENCES currencies(id),
	CONSTRAINT fk_orders_delivery_methods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods(id),
	CONSTRAINT fk_orders_payment_methods FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id),
	CONSTRAINT fk_orders_responsible_users FOREIGN KEY (responsible_user_id) REFERENCES users(id),
	CONSTRAINT fk_orders_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users(id),
	CONSTRAINT fk_orders_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users(id)
);
-- ALTER TABLE orders ADD created_by_user_id INT;
-- ALTER TABLE orders ADD CONSTRAINT fk_orders_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users(id);

CREATE SEQUENCE seq_order_items;
CREATE TABLE order_items (
	id INTEGER PRIMARY KEY DEFAULT nextval('seq_order_items'),
	--
	order_id INT NOT NULL,
	--
	product_id INT NOT NULL,
	amount INT NOT NULL,
	unit_price NUMERIC(20,6) NOT NULL,
	vat_percent NUMERIC(5,2) NOT NULL,
	rank INT NOT NULL DEFAULT 999,
	--
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_orderitems UNIQUE (order_id, product_id),
	CONSTRAINT chk_orders_amount CHECK (amount > 0),
	CONSTRAINT fk_orderitems_orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
	CONSTRAINT fk_orderitems_products FOREIGN KEY (product_id) REFERENCES products(id)
	--
);

-- ALTER TABLE orders ADD language CHAR(2) NOT NULL DEFAULT 'cs';
