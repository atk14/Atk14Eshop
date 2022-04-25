CREATE SEQUENCE seq_customer_groups START WITH 11;
CREATE TABLE customer_groups (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_customer_groups'),
	--
	code VARCHAR(255),
	manually_assignable BOOLEAN NOT NULL DEFAULT TRUE,
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_customergroups_code UNIQUE (code),
	CONSTRAINT fk_customergroups_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customergroups_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO customer_groups (id,code,manually_assignable) VALUES(1,'unregistered',FALSE);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_groups',1,'en','name','Unregistered customers');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_groups',1,'cs','name','Neregistrovaní zákazníci');

INSERT INTO customer_groups (id,code,manually_assignable) VALUES(2,'registered',FALSE);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_groups',2,'en','name','Registered customers');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('customer_groups',2,'cs','name','Registrovaní zákazníci');

CREATE SEQUENCE seq_user_customer_groups;
CREATE TABLE user_customer_groups(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_user_customer_groups'),
	user_id INTEGER NOT NULL,
	customer_group_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_usercustomergroups_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT fk_usercustomergroups_customergroups FOREIGN KEY (customer_group_id) REFERENCES customer_groups ON DELETE CASCADE
);
CREATE INDEX in_usercustomergroups_userid ON user_customer_groups(user_id);
CREATE INDEX in_usercustomergroups_customergroupid ON user_customer_groups(customer_group_id);
