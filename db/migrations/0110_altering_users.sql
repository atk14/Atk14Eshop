ALTER TABLE users ADD pricelist_id INT NOT NULL DEFAULT 1;
ALTER TABLE users ADD CONSTRAINT fk_users_pricelists FOREIGN KEY (pricelist_id) REFERENCES pricelists;

ALTER TABLE users ADD base_pricelist_id INT DEFAULT 2;
ALTER TABLE users ADD CONSTRAINT fk_users_base_pricelists FOREIGN KEY (base_pricelist_id) REFERENCES pricelists;

ALTER SEQUENCE seq_users RESTART WITH 101;

-- anonymous, not registered user
INSERT INTO users (login,password,firstname,lastname,pricelist_id,base_pricelist_id) VALUES('anonymous',null,'anonym','anonymous',1,2);

ALTER TABLE users ADD gender_id INT;
ALTER TABLE users ADD CONSTRAINT fk_users_genders FOREIGN KEY (gender_id) REFERENCES genders;

ALTER TABLE users ADD company VARCHAR(255);
ALTER TABLE users ADD company_number VARCHAR(255);
ALTER TABLE users ADD vat_id VARCHAR(255);
ALTER TABLE users ADD address_street VARCHAR(255);
ALTER TABLE users ADD address_street2 VARCHAR(255);
ALTER TABLE users ADD address_city VARCHAR(255);
ALTER TABLE users ADD address_state VARCHAR(255);
ALTER TABLE users ADD address_zip VARCHAR(255);
ALTER TABLE users ADD address_country CHAR(2);
ALTER TABLE users ADD phone VARCHAR(255);
ALTER TABLE users ADD birthday DATE;
ALTER TABLE users ADD language CHAR(2);
