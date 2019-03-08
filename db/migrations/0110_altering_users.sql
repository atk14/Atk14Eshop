ALTER TABLE users ADD pricelist_id INT NOT NULL DEFAULT 1;
ALTER TABLE users ADD CONSTRAINT fk_users_pricelists FOREIGN KEY (pricelist_id) REFERENCES pricelists;

ALTER TABLE users ADD base_pricelist_id INT DEFAULT 2;
ALTER TABLE users ADD CONSTRAINT fk_users_base_pricelists FOREIGN KEY (base_pricelist_id) REFERENCES pricelists;

ALTER SEQUENCE seq_users RESTART WITH 101;

-- not registered user
INSERT INTO users (login,password,name,pricelist_id,base_pricelist_id) VALUES('not_registered',null,'not registered user',1,2);
