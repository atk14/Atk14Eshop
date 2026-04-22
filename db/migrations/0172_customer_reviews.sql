-- DROP TABLE customer_review_history;
-- DROP SEQUENCE seq_customer_review_history;
-- DROP TABLE customer_reviews;
-- DROP SEQUENCE seq_customer_reviews;
-- DROP TABLE customer_review_statuses;
-- DROP SEQUENCE seq_customer_review_statuses;
-- DELETE FROM translations WHERE table_name='customer_review_statuses';

CREATE SEQUENCE seq_customer_review_statuses START WITH 11;
CREATE TABLE customer_review_statuses (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_customer_review_statuses'),
	--
	code VARCHAR(255) NOT NULL,
	--
	finished_successfully BOOLEAN NOT NULL DEFAULT FALSE, -- uspesne ukonceni
	finished_unsuccessfully BOOLEAN NOT NULL DEFAULT FALSE, -- neuspesne ukonceni
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_customerreviewstatuses_code UNIQUE (code),
	CONSTRAINT fk_customerreviewstatuses_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customerreviewstatuses_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO customer_review_statuses(id,code,rank) VALUES(1,'new',10);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',1,'cs','name','nová recenze');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',1,'en','name','new review');

INSERT INTO customer_review_statuses(id,code,finished_successfully,rank) VALUES(2,'published',true,20);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',2,'cs','name','publikováno');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',2,'en','name','published');

INSERT INTO customer_review_statuses(id,code,finished_unsuccessfully,rank) VALUES(3,'rejected',true,30);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',3,'cs','name','recenze zamítnuta');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_review_statuses',3,'en','name','review rejected');

CREATE SEQUENCE seq_customer_reviews;
CREATE TABLE customer_reviews (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_customer_reviews'),
	--
	product_id INT NOT NULL,
	--
	user_id INT, -- osloveny uzivate, nemusi byt prihlasen
	order_id INT,
	language CHAR(2) NOT NULL,
	--
	author VARCHAR(255), -- John Doe
	title VARCHAR(255), -- At last the best fabric for me!
	body TEXT,
	rating INT, -- stars, 5, 4...
	--
	customer_review_status_id INT NOT NULL,
	customer_review_status_set_at TIMESTAMP NOT NULL DEFAULT NOW(),
	customer_review_status_set_by_user_id INT,
	customer_review_status_note TEXT,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	--
	updated_at TIMESTAMP,
	updated_from_addr VARCHAR(255),
	updated_from_hostname VARCHAR(255),
	--
	CONSTRAINT fk_customerreviews_products FOREIGN KEY (product_id) REFERENCES products,
	CONSTRAINT fk_customerreviews_users FOREIGN KEY (user_id) REFERENCES users,
	CONSTRAINT fk_customerreviews_orders FOREIGN KEY (order_id) REFERENCES orders ON DELETE CASCADE,
	CONSTRAINT fk_customerreviews_customerreviewstatuses FOREIGN KEY (customer_review_status_id) REFERENCES customer_review_statuses,
	CONSTRAINT fk_customerreviews_status_users FOREIGN KEY (customer_review_status_set_by_user_id) REFERENCES users,
	CONSTRAINT fk_customerreviews_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customerreviews_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users,
	--
	CONSTRAINT chk_customerreviews CHECK ((user_id IS NOT NULL AND order_id IS NULL) OR (user_id IS NULL AND order_id IS NOT NULL)),
	CONSTRAINT unq_customerreviews_userid_productid UNIQUE (user_id,product_id),
	CONSTRAINT unq_customerreviews_orderid_productid UNIQUE (order_id,product_id)
);

CREATE INDEX in_customerreviews_productid ON customer_reviews (product_id);

CREATE SEQUENCE seq_customer_review_history;
CREATE TABLE customer_review_history (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_customer_review_history'),
	--
	customer_review_id INTEGER NOT NULL,
	customer_review_status_id INTEGER NOT NULL,
	--
	customer_review_status_set_at TIMESTAMP NOT NULL,
	customer_review_status_set_by_user_id INTEGER,
	note TEXT,
	--
	created_at TIMESTAMP DEFAULT NOW() NOT NULL,
	--
	CONSTRAINT fk_customerreviewhistory_customer_reviews FOREIGN KEY (customer_review_id) REFERENCES customer_reviews(id) ON DELETE CASCADE,
	CONSTRAINT fk_customerreviewhistory_customer_reviewstatuses FOREIGN KEY (customer_review_status_id) REFERENCES customer_review_statuses(id),
	CONSTRAINT fk_customerreviewhistory_users FOREIGN KEY (customer_review_status_set_by_user_id) REFERENCES users(id)
);
