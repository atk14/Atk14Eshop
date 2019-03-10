CREATE SEQUENCE seq_genders_id START WITH 11;
CREATE TABLE genders (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_genders_id'),
	code VARCHAR(255) NOT NULL,
	--
	sex CHAR(1) NOT NULL,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	CONSTRAINT unq_genders_code UNIQUE (code)
);

INSERT INTO genders VALUES(1,'mr','m'); -- pan
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','1','name','cs','pan');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','1','name','en','Mr');

INSERT INTO genders VALUES(2,'ms','f'); -- pani / slecna
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','2','name','cs','paní');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','2','name','en','Mrs');

INSERT INTO genders VALUES(3,'miss','f'); -- slecna
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','3','name','cs','slečna');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('genders','3','name','en','Miss');
