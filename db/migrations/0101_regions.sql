CREATE SEQUENCE seq_regions START WITH 11;
CREATE TABLE regions (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_regions'),
	code VARCHAR(255) NOT NULL,
	--
	email VARCHAR(255),
	domains JSON, -- ['example.com','www.example.com']
	languages JSON, -- ['cs','sk']
	currencies JSON, -- ['CZK','EUR']
	delivery_countries JSON, -- ['CZ','SK']
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_regions_code UNIQUE (code),
	CONSTRAINT fk_regison_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_regison_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO regions (id,code,domains,languages,currencies,delivery_countries) VALUES (1,'DEFAULT','[]','["cs","en"]','["CZK"]','["CZ"]');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('regions','1','name','cs','Česká republika');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('regions','1','name','en','Czechia');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('regions','1','short_name','cs','ČR');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('regions','1','short_name','en','CZ');
