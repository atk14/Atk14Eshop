CREATE SEQUENCE seq_payment_methods START WITH 11;
CREATE TABLE payment_methods (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_payment_methods'),
	--
	code VARCHAR(255), -- alternative key
	image_url VARCHAR(255), -- icon
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
	CONSTRAINT fk_paymentmethods_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_paymentmethods_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
