CREATE SEQUENCE seq_manufacturers;
CREATE TABLE manufacturers (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_manufacturers'),
	rank INTEGER DEFAULT 999 NOT NULL,
	name VARCHAR(255),
	url VARCHAR(255),
	logo_url VARCHAR(255),
	visible BOOLEAN NOT NULL DEFAULT 't',
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_manufacturers_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_manufacturers_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);


ALTER TABLE cards ADD COLUMN manufacturer_id INTEGER;
