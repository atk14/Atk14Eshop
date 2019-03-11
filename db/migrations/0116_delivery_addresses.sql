CREATE SEQUENCE seq_delivery_addresses;
CREATE TABLE delivery_addresses (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_addresses'),
	--
	user_id INT NOT NULL,
	--
	firstname VARCHAR(255),
	lastname VARCHAR(255),
	company VARCHAR(255),
	address_street VARCHAR(255),
	address_street2 VARCHAR(255),
	address_city VARCHAR(255),
	address_state VARCHAR(255),
	address_zip VARCHAR(255),
	address_country CHAR(2),
	address_note TEXT,
	phone VARCHAR(255),
	--
	last_used_at TIMESTAMP,
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_deliveryaddresses_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE
);
CREATE INDEX in_deliveryaddresses_userid ON delivery_addresses (user_id);
