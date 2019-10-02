CREATE SEQUENCE seq_payment_methods START WITH 11;
CREATE TABLE payment_methods (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_payment_methods'),
	--
	code VARCHAR(255), -- alternative key
	regions JSON,
	payment_gateway_id INT, --
	bank_transfer BOOLEAN DEFAULT FALSE NOT NULL,
	cash_on_delivery BOOLEAN DEFAULT FALSE NOT NULL,
	image_url VARCHAR(255), -- icon
	logo VARCHAR(255),
	price NUMERIC(20,6) NOT NULL DEFAULT 0.0,
	price_incl_vat NUMERIC(20,6) NOT NULL DEFAULT 0.0,
	active BOOLEAN NOT NULL DEFAULT TRUE,
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_paymentmethods_code UNIQUE (code),
	CONSTRAINT fk_paymentmethods_paymentgateways FOREIGN KEY (payment_gateway_id) REFERENCES payment_gateways,
	CONSTRAINT fk_paymentmethods_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_paymentmethods_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
