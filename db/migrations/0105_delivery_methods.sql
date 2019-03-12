CREATE SEQUENCE seq_delivery_methods START WITH 11;
CREATE TABLE delivery_methods (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_methods'),
	--
	code VARCHAR(255), -- alternative key
	regions JSON,
	image_url VARCHAR(255), -- icon
	logo VARCHAR(255),
	price NUMERIC(20,6) NOT NULL DEFAULT 0.0,
	price_incl_vat NUMERIC(20,6) NOT NULL DEFAULT 0.0,
	active BOOLEAN NOT NULL DEFAULT TRUE,
	personal_pickup BOOLEAN NOT NULL DEFAULT FALSE,
	personal_pickup_on_store_id INT, -- personal_pickup on this store
	delivery_service_id INT,
	required_tag_id INT,
	tracking_url VARCHAR(255),
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_deliverymethods_code UNIQUE (code),
	CONSTRAINT fk_deliverymethods_stores FOREIGN KEY (personal_pickup_on_store_id) REFERENCES stores,
	CONSTRAINT fk_delivery_methods_deliveryservices FOREIGN KEY (delivery_service_id) REFERENCES delivery_services(id),
	CONSTRAINT fk_deliverymethods_tags FOREIGN KEY (required_tag_id) REFERENCES tags(id),
	CONSTRAINT fk_deliverymethods_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_deliverymethods_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
