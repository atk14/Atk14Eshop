CREATE SEQUENCE seq_discounts;
CREATE TABLE discounts (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_discounts'),
	--
	category_id INT,
	product_id INT,
	--
	discount_percent NUMERIC(5,2) NOT NULL CHECK(discount_percent>=0.0 AND discount_percent<=100.0),
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_discounts_productid UNIQUE(product_id),
	CONSTRAINT unq_discounts_categoryid UNIQUE(category_id),
	CONSTRAINT chk_discounts CHECK((category_id IS NULL AND product_id IS NOT NULL) OR (category_id IS NOT NULL AND product_id IS NULL)),
	--
	CONSTRAINT fk_discounts_categories FOREIGN KEY (category_id) REFERENCES categories ON DELETE CASCADE,
	CONSTRAINT fk_discounts_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	--
	CONSTRAINT fk_discounts_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_discounts_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
