CREATE SEQUENCE seq_digital_contents;
CREATE TABLE digital_contents (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_digital_contents'),
	--
	product_id INT NOT NULL,
	--
	path VARCHAR(255) NOT NULL,
	filename VARCHAR(255) NOT NULL,
	filesize INT NOT NULL,
	mime_type VARCHAR(255) NOT NULL,
	--
	image_url VARCHAR(255),
	--
	regions JSON,
	active BOOLEAN DEFAULT TRUE,
	deleted BOOLEAN NOT NULL DEFAULT FALSE,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_digitalcontents_products FOREIGN KEY (product_id) REFERENCES products,
	CONSTRAINT fk_digitalcontents_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_digitalcontents_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
CREATE INDEX in_digitalcontents_productid ON digital_contents(product_id);

CREATE SEQUENCE seq_digital_content_downloads;
CREATE TABLE digital_content_downloads (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_digital_content_downloads'),
	--
	order_id INT NOT NULL,
	digital_content_id INT NOT NULL,
	--
	created_by_user_id INT,
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	created_from_user_agent VARCHAR,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	--
	CONSTRAINT fk_digitalcontentdownloads_orders FOREIGN KEY (order_id) REFERENCES orders,
	CONSTRAINT fk_digitalcontentdownloads_digitalcontents FOREIGN KEY (digital_content_id) REFERENCES digital_contents,
	CONSTRAINT fk_digitalcontentdownloads_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users
);
CREATE INDEX in_digitalcontentdownloads_orderid ON digital_content_downloads(order_id);
CREATE INDEX in_digitalcontentdownloads_digitalcontentid ON digital_content_downloads(digital_content_id);
