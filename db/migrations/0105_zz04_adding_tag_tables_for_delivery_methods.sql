CREATE SEQUENCE seq_delivery_method_designated_for_tags;
CREATE TABLE delivery_method_designated_for_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_method_designated_for_tags'),
	delivery_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_deliverymethoddsgnttags_deliverymethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods ON DELETE CASCADE,
	CONSTRAINT fk_deliverymethoddsgnttags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);

CREATE SEQUENCE seq_delivery_method_excluded_for_tags;
CREATE TABLE delivery_method_excluded_for_tags (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_method_excluded_for_tags'),
	delivery_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_deliverymethodexcltags_deliverymethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods ON DELETE CASCADE,
	CONSTRAINT fk_deliverymethodexcltags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
