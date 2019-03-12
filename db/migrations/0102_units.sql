CREATE SEQUENCE seq_units START WITH 11;
CREATE TABLE units (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_units'),
	unit VARCHAR(20) NOT NULL,
	--
	minimum_quantity_to_order INT DEFAULT 1 NOT NULL CHECK(minimum_quantity_to_order>0),
	quantity_step INT DEFAULT 1 NOT NULL CHECK(quantity_step>0),
	--
	display_unit VARCHAR(20) NOT NULL,
	display_unit_multiplier INT NOT NULL DEFAULT 1,
	minimum_stockcount_for_quantity_discounts INT NOT NULL DEFAULT 0,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_units_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_units_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

-- pieces
INSERT INTO units (id,unit,minimum_quantity_to_order,quantity_step,display_unit,display_unit_multiplier,minimum_stockcount_for_quantity_discounts) VALUES(1,'pcs',1,1,'pcs',1,0);
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('units','1','unit_localized','cs','ks');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('units','1','unit_localized','en','pcs');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('units','1','display_unit_localized','cs','ks');
INSERT INTO translations (table_name,record_id,key,lang,body) VALUES('units','1','display_unit_localized','en','pcs');

-- centimeters
INSERT INTO units (id,unit,minimum_quantity_to_order,quantity_step,display_unit,display_unit_multiplier,minimum_stockcount_for_quantity_discounts) VALUES(2,'cm',1,1,'m',100,2000);

-- grams
INSERT INTO units (id,unit,minimum_quantity_to_order,quantity_step,display_unit,display_unit_multiplier,minimum_stockcount_for_quantity_discounts) VALUES(3,'g',1,1,'kg',1000,5000);

