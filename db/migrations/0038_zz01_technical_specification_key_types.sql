CREATE TABLE technical_specification_key_types (
	id INT PRIMARY KEY,
	code VARCHAR(255) NOT NULL,
	rank INTEGER NOT NULL DEFAULT 999,
	CONSTRAINT unq_technicalspecificationkeytypes_code UNIQUE (code)
);

-- here are some basic types

INSERT INTO technical_specification_key_types (id,code) VALUES (1,'text');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',1,'en','name','Text');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',1,'cs','name','Text');

INSERT INTO technical_specification_key_types (id,code) VALUES (2,'integer');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',2,'en','name','Integer number');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',2,'cs','name','Číslo celočíselné');

INSERT INTO technical_specification_key_types (id,code) VALUES (3,'float');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',3,'en','name','Float');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',3,'cs','name','Decimal number');

INSERT INTO technical_specification_key_types (id,code) VALUES (4,'boolean');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',4,'en','name','Boolean');
INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('technical_specification_key_types',4,'cs','name','Boolean');

-- patching table technical_specification_keys

ALTER TABLE technical_specification_keys ADD technical_specification_key_type_id INT NOT NULL DEFAULT 1;
ALTER TABLE technical_specification_keys ADD CONSTRAINT fk_technicalspecificationkeys_types FOREIGN KEY (technical_specification_key_type_id) REFERENCES technical_specification_key_types;

ALTER TABLE technical_specification_keys ADD rank INT NOT NULL DEFAULT 999;

-- patching table technical_specifications

ALTER TABLE technical_specifications ADD content_json JSON; -- e.g. NULL or '{"integer":142}' or '{"float":12.34}' or '{"boolean":true}'...

-- indexes for basic types
CREATE INDEX in_technicalspecifications_contentjson_integer ON technical_specifications (((content_json ->> 'integer')::INT));
CREATE INDEX in_technicalspecifications_contentjson_float ON technical_specifications (((content_json ->> 'float')::FLOAT));
CREATE INDEX in_technicalspecifications_contentjson_boolean ON technical_specifications (((content_json ->> 'boolean')::BOOLEAN));

