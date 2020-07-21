CREATE SEQUENCE seq_vouchers;
CREATE TABLE vouchers (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_vouchers'),
	regions JSON,
	active BOOLEAN DEFAULT TRUE NOT NULL,
	--
	voucher_code VARCHAR(255),
	repeatable BOOLEAN DEFAULT FALSE NOT NULL,
	minimal_items_price_incl_vat NUMERIC(20,6) DEFAULT 0.0 NOT NULL,
	--
	discount_amount NUMERIC(20,6) NOT NULL DEFAULT 0.0,
	discount_percent NUMERIC(5,2) NOT NULL DEFAULT 0.0,
	free_shipping BOOLEAN DEFAULT FALSE NOT NULL,
	--
	valid_from TIMESTAMP,
	valid_to TIMESTAMP,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_vouchers_vouchercode UNIQUE (voucher_code),
	CONSTRAINT chk_vouchers_vouchercode CHECK (voucher_code=UPPER(voucher_code)),
	--
	CONSTRAINT chk_vouchers_discountamount CHECK (discount_amount >= 0.0),
	CONSTRAINT chk_vouchers_discountpercent CHECK(discount_percent>=0.0 AND discount_percent<=100.0),
	CONSTRAINT chk_vouchers CHECK(free_shipping OR discount_amount>=0.0 OR discount_percent>=0.0), -- this constraint is dopped in 0159_altering_vouchers.sql
	--
	CONSTRAINT fk_vouchers_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_vouchers_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_basket_vouchers;
CREATE TABLE basket_vouchers (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_basket_vouchers'),
	basket_id INTEGER NOT NULL,
	voucher_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT unq_basketvouchers UNIQUE (basket_id,voucher_id),
	CONSTRAINT fk_basketvouchers_baskets FOREIGN KEY (basket_id) REFERENCES baskets ON DELETE CASCADE,
	CONSTRAINT fk_basketvouchers_vouchers FOREIGN KEY (voucher_id) REFERENCES vouchers ON DELETE CASCADE
);

CREATE SEQUENCE seq_order_vouchers;
CREATE TABLE order_vouchers (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_vouchers'),
	order_id INTEGER NOT NULL,
	voucher_id INTEGER NOT NULL,
	-- k voucherum u objednavky si musime poznacit i slevu v dane mene
	discount_amount NUMERIC(20,6) NOT NULL,
	created_administratively BOOLEAN NOT NULL DEFAULT FALSE,
	internal_note TEXT,
	--
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_ordervouchers UNIQUE (order_id,voucher_id),
	CONSTRAINT fk_ordervouchers_orders FOREIGN KEY (order_id) REFERENCES orders ON DELETE CASCADE,
	CONSTRAINT fk_ordervouchers_vouchers FOREIGN KEY (voucher_id) REFERENCES vouchers,
	--
	CONSTRAINT fk_ordervouchers_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_ordervouchers_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
CREATE INDEX in_ordervouchers_voucherid ON order_vouchers(voucher_id);
