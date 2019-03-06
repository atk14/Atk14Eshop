CREATE SEQUENCE seq_baskets START WITH 11;
CREATE TABLE baskets (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_baskets'),
	--
	user_id INT, -- pro ononymniho uzivatele tu bude null
	currency_id INT NOT NULL,
	--
	firstname VARCHAR(255),
	lastname VARCHAR(255),
	email VARCHAR(255),
	company VARCHAR(255),
	company_number VARCHAR(255), -- ico
	vat_id VARCHAR(255), -- dic
	address_street VARCHAR(255),
	address_street2 VARCHAR(255),
	address_city VARCHAR(255),
	address_zip VARCHAR(255),
	address_country CHAR(2),
	address_note TEXT,
	phone VARCHAR(255),
	phone_mobile VARCHAR(255),
	--
	delivery_firstname VARCHAR(255),
	delivery_lastname VARCHAR(255),
	delivery_company VARCHAR(255),
	delivery_address_street VARCHAR(255),
	delivery_address_street2 VARCHAR(255),
	delivery_address_city VARCHAR(255),
	delivery_address_zip VARCHAR(255),
	delivery_address_country CHAR(2),
	delivery_address_note TEXT,
	delivery_phone VARCHAR(255),
	delivery_phone_mobile VARCHAR(255),
	--
	delivery_method_id INT,
	payment_method_id INT,
	--
	note TEXT,
	subscribe_to_newsletter BOOLEAN NOT NULL DEFAULT FALSE,
	--
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	updated_from_addr VARCHAR(255),
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_baskets_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT fk_baskets_currencies FOREIGN KEY (currency_id) REFERENCES currencies,
	CONSTRAINT fk_baskets_deliverytypes FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods,
	CONSTRAINT fk_baskets_paymenttypes FOREIGN KEY (payment_method_id) REFERENCES payment_methods
);
INSERT INTO baskets (id,currency_id) VALUES(1,1); -- dummy basket

CREATE SEQUENCE seq_basket_items;
CREATE TABLE basket_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_basket_items'),
	--
	basket_id INT NOT NULL,
	--
	product_id INT NOT NULL,
	amount INT DEFAULT 1 NOT NULL CHECK(amount>0),
	rank INT NOT NULL DEFAULT 999,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_basketitems_baskets FOREIGN KEY (basket_id) REFERENCES baskets ON DELETE CASCADE,
	CONSTRAINT fk_basketitems_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	CONSTRAINT unq_baskets UNIQUE (basket_id,product_id)
);
