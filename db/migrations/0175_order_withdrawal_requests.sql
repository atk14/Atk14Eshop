-- DROP TABLE order_withdrawal_request_items;
-- DROP SEQUENCE seq_order_withdrawal_request_items;
-- DROP TABLE order_withdrawal_request_history;
-- DROP SEQUENCE seq_order_withdrawal_request_history;
-- DROP TABLE order_withdrawal_requests;
-- DROP SEQUENCE seq_order_withdrawal_requests;
-- DROP TABLE order_withdrawal_request_statuses;
-- DROP SEQUENCE seq_order_withdrawal_request_statuses;
-- DELETE FROM translations WHERE table_name='order_withdrawal_request_statuses';

CREATE SEQUENCE seq_order_withdrawal_request_statuses START WITH 11;
CREATE TABLE order_withdrawal_request_statuses (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_order_withdrawal_request_statuses'),
	--
	code VARCHAR(255) NOT NULL,
	--
	finished_successfully BOOLEAN NOT NULL DEFAULT FALSE, -- uspesne ukonceni
	finished_unsuccessfully BOOLEAN NOT NULL DEFAULT FALSE, -- neuspesne ukonceni
	notification_enabled BOOLEAN NOT NULL DEFAULT FALSE,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_orderwithdrawalrequeststatuses_code UNIQUE (code),
	CONSTRAINT fk_orderwithdrawalrequeststatuses_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderwithdrawalrequeststatuses_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO order_withdrawal_request_statuses(id,code,rank) VALUES(1,'new',10);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('order_withdrawal_request_statuses',1,'cs','name','nová žádost');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('order_withdrawal_request_statuses',1,'en','name','new application');

CREATE SEQUENCE seq_order_withdrawal_requests;
CREATE TABLE order_withdrawal_requests (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_order_withdrawal_requests'),
	--
	order_id INT NOT NULL,
	--
	firstname VARCHAR(255),
	lastname VARCHAR(255),
	email VARCHAR(255),
	phone VARCHAR(255),
	--
	bank_account_number VARCHAR(255),
	--
	reasons JSON,
	other_reason TEXT,
	--
	language CHAR(2) NOT NULL,
	--
	order_withdrawal_request_status_id INT NOT NULL,
	order_withdrawal_request_status_set_at TIMESTAMP NOT NULL DEFAULT NOW(),
	order_withdrawal_request_status_set_by_user_id INT,
	order_withdrawal_request_status_note TEXT,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	--
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_orderwithdrawalrequests_orders FOREIGN KEY (order_id) REFERENCES orders,
	CONSTRAINT fk_orderwithdrawalrequests_orderwithdrawalrequeststatuses FOREIGN KEY (order_withdrawal_request_status_id) REFERENCES order_withdrawal_request_statuses,
	CONSTRAINT fk_orderwithdrawalrequests_status_users FOREIGN KEY (order_withdrawal_request_status_set_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderwithdrawalrequests_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderwithdrawalrequests_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_order_withdrawal_request_history;
CREATE TABLE order_withdrawal_request_history (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_withdrawal_request_history'),
	--
	order_withdrawal_request_id INTEGER NOT NULL,
	order_withdrawal_request_status_id INTEGER NOT NULL,
	--
	order_withdrawal_request_status_set_at TIMESTAMP NOT NULL,
	order_withdrawal_request_status_set_by_user_id INTEGER,
	note TEXT,
	--
	created_at TIMESTAMP DEFAULT NOW() NOT NULL,
	--
	CONSTRAINT fk_orderwithdrawalrequesthistory_orderwithdrawalrequests FOREIGN KEY (order_withdrawal_request_id) REFERENCES order_withdrawal_requests(id) ON DELETE CASCADE,
	CONSTRAINT fk_orderwithdrawalrequesthistory_orderwithdrawalrequeststatuses FOREIGN KEY (order_withdrawal_request_status_id) REFERENCES order_withdrawal_request_statuses(id),
	CONSTRAINT fk_orderwithdrawalrequesthistory_users FOREIGN KEY (order_withdrawal_request_status_set_by_user_id) REFERENCES users(id)
);
CREATE INDEX in_order_withdrawal_requesthistory_order_withdrawal_requestid ON order_withdrawal_request_history(order_withdrawal_request_id, order_withdrawal_request_status_set_at);

CREATE SEQUENCE seq_order_withdrawal_request_items;
CREATE TABLE order_withdrawal_request_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_order_withdrawal_request_items'),
	--
	order_withdrawal_request_id INT NOT NULL,
	product_id INT NOT NULL,
	amount INT NOT NULL,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP DEFAULT NOW() NOT NULL,
	updated_at TIMESTAMP,
	--
	CONSTRAINT unk_orderwithdrawalrequestitems UNIQUE (order_withdrawal_request_id,product_id),
	CONSTRAINT fk_orderwithdrawalrequestitems_orderwithdrawalrequests FOREIGN KEY (order_withdrawal_request_id) REFERENCES order_withdrawal_requests ON DELETE CASCADE,
	CONSTRAINT fk_orderwithdrawalrequestitems_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderwithdrawalrequestitems_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
