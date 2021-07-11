CREATE SEQUENCE seq_watched_products;

CREATE TABLE watched_products (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_watched_products'),
	--
	product_id INTEGER NOT NULL,
	user_id INTEGER,
	email VARCHAR(255),
	--
	notified BOOLEAN DEFAULT 'f',
	notified_at TIMESTAMP,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_watchedproducts_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT chk_watchedproducts_userid_email CHECK (user_id IS NOT NULL OR email IS NOT NULL),
	CONSTRAINT chk_watchedproducts_email CHECK (LENGTH(email)>0),
	--
	CONSTRAINT fk_watchedproducts_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_watchedproducts_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE INDEX in_watchedproducts_userid ON watched_products (user_id);
CREATE INDEX in_watchedproducts_email ON watched_products (email);
CREATE INDEX in_watchedproducts_productid ON watched_products (product_id);
