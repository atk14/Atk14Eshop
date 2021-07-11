CREATE SEQUENCE seq_favourite_products;

CREATE TABLE favourite_products (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_favourite_products'),
	--
	user_id INTEGER NOT NULL,
	session_salt VARCHAR(255) NOT NULL DEFAULT '', -- for unregistered visitors
	--
	product_id INTEGER NOT NULL,
	--
	rank INTEGER NOT NULL DEFAULT 999,
	--
	created_from_addr VARCHAR(255),
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_favouriteproducts_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT fk_favouriteproducts_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	CONSTRAINT unq_favouriteproducts_userid_productid UNIQUE (user_id,session_salt,product_id),
	--
	CONSTRAINT fk_favouriteproducts_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_favouriteproducts_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
