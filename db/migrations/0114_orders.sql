CREATE SEQUENCE seq_orders;
CREATE TABLE orders (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_orders'),
	--
	order_no VARCHAR(255) NOT NULL,
	--
	region_id INT NOT NULL,
	currency_id INT DEFAULT 1 NOT NULL,
	language CHAR(2) NOT NULL DEFAULT 'cs',
	--
	user_id INTEGER, -- nakup bez registrace -> null
	--
	order_label_id INTEGER,
	--
	-- control mechanism to avoid duplicate orders creation from the same basket
	integrity_key VARCHAR(255),
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
	delivery_fee NUMERIC(20,6),
	delivery_fee_incl_vat NUMERIC(20,6),
	--
	payment_method_id INTEGER NOT NULL,
	payment_fee NUMERIC(20,6) NOT NULL,
	payment_fee_incl_vat NUMERIC(20,6) NOT NULL,
	--
	without_vat BOOLEAN NOT NULL DEFAULT FALSE,
	price_to_pay NUMERIC(20,6) NOT NULL,
	--
	price_paid NUMERIC(20,6),
	tracking_number VARCHAR(255),
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
	CONSTRAINT unq_orders_integritykey UNIQUE(integrity_key),
	CONSTRAINT chk_orders_pricetopay CHECK (price_to_pay >= 0.0),
	CONSTRAINT chk_orders_creationnotified CHECK (((creation_notified IS NULL OR creation_notified=FALSE) AND creation_notified_at IS NULL) OR (creation_notified=TRUE AND creation_notified_at IS NOT NULL)),
	CONSTRAINT chk_orders_deliveryfees CHECK ((delivery_fee IS NOT NULL AND delivery_fee_incl_vat IS NOT NULL) OR (delivery_fee IS NULL AND delivery_fee_incl_vat IS NULL)),
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
CREATE INDEX in_orders_userid ON orders (user_id);
CREATE INDEX in_orders_orderstatusid ON orders (order_status_id);
CREATE INDEX in_orders_createdat ON orders (created_at);


CREATE SEQUENCE seq_order_items;
CREATE TABLE order_items (
	id INTEGER PRIMARY KEY DEFAULT nextval('seq_order_items'),
	--
	order_id INT NOT NULL,
	--
	product_id INT NOT NULL,
	amount INT NOT NULL,
	unit_price_incl_vat NUMERIC(20,6) NOT NULL,
	unit_price_before_discount_incl_vat NUMERIC(20,6),
	vat_percent NUMERIC(5,2),
	campaign_discount_applied BOOLEAN NOT NULL DEFAULT FALSE,
	rank INT NOT NULL DEFAULT 999,
	--
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_orderitems UNIQUE (order_id, product_id),
	CONSTRAINT chk_orders_amount CHECK (amount > 0 OR amount = -1), -- produkt zaokrouhleni se muze dat do objednavky -1x
	CONSTRAINT fk_orderitems_orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
	CONSTRAINT fk_orderitems_products FOREIGN KEY (product_id) REFERENCES products(id)
	--
);

-- ALTER TABLE orders ADD language CHAR(2) NOT NULL DEFAULT 'cs';
