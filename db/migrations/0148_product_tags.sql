CREATE SEQUENCE seq_product_tags;
CREATE TABLE product_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_product_tags'),
	product_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_product_tags_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	CONSTRAINT fk_product_tags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
CREATE INDEX in_producttags_productid ON product_tags(product_id);
CREATE INDEX in_producttags_tagid ON product_tags(tag_id);
