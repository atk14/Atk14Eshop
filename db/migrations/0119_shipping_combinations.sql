CREATE SEQUENCE seq_shipping_combinations;

CREATE TABLE shipping_combinations (
	id INTEGER PRIMARY KEY NOT NULL DEFAULT NEXTVAL('seq_shipping_combinations'),
	--
	payment_method_id INTEGER NOT NULL,
	delivery_method_id INTEGER NOT NULL,
	--
	CONSTRAINT fk_shipping_payment_method FOREIGN KEY (payment_method_id) REFERENCES payment_methods,
	CONSTRAINT fk_shipping_delivery_method FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods,
	CONSTRAINT unq_shipping__delivery_method_payment_method UNIQUE (payment_method_id, delivery_method_id)
);

