CREATE SEQUENCE seq_delivery_services START WITH 11;
CREATE TABLE delivery_services (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_services'),
	--
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
	CONSTRAINT unq_deliveryservices_code UNIQUE (code),
	CONSTRAINT fk_deliveryservices_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_deliveryservices_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
