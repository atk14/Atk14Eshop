CREATE SEQUENCE seq_vat_rates START WITH 11;
CREATE TABLE vat_rates (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_vat_rates'),
	code VARCHAR(255) NOT NULL,
	--
	vat_percent NUMERIC(5,2) NOT NULL,
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_vatrates_code UNIQUE (code),
	CONSTRAINT fk_vatrates_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_vatrates_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO vat_rates (id,code,vat_percent) VALUES(1,'default',21.0);
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','1','name','cs','základní sazba DPH');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','1','name','en','standard VAT rate');

INSERT INTO vat_rates (id,code,vat_percent) VALUES(2,'reduced_15',15.0);
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','2','name','cs','snížená sazba DPH');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','2','name','en','reduced VAT rate');

INSERT INTO vat_rates (id,code,vat_percent) VALUES(3,'reduced_10',10.0);
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','3','name','cs','snížená sazba DPH');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('vat_rates','3','name','en','reduced VAT rate');
