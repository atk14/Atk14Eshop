CREATE TABLE payment_statuses (
	id INT PRIMARY KEY,
	code VARCHAR(255) NOT NULL,
	--
	CONSTRAINT unq_paymentstatuses_code UNIQUE (code)
);
INSERT INTO payment_statuses VALUES (1,'pending');
INSERT INTO payment_statuses VALUES (2,'paid');
INSERT INTO payment_statuses VALUES (3,'cancelled');

CREATE SEQUENCE seq_payment_transactions;
CREATE TABLE payment_transactions (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_payment_transactions'),
	--
	order_id INT NOT NULL,
	payment_gateway_id INT NOT NULL,
	--
	secret VARCHAR(255) NOT NULL,
	testing_payment BOOLEAN NOT NULL DEFAULT FALSE,
	--
	payment_transaction_started_at TIMESTAMP,
	payment_transaction_started_from_addr VARCHAR(255),
	--
	payment_transaction_id VARCHAR(255),
	payment_transaction_url VARCHAR(1000),
	--
	payment_status_id INT,
	payment_status_updated_at TIMESTAMP,
	payment_status_checked_at TIMESTAMP,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_paymenttransactions_paymentgateways FOREIGN KEY (payment_gateway_id) REFERENCES payment_gateways,
	CONSTRAINT fk_paymenttransactions_paymentstatuses FOREIGN KEY (payment_status_id) REFERENCES payment_statuses,
	CONSTRAINT unq_paymenttransactions_orderid UNIQUE (order_id) -- zatim nejvyse jedna transakce pro jednu objednavku
);
