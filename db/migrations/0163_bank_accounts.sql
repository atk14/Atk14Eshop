CREATE SEQUENCE seq_bank_accounts;
CREATE TABLE bank_accounts (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_bank_accounts'),
	--
	code VARCHAR(255),
	--
	active BOOLEAN NOT NULL DEFAULT TRUE,
	--
	regions JSON,
	currencies JSON,
	--
	account_number VARCHAR(255),
	iban VARCHAR(255),
	swift_bic VARCHAR(255),
	--
	holder_name VARCHAR(255),
	--
	bank_name VARCHAR(255),
	bank_address_street VARCHAR(255),
	bank_address_street2 VARCHAR(255),
	bank_address_city VARCHAR(255),
	bank_address_state VARCHAR(255),
	bank_address_zip VARCHAR(255),
	bank_address_country CHAR(2),
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_bankaccounts_code UNIQUE(code),
	CONSTRAINT fk_bankaccounts_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_bankaccounts_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

-- INSERT INTO bank_accounts (
-- 	id,
-- 	regions,
-- 	currencies,
-- 	account_number,
-- 	iban,
-- 	swift_bic,
-- 	holder_name,
-- 	bank_name,
-- 	bank_address_street,
-- 	bank_address_street2,
-- 	bank_address_city,
-- 	bank_address_state,
-- 	bank_address_zip,
-- 	bank_address_country
-- ) VALUES (
-- 	NEXTVAL('seq_bank_accounts'),
-- 	('{"'||(SELECT code FROM regions ORDER BY id LIMIT 1)||'": true}')::JSON,
-- 	'["CZK"]',
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.number'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.iban'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.swift_bic'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.holder'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.name'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.street'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.street2'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.city'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.state'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.zip'),
-- 	(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.address.country')
-- );
-- 
-- INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('bank_accounts',CURRVAL('seq_bank_accounts'),'en','name',(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.name'));
-- INSERT INTO translations (table_name,record_id,lang,key,body) VALUES('bank_accounts',CURRVAL('seq_bank_accounts'),'cs','name',(SELECT content FROM system_parameters WHERE code='merchant.billing_information.bank_account.bank.name'));
-- 
-- DELETE FROM system_parameters WHERE code LIKE 'merchant.billing_information.bank_account%';
