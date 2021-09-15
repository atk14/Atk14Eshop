CREATE SEQUENCE seq_delivery_methods_designated_for_tags;
CREATE TABLE delivery_methods_designated_for_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_methods_designated_for_tags'),
	delivery_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_deliverymethod_dsgnt_tags_deliverymethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods ON DELETE CASCADE,
	CONSTRAINT fk_deliverymethod_dsgnt_tags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);

CREATE SEQUENCE seq_delivery_methods_excluded_for_tags;
CREATE TABLE delivery_methods_excluded_for_tags (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_methods_excluded_for_tags'),
	delivery_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_deliverymethod_excl_tags_deliverymethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods ON DELETE CASCADE,
	CONSTRAINT fk_deliverymethod_excl_tags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
