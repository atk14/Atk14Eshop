CREATE SEQUENCE seq_creators;
CREATE TABLE creators (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_creators'),
	--
	name VARCHAR(255) NOT NULL,
	year_of_birth INT,
	date_of_birth DATE,
	year_of_death INT,
	date_of_death DATE,
	image_url VARCHAR(255),
	page_id INT,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_creators_name UNIQUE (name),
	CONSTRAINT fk_creators_page FOREIGN KEY (page_id) REFERENCES pages ON DELETE SET NULL,
	CONSTRAINT fk_creators_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_creators_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_creator_roles START WITH 11;
CREATE TABLE creator_roles (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_creators'),
	--
	code VARCHAR(255),
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_creatorroles_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_creatorroles_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
INSERT INTO creator_roles (id) VALUES(1);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',1,'en','name','Author');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',1,'cs','name','Autor');

INSERT INTO creator_roles (id) VALUES(2);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',2,'en','name','Illustration');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',2,'cs','name','Ilustrace');

INSERT INTO creator_roles (id) VALUES(3);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',3,'en','name','Composer');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',3,'cs','name','Skladatel');

INSERT INTO creator_roles (id) VALUES(4);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',4,'en','name','Artist');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',4,'cs','name','Interpret');

INSERT INTO creator_roles (id) VALUES(5);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',5,'en','name','Narrator');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',5,'cs','name','Vypravěč');

INSERT INTO creator_roles (id) VALUES(6);
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',6,'en','name','Designer');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('creator_roles',6,'cs','name','Designer');

CREATE SEQUENCE seq_card_creators;
CREATE TABLE card_creators (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_card_creators'),
	--
	card_id INT NOT NULL,
	creator_id INT NOT NULL,
	creator_role_id INT NOT NULL,
	is_main_creator BOOLEAN NOT NULL DEFAULT FALSE,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_cardcreators_cards FOREIGN KEY (card_id) REFERENCES cards ON DELETE CASCADE,
	CONSTRAINT fk_cardcreators_creators FOREIGN KEY (creator_id) REFERENCES creators ON DELETE CASCADE,
	CONSTRAINT fk_cardcreators_creatorroles FOREIGN KEY (creator_role_id) REFERENCES creator_roles,
	--
	CONSTRAINT fk_cardcreators_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_cardcreators_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
