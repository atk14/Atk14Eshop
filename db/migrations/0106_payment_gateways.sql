CREATE SEQUENCE seq_payment_gateways START WITH 11;
CREATE TABLE payment_gateways (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_payment_gateways'),
	code VARCHAR(255) NOT NULL,
	name VARCHAR(255),
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_paymentgateways_code UNIQUE (code),
	CONSTRAINT fk_paymentgateways_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_paymentgateways_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO payment_gateways VALUES (1,'GP webpay','gp_webpay');
INSERT INTO payment_gateways VALUES (2,'ComGate','comgate');
